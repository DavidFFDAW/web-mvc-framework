<?php

class AuthGuard
{
    public static function handle($request)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        return true;
    }
}
