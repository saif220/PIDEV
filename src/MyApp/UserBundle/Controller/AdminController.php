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
        if(!$this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            return new RedirectResponse($this->get('router')->generate('my_app_user_homepage'));

        }
        return $this->render('MyAppUserBundle:Admin:add.html.twig', array('form' => $form->createView()));
    }



    public function listDrugAction(){
        //instantier l'entity manager
        $em = $this->getDoctrine()->getManager();
        $drugs = $em->getRepository('MyAppUserBundle:Drug')->findAll(); // recuperer les modeles de la BD
        //die("aa");
        return $this->render('MyAppUserBundle:Drug:listDrug.html.twig', array('drugs' => $drugs));
    }


    public function rechercheDrugAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $drugs = $em->getRepository("MyAppUserBundle:Drug")->findAll();
        if($request->isMethod("post"))
        {
            $critere = $request->get('nom');
            $drugs = $em->getRepository("MyAppUserBundle:Drug")->findBy(array('nom' => $critere));
        }
        return $this->render('MyAppUserBundle:Drug:rechercheDrug.html.twig',array('drugs' => $drugs));
    }


}