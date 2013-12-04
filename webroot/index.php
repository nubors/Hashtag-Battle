<?php
/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
require 'Slim/Slim.php';
use Slim\Slim;

\Slim\Slim::registerAutoloader();

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app = new \Slim\Slim(array(
    'debug' => true
));

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */

// GET route

// create a new battle
$app->get(
    '/create',
    function ($id) {
        $app = Slim::getInstance();
        
        // generate random id
        $id = uniqid();

        // create new battle

        // redirect to battle editing page
        $app->redirect('/edit/'.$id);
    }
);

$app->get(
    '/edit/:id',
    function ($id) {
        $app = Slim::getInstance();
        $app->render('header.php');
        $app->render('editor.php', array('id'=>$id));
        $app->render('footer.php');
    }
);

$app->get(
    '/:id',
    function ($id) {
        $app = Slim::getInstance();
        $app->render('header.php');
        $app->render('view.php', array('id'=>$id));
        $app->render('footer.php');
    }
);

$app->get(
    '/',
    function () {
        $app = Slim::getInstance();
        $app->render('header.php');
        $app->render('app.php');
        $app->render('footer.php');
    }
);

// POST route
$app->post(
    '/post',
    function () {
        echo 'This is a POST route';
    }
);

// PUT route
$app->put(
    '/put',
    function () {
        echo 'This is a PUT route';
    }
);

// PATCH route
$app->patch('/patch', function () {
    echo 'This is a PATCH route';
});

// DELETE route
$app->delete(
    '/delete',
    function () {
        echo 'This is a DELETE route';
    }
);

/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
