<?php
namespace Controllers;

class Register extends BaseController
{
    protected function initRoutes()
    {
        $this->app->get('/register', array($this, 'showForm'))->
            name('register');

        $this->app->post('/register', array($this, 'addUser'));
    }

    public function showForm()
    {
        $this->redirectIfLoggedIn();

        $this->app->flashNow('hideRegister', true);
        $this->app->render('register.twig');
    }

    public function addUser()
    {
        $this->redirectIfLoggedIn();

        $req = $this->app->request;
        $user = new \Models\User();
        list($errors, $fixes) = $user->create($req->post('email'),
                                              $req->post('username'),
                                              $req->post('password'),
                                              $req->post('passwordconfirm'));

        if (0 == count($fixes))
        {
            $this->app->flashNow('registered', true);
        }
        else
        {
            if (!is_null($req->post('email')))
            {
                $this->app->flashNow('femail', $req->post('email'));
            }

            if (!is_null($req->post('username')))
            {
                $this->app->flashNow('fusername', $req->post('username'));
            }

            $this->app->flashNow('errors', $errors);
            $this->app->flashNow('fixes', $fixes);
        }

        $this->app->flashNow('hideRegister', true);
        $this->app->render('register.twig', array('postLoginUrl' => $this->app->urlFor('home'))); // Change 'home' to be the page to go to after registering.
    }
}
