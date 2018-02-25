<?php

namespace MyApp\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MyAppShopBundle:Default:index.html.twig');
    }
}
