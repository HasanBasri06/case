<?php

namespace Http;

class Request
{
    public function __construct()
    {
    }

    public static function all() {
        return $_REQUEST;
    }

    public static function get(string $value) {
        return $_REQUEST[$value];
    }
}