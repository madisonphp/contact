<?php
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Yaml\Parser;

$app['debug'] = true;

$yaml = new Parser();

$config = $yaml->parse(file_get_contents(__DIR__ . '/../config.yaml'));

$app['swiftmailer.options'] = array(
    'host' => $config['swiftmailer']['host'],
    'port' => $config['swiftmailer']['port'],
    'username' => $config['swiftmailer']['username'],
    'password' => $config['swiftmailer']['password'],
);
