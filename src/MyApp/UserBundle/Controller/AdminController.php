<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07/02/2018
 * Time: 00:58
 */

namespace MyApp\UserBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('MyAppUserBundle:Admin:index.html.twig');
    }

}