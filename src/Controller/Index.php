<?php

namespace Digi\Keha\Controller;
use Digi\Keha\Kernel\Views;
use Digi\Keha\Kernel\AbstractController;


class Index extends AbstractController {

    public function index()
    {
        $view = new Views();
        $view->setHtml('accueil.html');
        $view->render([
            'flash' => $this->getFlashMessage(),
            'var' => 'je suis une variable',
        ]);
    }

    
}