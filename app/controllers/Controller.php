<?php
// app/controllers/controller.php
class Controller {
    protected function render($view, $data = []) {
        // Extract data to make variables available in views
        extract($data);
        
        // Set the content view to be included in the layout
        $content_view = $view;
        
        // Include the main layout
        require VIEW_PATH . '/layouts/main.php';
    }
}