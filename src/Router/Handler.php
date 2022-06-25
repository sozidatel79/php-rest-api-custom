<?php


namespace App\Router;


class Handler implements HandlerInterface
{

    private array $handlers;
    private $notFoundHandler;

    public function __construct(){
        $this->handlers = [];
    }

    public function add(string $method, string  $path, $handler): void {

        $this->handlers[$method . $path] = [
            'path' => $path,
            'method' => $method,
            'handler' => $handler,
        ];
    }

    public function getAll(): array {
        return $this->handlers;
    }

    public function addNotFoundHandler($handler): void {
        $this->notFoundHandler = $handler;
    }

    public function getNotFoundHandler() : callable {
        return $this->notFoundHandler;
    }
}