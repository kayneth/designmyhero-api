<?php

namespace DMH\ECommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('DMHECommerceBundle:Default:index.html.twig');
    }
}
