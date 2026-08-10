<?php
namespace App\Core;

class App
{
    protected $router;

    public function __construct()
    {
        $this->router = new Router();
        $this->loadRoutes();
    }

    private function loadRoutes()
    {
        // Require web and api routes
        require_once APP_PATH . '/../routes/web.php';
        require_once APP_PATH . '/../routes/api.php';
    }

    public function run()
    {
        $url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
        $method = $_SERVER['REQUEST_METHOD'];
        $this->router->dispatch($url, $method);
    }
}
