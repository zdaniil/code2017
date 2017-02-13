<?php
namespace Controllers;

use Classes\BaseController;

class IndexController extends BaseController
{

    public function index()
    {
        /*** set a template variable ***/
        $this->registry->view->welcome = 'Welcome to Code_IT task';

        /*** load the index template ***/
        $this->registry->view->show('index');
    }

}
?>