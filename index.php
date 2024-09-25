<?php
session_start();

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/app/helper.php';

(new \App\Kernel())->run();
