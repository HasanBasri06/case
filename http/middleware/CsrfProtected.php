<?php
namespace Http\Middleware;

use Http\Request;

class CsrfProtected {
     private static $csrf;
     public function __construct() {
          self::$csrf = $_SESSION['X-CSRF-TOKEN'];
     }

     public static function handle() {
          $class = new self;
          $request = new Request;
          
          if (!$request->has('X-CSRF-TOKEN') || $request->get('X-CSRF-TOKEN') !== $_SESSION['X-CSRF-TOKEN']) {
               throw new \Exception("419 Error");
          }
     }
}