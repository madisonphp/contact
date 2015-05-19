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

$published_menu = array(
    'Home' => 'http://2015.madisonphpconference.com/',
    //'Schedule' => 'http://2015.madisonphpconference.com/schedule/',
    //'Speakers' => '/speakers/',
    'Venue' => 'http://2015.madisonphpconference.com/venue/',
    'Hotel' => 'http://2015.madisonphpconference.com/hotel/',
    //'Sponsors' => 'http://2015.madisonphpconference.com/sponsors/',
    'What to Expect' => 'http://2015.madisonphpconference.com/expect/',
    'Organizers' => 'http://2015.madisonphpconference.com/organizers/',
    'Code of Conduct' => 'http://2015.madisonphpconference.com/conduct/',
    'Contact' => '/'
);

$app['nav'] = $published_menu;
