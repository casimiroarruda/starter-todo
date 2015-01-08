<?php
/**
 * Created by PhpStorm.
 * User: duodraco
 * Date: 07/01/15
 * Time: 11:11
 */

namespace Duodraco\StarterToDo\Controller;

use Duodraco\StarterToDo\Service\Settings;
use Respect\Rest\Routable;

class Task implements Routable
{
    protected $after;

    public function get()
    {
        /**
         * @var $render \Twig_Environment
         */
        $render = Settings::get('render');
        $mapper = Settings::get('taskMapper');
        $tasks = $mapper->findAll();
        usort($tasks, function ($task) {
            return $task->isDone() ? 1 : -1;
        });
        try {
            $page = $render->render('index.twig', ['tasks' => $tasks]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return $page;
    }

    public function put()
    {
        $task = new \Duodraco\StarterToDo\Model\Task();
        $task->setTitle(filter_var($_POST['title'], FILTER_SANITIZE_STRING));
        $task->setDone(false);
        $mapper = Settings::get('taskMapper');
        if ($mapper->save($task)) {
            $this->after = function () {
                header('Location:/');
            };
        }
        return;
    }

    public function post($id)
    {
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
        if(!$id){
            return false;//error
        }
        $mapper = Settings::get('taskMapper');
        $task = $mapper->findByIdentifier($id);
        if(!$task){
            return false;//error
        }
        if(isset($_POST['title'])){
            $task->setTitle(filter_var($_POST['title'], FILTER_SANITIZE_STRING));
        }
        if(isset($_POST['done']) && $_POST['done'] == 'true'){
            $task->setDone(true);
        }
        if ($mapper->save($task)) {
            $this->after = function () {
                header('Location:/');
            };
        }
        return;
    }

    public function create()
    {
        $render = Settings::get('render');
        return $render->render('create.twig');
    }

    public function edit($id)
    {
        $mapper = Settings::get('taskMapper');
        $task = $mapper->findByIdentifier($id);
        $render = Settings::get('render');
        return $render->render('edit.twig', ['task' => $task]);
    }

    public function after()
    {
        if (is_callable($this->after)) {
            call_user_func_array($this->after, []);
        }
    }
}
