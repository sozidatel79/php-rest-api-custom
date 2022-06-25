<?php


namespace App\Router;

interface HandlerInterface {
    public function add(string $method, string  $path, $handler);
    public function getAll();
    public function addNotFoundHandler($handler);
    public function getNotFoundHandler();
    
}
