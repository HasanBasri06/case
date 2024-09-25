<?php 

namespace Http\Middleware;

class Auth {
    public function __construct() {
        
    }

    static function handle() {
        return redirect('/login');
    }
}