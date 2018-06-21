<?php

namespace matyre73\LaravelApiExceptionHandler\Exceptions;

use App;
use Exception;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\Debug\Exception\FlattenException;

class ApiExceptionHandler extends ExceptionHandler
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var array
     */
    protected $responseArray = [];

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var \Symfony\Component\Debug\Exception\FlattenException
     */
    protected $exception;

    /**
     * Create a new exception handler instance.
     *
     * @param \Illuminate\Contracts\Container\Container $container
     * @return void
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    /**
     * @param array $config
     * @return $this
     */
    public function setExceptionConfigs(array $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * Rending an exception.
     *
     * @param \Illuminate\Http\Request $request
     * @param Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $e)
    {
        $this->request = $request;
        $this->statusCode = Response::HTTP_BAD_REQUEST;
        if (count($this->config['exceptionTypes'])) {
            foreach ($this->config['exceptionTypes'] as $type => $exception) {
                if ($e instanceof $exception['instance']) {
                    $this->statusCode = ($exception['status_code'] === null) ?
                        $e->getStatusCode(): $exception['status_code'];
                }
            }
        }

        return $this->setResponseArray($e)->responseJson();
    }

    /**
     * @param $exception
     * @param array $headers
     * @return $this
     */
    public function setResponseArray($exception, array $headers = array())
    {
        if (!$exception instanceof FlattenException) {
            $this->exception = FlattenException::create($exception, $this->statusCode, $headers);
        }

        $replacesments = [
            ':code' => $this->exception->getStatusCode(),
            ':status' => 'error',
            ':errors' => $this->getContent()
        ];

        $this->responseArray = array_merge($replacesments, $this->config['errorFormat']);
        return $this;
    }

    /**
     * Convert the given exception to an array.
     *
     * @return JsonResponse
     */
    protected function responseJson()
    {
        return new JsonResponse(
            $this->responseArray,
            $this->exception->getStatusCode(),
            $this->exception->getHeaders(),
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
        );
    }

    /**
     * Gets the Array content associated with the given exception.
     *
     * @return array The content as a array
     */
    public function getContent()
    {
        $content = [];
        try {
            foreach ($this->exception->toArray() as $position => $e) {
                $class = $this->formatClass($e['class']);

                $content_item = [
                    'type' => $class,
                    'message' => $this->formatMessage($e['message'], $position),
                ];
                if (config('app.debug')) {
                    $content_item['context']['backtrace'] = $this->formatBackTrace($e['trace']);
                }

                $content[] = $content_item;
            }
        } catch (\Exception $e) {
            // something nasty happened and we cannot throw an exception anymore
            return [
                'type' =>  get_class($e),
                'message' => sprintf(
                    'Exception thrown when handling an exception (%s: %s)',
                    get_class($e),
                    $e->getMessage()
                ),
            ];
        }

        return $content;
    }

    /**
     * @param $class
     * @return mixed
     */
    private function formatClass($class)
    {
        $parts = explode('\\', $class);
        return array_pop($parts);
    }

    /**
     * @param string $message
     * @param int $position
     * @return string
     */
    private function formatMessage($message, $position)
    {
        $json = json_decode($message, true);
        $message = empty($json) ? nl2br($message) : $json;

        return (empty($message) && ((count($this->exception->getAllPrevious()) - $position) + 1) == 1) ?
            __('messages.error' . $this->exception->getStatusCode() . 'message') : $message;
    }

    /**
     * @param array $exceptionTrace
     * @return array
     */
    private function formatBackTrace($exceptionTrace)
    {
        $backTraces = [];
        foreach ($exceptionTrace as $trace) {
            $bkTrace['source'] = '';

            if ($trace['function']) {
                $bkTrace['source'] = sprintf(
                    'at %s%s%s(%s) ',
                    $this->formatClass($trace['class']),
                    $trace['type'],
                    $trace['function'],
                    $this->formatArgs($trace['args'])
                );

                $bkTrace['class'] = $trace['class'];
            }

            if (isset($trace['file']) && isset($trace['line'])) {
                $bkTrace['source'] .= $this->formatPath($trace['file'], $trace['line']);
                $bkTrace['path'] = $this->formatLink($trace['file'], $trace['line']);
            }

            $backTraces[] = $bkTrace;
            unset($bkTrace);
        }
        return $backTraces;
    }

    /**
     * @param string $path
     * @param int $line
     * @return string
     */
    private function formatPath($path, $line)
    {
        $file = preg_match('#[^/\\\\]*+$#', $path, $file) ? $file[0] : $path;
        return sprintf('in %s (line %d)', $file, $line);
    }

    /**
     * @param string $path
     * @param int $line
     * @return string
     */
    private function formatLink($path, $line)
    {
        $fmt = get_cfg_var('xdebug.file_link_format');
        if ($fmt &&
            $link = is_string($fmt) ? strtr($fmt, array('%f' => $path, '%l' => $line)) : $fmt->format($path, $line)) {
            return sprintf('%s', $link);
        }
        return sprintf('%s', $path);
    }

    /**
     * Formats an array as a string.
     *
     * @param array $args The argument array
     *
     * @return string
     */
    private function formatArgs(array $args)
    {
        $result = array();
        foreach ($args as $key => $item) {
            if ('object' === $item[0]) {
                $formattedValue = sprintf('object (%s)', $this->formatClass($item[1]));
            } elseif ('array' === $item[0]) {
                $formattedValue = sprintf('array (%s)', is_array($item[1]) ? $this->formatArgs($item[1]) : $item[1]);
            } elseif ('null' === $item[0]) {
                $formattedValue = 'null';
            } elseif ('boolean' === $item[0]) {
                $formattedValue = strtolower(var_export($item[1], true));
            } elseif ('resource' === $item[0]) {
                $formattedValue = 'resource';
            } else {
                $formattedValue = str_replace("\n", '', var_export($item[1], true));
            }

            $result[] = is_int($key) ? $formattedValue : sprintf("'%s' => %s", $key, $formattedValue);
        }
        return implode(', ', $result);
    }
}
