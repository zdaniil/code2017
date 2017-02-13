<?php

namespace Controllers;

use Classes\BaseController;

class userController extends BaseController
{

    /**
     *
     */
    public function add()
    {
        /*** set a template variable ***/
        $this->registry->view->title = 'Registration page';

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (empty($_POST['email'])) {
                $errors['email'] = 'This field is required';
            }
            if (empty($_POST['login'])) {
                $errors['login'] = 'This field is required';
            }
            if (empty($_POST['password'])) {
                $errors['password'] = 'This field is required';
            }
            if (empty($_POST['real_name'])) {
                $errors['real_name'] = 'This field is required';
            }
            if (empty($_POST['date_of_birthday'])) {
                $errors['date_of_birthday'] = 'This field is required';
            }
            if (empty($_POST['date_of_registration'])) {
                $errors['date_of_registration'] = 'This field is required';
            }
            if (empty($_POST['country'])) {
                $errors['country'] = 'This field is required';
            }

            if (empty($errors)) {
                $user = new \Models\user();

                $inertedId = $user->add([
                    'email' => $_POST['email'],
                    'login' => $_POST['login'],
                    'password' => $_POST['password'],
                    'real_name' => $_POST['real_name'],
                    'date_of_birthday' => $_POST['date_of_birthday'],
                    'date_of_registration' => time()
                ]);

                $this->registry->view->message = $_POST['login']. ' was added. ID - '. $inertedId;//записываем данные в view
                }
        }

        /*** load the index template ***/
        $this->registry->view->errors = $errors;
        $this->registry->view->show('add');
    }
    }
?>