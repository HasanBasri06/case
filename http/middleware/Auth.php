<?php 

namespace Http\Middleware;

use Http\Auth as HttpAuth;

class Auth {
    public function __construct() {
        
    }

    public static function handle() {
        if (!HttpAuth::check()) {
            return redirect('/login');
        }       
    }
}