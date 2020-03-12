<?php
declare(strict_types=1);

namespace src\controller;

class WelcomeController {
    public function welcome(): void {
        print_r("Hi");
    }

    public function welcomeUser(string $userName): void {
        print($userName);die("Iside controller baby");
    }
}
