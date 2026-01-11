<?php
/**
 * Base controller class
 */

class BaseController {
    protected function render($view, $data = []) {
        extract($data);
        $viewPath = __DIR__ . '/../Views/' . $view . '.php';
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            die("View not found: $view");
        }
    }

    protected function redirect($path) {
        header('Location: ' . $path);
        exit;
    }

    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
