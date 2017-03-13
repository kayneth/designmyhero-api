<?php

namespace DMH\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DMHUserBundle:Default:index.html.twig');
    }
}
