<?php

namespace App\Controller;

use Http\Request;

class BasketController {
    public function myBasket(): array {
        $baskets = ["laptop", "bisiklet", "tarak"];
        return view('basket', ["baskets" => $baskets]);
    }

    public function saveBasket(): array {
        $request = new Request();

        return $request->all();
    }

    public function userDetail(int $x, string $y): array   {
        return [$x, $y];
    }
}