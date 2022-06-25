<?php


namespace App\Router;


interface RouterInterface
{
    public function get(string $path, $handler): void;
    public function post(string $path, $handler): void;
    public function patch(string $path, $handler): void;
    public function delete(string $path, $handler): void;
    public function dispatch();
}