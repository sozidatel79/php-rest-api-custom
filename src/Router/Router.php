<?php


namespace App\Router;


class Router implements RouterInterface
{
    private const METHOD_GET = 'GET';
    private const METHOD_POST = 'POST';
    private const METHOD_PATCH = 'PATCH';
    private const METHOD_DELETE = 'DELETE';
    private HandlerInterface $handler;

    public function __construct(HandlerInterface $handler)
    {
        $this->handler = $handler;
    }

    public function get(string $path, $handler): void
    {
        $this->handler->add(self::METHOD_GET, $path, $handler);
    }

    public function post(string $path, $handler): void
    {
        $this->handler->add(self::METHOD_POST, $path, $handler);
    }

    public function patch(string $path, $handler): void
    {
        $this->handler->add(self::METHOD_PATCH, $path, $handler);
    }

    public function delete(string $path, $handler): void
    {
        $this->handler->add(self::METHOD_DELETE, $path, $handler);
    }

    public function dispatch(): void
    {
        $requestURI = parse_url($_SERVER['REQUEST_URI']);
        $path = $requestURI['path'];
        $method = $_SERVER['REQUEST_METHOD'];
        $callback = null;
        foreach ($this->handler->getAll() as $handler) {
            if ($handler['path'] === $path && $handler['method'] === $method) {
                $callback = $handler['handler'];
            }
        }

        if (is_string($callback)) {
            $parts = explode('::', $callback);
            $method = $parts[1];
            call_user_func($method, '');
        }

        $this->handler->addNotFoundHandler(function () {
            $data = [
                'status' => 'error',
                'message' => 'method not allowed or rout not defined'
            ];
            echo json_encode($data);
        });

        if (!$callback) {
            header("HTTP/1.0 404 Not Found");
            if (!empty($this->handler->getNotFoundHandler())) {
                $callback = $this->handler->getNotFoundHandler();
            }
        }

        call_user_func_array($callback, [
            array_merge($_POST, $_GET)
        ]);
    }
}
