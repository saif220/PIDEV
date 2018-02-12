<?php

namespace MyApp\DoctorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MyAppDoctorBundle:Default:index.html.twig');
    }
}
