<?php
namespace App\Core;

class Controller
{
    protected function view($view, $data = [])
    {
        // Extract data to make variables available in the view
        extract($data);
        
        $viewFile = APP_PATH . '/../views/' . $view . '.php';
        
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View does not exist: " . $viewFile);
        }
    }

    protected function json($data, $status = 200)
    {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
        exit;
    }

    protected function redirect($url)
    {
        header('Location: ' . $_ENV['APP_URL'] . '/' . ltrim($url, '/'));
        exit;
    }
}
