<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/02/2018
 * Time: 13:12
 */

namespace MyApp\DoctorBundle\Controller;


use MyApp\DoctorBundle\Entity\Cabinet;
use MyApp\DoctorBundle\Form\CabinetType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CabinetController extends Controller
{

    public function addAction(Request $request){

        $cabinet = new Cabinet();
        $form = $this->createForm(CabinetType::class, $cabinet);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cabinet);
            $em->flush();
            return $this->redirect($this->generateUrl('fos_user_profile'));
        }
        return $this->render('MyAppDoctorBundle:Cabinet:addCabinet.html.twig', array('form' => $form->createView()));
    }



    public function listCabinetAction(){
        //instantier l'entity manager
        $em = $this->getDoctrine()->getManager();
        $cabinets = $em->getRepository('MyAppDoctorBundle:Cabinet')->findAll(); // recuperer les modeles de la BD
        //die("aa");
        return $this->render('MyAppDoctorBundle:Cabinet:listCabinet.html.twig', array('cabinets' => $cabinets));
    }

}