<?php

class BaseModel {
    public $db;
    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }
}