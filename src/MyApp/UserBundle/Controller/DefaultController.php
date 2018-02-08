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
        return $this->render('MyAppUserBundle:Pages:Contact.html.twig');
    }

    public function DoctorAction()
    {
        return $this->render('MyAppUserBundle:Pages:Doctor.html.twig');
    }

    public function BlogAction()
    {
        return $this->render('MyAppUserBundle:Pages:Blog.html.twig');
    }

    public function ShopAction()
    {
        return $this->render('MyAppUserBundle:Pages:Shop.html.twig');
    }

    public function EventsAction()
    {
        return $this->render('MyAppUserBundle:Pages:Events.html.twig');
    }

}
