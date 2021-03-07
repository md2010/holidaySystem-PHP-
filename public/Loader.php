<?php

namespace {

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Loader 
{
    public static function load()
    {
        $loader = new FilesystemLoader(__DIR__ . '/templates');
        $twig = new Environment($loader);
        return $twig;
    }
}

}