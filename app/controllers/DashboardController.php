<?php
class DashboardController {
    public function index() {
        $content_view = 'pages/home';
        include VIEW_PATH . '/layouts/main.php';
    }

    public function login() {
        $content_view = 'pages/login';
        include VIEW_PATH . '/layouts/main.php';
    }
}
