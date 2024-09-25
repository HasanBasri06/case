<?php 

namespace Http;

use App\Model\User;

class Auth {
    public function __construct() {
    }

    public static function attempt($email, $password) {
        $existUser = User::table()
            ->where([
                'email' => $email,
                'password' => $password
            ])
            ->exist();

        if ($existUser) {
            $user = User::table()
                ->where([
                    'email' => $email,
                    'password' => $password
                ])
                ->first();

            $_SESSION['user'] = $user;

            return [
                'message' => 'Başarılı'
            ];
        }

        return [
            'message' => 'Hata'
        ];
    }

    public static function user() {
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }

    public static function id() {
        return isset($_SESSION['user']) ? $_SESSION['user']->id : null;
    }

    public static function check() {
        return isset($_SESSION['user']) ? true : false;
    }

    public static function logout() {
        session_destroy();
        unset($_SESSION['user']);

        return redirect();
    }
}