<?php
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

$app['debug'] = true;

$app['swiftmailer.options'] = array(
    'host' => 'localhost',
    'port' => 25,
    'username' => '',
    'password' => '',
    'encryption' => null,
    'auth_mode' => null,
);
