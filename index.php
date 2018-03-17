<?php
header("Access-Control-Allow-Origin: *");

require __DIR__ . '/vendor/autoload.php';

use google\appengine\api\cloud_storage\CloudStorageTools;
use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Request;

// create the Silex application
$app = new Application();
$app->register(new TwigServiceProvider());
$app['twig.path'] = [ __DIR__ ];

// This variable should holde your Google Storage bucket name.
// Your bucket name is usually of the format: 
// {project-id}.appspot.com 
$app['bucket_name'] = 'YOUR-PROJECT_ID.appspot.com';

$app->get('/', function () use ($app) {
    $bucket = $app['bucket_name'];
    $image = $_GET['image'];

    $image_file = "gs://${bucket}/${image}";
    $image_url = CloudStorageTools::getImageServingUrl($image_file, array('secure_url' => true));

    return $app->json(array(
        'url' => $image_url
    ));
});

$app->delete('/', function () use ($app) {
    $bucket = $app['bucket_name'];
    $image = $_GET['image'];

    $image_file = "gs://${bucket}/${image}";
    CloudStorageTools::deleteImageServingUrl($image_file);

    return $app->json(array());
});

$app['debug'] = true; // Turn off debugging here
$app->run();
