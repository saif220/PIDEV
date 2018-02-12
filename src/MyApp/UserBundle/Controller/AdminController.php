<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 07/02/2018
 * Time: 00:58
 */

namespace MyApp\UserBundle\Controller;
use MyApp\UserBundle\Entity\Drug;
use MyApp\UserBundle\Form\DrugType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    public function indexAction()
    {

        if (!$this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            return new RedirectResponse($this->get('router')->generate('my_app_user_homepage'));

        }
        return $this->render('MyAppUserBundle:Admin:index.html.twig');
    }


    public function addAction(Request $request){

        $drug = new Drug();
        $form = $this->createForm(DrugType::class, $drug);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($drug);
            $em->flush();
            return $this->redirect($this->generateUrl('Admin'));
        }
        if($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            return new RedirectResponse($this->get('router')->generate('my_app_user_homepage'));

        }
        return $this->render('MyAppUserBundle:Admin:add.html.twig', array('form' => $form->createView()));
    }
}