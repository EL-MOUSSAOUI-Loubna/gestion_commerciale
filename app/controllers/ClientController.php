<?php
class ClientController {
    public function index() {
        $content_view = 'pages/clients/index';
        include VIEW_PATH . '/layouts/main.php';
    }

    public function add() {
        $content_view = 'pages/clients/add';
        include VIEW_PATH . '/layouts/main.php';
    }

}
