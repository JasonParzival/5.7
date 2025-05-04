<?php

abstract class BaseController {
    public PDO $pdo; 
    public array $params; 

    
    public function setParams(array $params) {
        $this->params = $params;
    }

    public function setPDO(PDO $pdo) { 
        $this->pdo = $pdo;
    }
    
    public function getContext(): array {
        return [];
    }

    public function process_response() {
        $method = $_SERVER['REQUEST_METHOD'];
        $context = $this->getContext(); // вызываю context тут
        if ($method == 'GET') {
            $this->get($context); // а тут просто его пробрасываю внутрь
        } else if ($method == 'POST') {
            $this->post($context); // и здесь
        }
    }

    public function get(array $context) {} // ну и сюда добавил в качестве параметра 
    public function post(array $context) {} // и сюда
}