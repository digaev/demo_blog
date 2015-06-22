<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class HttpError
{
    private $_ci;
    private $_errors = [
        '400' => 'Bad Request',
        '401' => 'Unauthorized',
        '404' => 'Not Found',
        '405' => 'Method Not Allowed'
    ];

    public function __construct()
    {
        $this->_ci = &get_instance();
    }

    public function show($code)
    {
        $text = htmlspecialchars("$code - {$this->_errors[$code]}");

        $this->_ci->output->set_status_header($code);
        $this->_ci->output->set_output(
            '<!DOCTYPE html>' .
            "<html><head><title>$text</title></head>" .
            "<body><center><h1>$text</h1></center><hr /></body>"
        );
    }
}
