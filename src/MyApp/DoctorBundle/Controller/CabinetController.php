<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 12/02/2018
 * Time: 13:12
 */

namespace MyApp\DoctorBundle\Controller;


use MyApp\DoctorBundle\Entity\Cabinet;
use MyApp\DoctorBundle\Entity\RDV;
use MyApp\DoctorBundle\Form\CabinetType;
use MyApp\DoctorBundle\Form\RDVType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CabinetController extends Controller
{

    public function addAction(Request $request){
         $user=$this->getUser();
         if ($user->getRole()==null){
             die('impossible de joindre la page');
         }else{

        $cabinet = new Cabinet();
        $cabinet->setUser($user);
        $form = $this->createForm(CabinetType::class, $cabinet);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cabinet);
            $em->flush();
            return $this->redirect($this->generateUrl('listCabinet'));
        }
        return $this->render('MyAppDoctorBundle:Cabinet:addCabinet.html.twig', array('form' => $form->createView()));
    }}



    public function listCabinetAction(){
        //instantier l'entity manager
        $em = $this->getDoctrine()->getManager();
        $cabinets = $em->getRepository('MyAppDoctorBundle:Cabinet')->findAll(); // recuperer les modeles de la BD
        //die("aa");
        return $this->render('MyAppDoctorBundle:Cabinet:listCabinet.html.twig', array('cabinets' => $cabinets));
    }


    public function rechercheCabinetAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cabinets = $em->getRepository("MyAppDoctorBundle:Cabinet")->findAll();
        if($request->isMethod("post"))
        {
            $critere = $request->get('specialite');
            $cabinets = $em->getRepository("MyAppDoctorBundle:Cabinet")->findBy(array('specialite' => $critere));
        }
        return $this->render('MyAppDoctorBundle:Cabinet:rechercheCabinet.html.twig',array('cabinets' => $cabinets));
    }

    public function mapAction()
    {
        $name='name';
        return $this->render('MyAppDoctorBundle:Cabinet:map.html.twig', array('name'=>$name));
    }

    public function MyCabinetAction()
    {$user=$this->getUser();
        $id=$user->getId();



        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT v From MyAppDoctorBundle:Cabinet v  
                                          WHERE v.user = :id')->setParameter('id',$id);
        $cabinets = $query->getResult();
        return $this->render('MyAppDoctorBundle:Cabinet:MyCabinet.html.twig',array("cabinets"=>$cabinets));



    }


    public function CabinetAction($spec){

        $em = $this->getDoctrine()->getManager();
        $specialites = $em->getRepository("MyAppDoctorBundle:Cabinet")->findOneBy(array('specialite'=> $spec));
       if($specialites){
           $nom=$specialites->getNomDocteur();

       }else{
           $nom= null;
       }
        $response=new JsonResponse();
        return $response->setData(array('nomDocteur'=>$nom));



    }

    public function deleteAction($id){
        //instantier l'entity manager
        $em = $this->getDoctrine()->getManager();
        $cabinet = $em->getRepository('MyAppDoctorBundle:Cabinet')->find($id); // recuperer le modele de la BD
        //die("aa");
        $em->remove($cabinet);
        $em->flush();
        return ($this->redirectToRoute("Add_Cabinet"));

    }

    public function reservationAction()
    {
        return $this->render('MyAppDoctorBundle:Cabinet:reservation.html.twig');
    }

    public function Reservation1Action(){

        $day="Monday";
        $hour="9h-10h";
        $rdv = new RDV();
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


}


    public function updaterdvAction(Request $request)
    {
        $id= $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $Rdv = $em->getRepository("MyAppDoctorBundle:RDV")->find($id);
        $form = $this->createForm(RDVType::class,$Rdv);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $em->persist($Rdv);
            $em->flush();
            return $this->redirectToRoute('reservation');
        }
        return $this->render('MyAppDoctorBundle:Cabinet:updaterdv.html.twig',array("form"=>$form->createView()));
    }



}