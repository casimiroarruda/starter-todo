<?php
require __DIR__ . '/../vendor/autoload.php';

use Duodraco\StarterToDo\Controller\Task;
use Duodraco\StarterToDo\Service\Settings;
use Lcobucci\DependencyInjection\Config\Handlers\ContainerAware;
use Lcobucci\DependencyInjection\ContainerBuilder;
use Lcobucci\DependencyInjection\Generators\Yaml;

$container = (new ContainerBuilder())->setGenerator(new Yaml())
    ->addPath(__DIR__ . '/settings')
    ->addFile('setup.yml')
    ->useDevelopmentMode()
    ->setDumpDir(__DIR__ . '/tmp')
    ->setParameter('app.basedir', __DIR__)
    ->addHandler(new ContainerAware())
    ->getContainer();

Settings::setContainer($container);

$router = new \Respect\Rest\Router;
$router->methodOverriding = true;
$taskController = new Task();
$router->get('/', $taskController);
$router
    ->any('/task/*', $taskController)
    ->through([$taskController,'after']);
$router->get('/task.create', [$taskController,'create']);
$router->get('/task.edit/*', [$taskController,'edit']);
$router->get('/phpinfo',function(){return phpinfo();});
