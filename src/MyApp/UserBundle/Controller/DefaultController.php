<?php

namespace MyApp\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MyAppUserBundle:Default:index.html.twig');
    }

    public function ContactAction()
    {
        return $this->render('MyAppUserBundle:Contact:Contact.html.twig');
    }

}
