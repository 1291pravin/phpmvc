<?php

class Controller {

    public $params = [];
    protected $input = [];

    function __construct() {
        $this->input = json_decode(file_get_contents("php://input"), true);
    }

    public function setParams($params) {
        $this->params = array_merge($this->vars, $d);
    }

    protected function _sendResponse($data = [], $response_code = 200) {
        http_response_code($response_code);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function pageNotFound() {
        $this->_sendResponse(['error' => 'Invalid Resource'], 404);
    }

}

?>