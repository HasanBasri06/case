<?php

namespace App;

class Kernel
{
    public function run() {
        $routes = include __DIR__ . '/web.php';
    }
}