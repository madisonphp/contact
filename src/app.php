<?php
use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\LocaleServiceProvider;
use Silex\Provider\RoutingServiceProvider;
use Silex\Provider\SwiftmailerServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ValidatorServiceProvider;

$app = new Application();
$app->register(new FormServiceProvider());
$app->register(new LocaleServiceProvider());
$app->register(new RoutingServiceProvider());
$app->register(new SwiftmailerServiceProvider());
$app->register(new TranslationServiceProvider(), array(
    'translator.domains' => array(),
));
$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views',
));
$app->register(new ValidatorServiceProvider());

return $app;
