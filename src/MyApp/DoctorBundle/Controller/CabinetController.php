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
use Symfony\Component\HttpFoundation\Response;


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
            $query = $em->createQuery(
                'SELECT v From MyAppDoctorBundle:Cabinet v  
                                          WHERE v.specialite = :critere OR v.nomDocteur = :critere')->setParameter('critere',$critere);
            $cabinets = $query->getResult();
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


    public function MyReservationAction()
    {$user=$this->getUser();
        $nom=$user->getUsername();



        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT v From MyAppDoctorBundle:RDV v  
                                          WHERE v.doctorname = :nom')->setParameter('nom',$nom);
        $rdv = $query->getResult();
        return $this->render('MyAppDoctorBundle:Cabinet:MyReservation.html.twig',array("rdv"=>$rdv));



    }



    public function quizAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $quizs = $em->getRepository("MyAppDoctorBundle:Quiz")->findAll();
        if($request->isMethod("post"))
        {
            $age = $request->get('age');
            $sexe = $request->get('sexe');
            $douleur = $request->get('douleur');

            $query = $em->createQuery(
                "SELECT v.type From MyAppDoctorBundle:Quiz v  
                                          WHERE v.age = :age AND v.sexe = :sexe AND v.douleur= :douleur")->setParameter('age',$age)
                                                                                                        ->setParameter('sexe',$sexe)
                                                                                                        ->setParameter('douleur',$douleur);
            $quizs2 = $query->getResult();
            return $this->render('MyAppDoctorBundle:Cabinet:quiz.html.twig',array('quizs2' => $quizs2));
        }else{

            return $this->render('MyAppDoctorBundle:Cabinet:quiz.html.twig',array('quizs' => $quizs));
        }

    }



    public function annulerrdvAction($id){
        //instantier l'entity manager
        $em = $this->getDoctrine()->getManager();
        $rdv = $em->getRepository('MyAppDoctorBundle:RDV')->find($id); // recuperer le modele de la BD
        //die("aa");
        $em->remove($rdv);
        $em->flush();
        return ($this->redirectToRoute("findRdv"));

    }

    public function pdfAction(Request $request)
    {

        $snappy=$this->get("knp_snappy.pdf");

        $html=$this->renderView("MyAppDoctorBundle:Cabinet:reservationpdf.html.twig",array(
           "Title"=> "Reservation de Rendez-vous"
        ));

        $filename="Reservation";

        return new Response(
            $snappy->getOutputFromHtml($html),

            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="'.$filename.'.pdf"'
            )

        );






    }




    public function resetrdvAction($named){
        //instantier l'entity manager
        $em = $this->getDoctrine()->getManager();
        $rdv = $em->getRepository('MyAppDoctorBundle:RDV')->findby(array('doctorname' => $named)); // recuperer le modele de la BD
        //die("aa");
        foreach ($rdv as $o)
        {$em->remove($o);
        $em->flush();}
        return ($this->redirectToRoute("listCabinet"));

    }































    public function reservationAction($userd)
    {

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            "SELECT v.day,v.hour,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Monday' AND v.hour = '9h-10h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvs = $query->getResult();

        $queryTu9 = $em->createQuery(
            "SELECT v.day,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Tuesday' AND v.hour = '9h-10h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvsTu9 = $queryTu9->getResult();

        $queryWe9 = $em->createQuery(
            "SELECT v.day,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Wednesday' AND v.hour = '9h-10h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvsWe9 = $queryWe9->getResult();

        $queryTh9 = $em->createQuery(
            "SELECT v.day,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Thursday' AND v.hour = '9h-10h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvsTh9 = $queryTh9->getResult();

        $queryFr9 = $em->createQuery(
            "SELECT v.day,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Friday' AND v.hour = '9h-10h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvsFr9 = $queryFr9->getResult();


        $queryMo10 = $em->createQuery(
            "SELECT v.day,v.hour,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Monday' AND v.hour = '10h-11h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvsMo10 = $queryMo10->getResult();

        $queryTu10 = $em->createQuery(
            "SELECT v.day,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Tuesday' AND v.hour = '10h-11h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvsTu10 = $queryTu10->getResult();

        $queryWe10 = $em->createQuery(
            "SELECT v.day,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Wednesday' AND v.hour = '10h-11h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvsWe10 = $queryWe10->getResult();

        $queryTh10 = $em->createQuery(
            "SELECT v.day,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Thursday' AND v.hour = '10h-11h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvsTh10 = $queryTh10->getResult();

        $queryFr10 = $em->createQuery(
            "SELECT v.day,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Friday' AND v.hour = '10h-11h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvsFr10 = $queryFr10->getResult();



        $queryMo11 = $em->createQuery(
            "SELECT v.day,v.hour,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Monday' AND v.hour = '11h-12h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvsMo11 = $queryMo11->getResult();

        $queryTu11 = $em->createQuery(
            "SELECT v.day,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Tuesday' AND v.hour = '11h-12h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvsTu11 = $queryTu11->getResult();

        $queryWe11 = $em->createQuery(
            "SELECT v.day,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Wednesday' AND v.hour = '11h-12h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvsWe11 = $queryWe11->getResult();

        $queryTh11 = $em->createQuery(
            "SELECT v.day,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Thursday' AND v.hour = '11h-12h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvsTh11 = $queryTh11->getResult();

        $queryFr11 = $em->createQuery(
            "SELECT v.day,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Friday' AND v.hour = '11h-12h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvsFr11 = $queryFr11->getResult();


        $queryMo14 = $em->createQuery(
            "SELECT v.day,v.hour,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Monday' AND v.hour = '14h-15h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvsMo14 = $queryMo14->getResult();

        $queryTu14 = $em->createQuery(
            "SELECT v.day,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Tuesday' AND v.hour = '14h-15h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvsTu14 = $queryTu14->getResult();

        $queryWe14 = $em->createQuery(
            "SELECT v.day,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Wednesday' AND v.hour = '14h-15h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvsWe14 = $queryWe14->getResult();

        $queryTh14 = $em->createQuery(
            "SELECT v.day,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Thursday' AND v.hour = '14h-15h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvsTh14 = $queryTh14->getResult();

        $queryFr14 = $em->createQuery(
            "SELECT v.day,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Friday' AND v.hour = '14h-15h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvsFr14 = $queryFr14->getResult();



        $queryMo15 = $em->createQuery(
            "SELECT v.day,v.hour,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Monday' AND v.hour = '15h-16h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvsMo15 = $queryMo15->getResult();

        $queryTu15 = $em->createQuery(
            "SELECT v.day,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Tuesday' AND v.hour = '15h-16h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvsTu15 = $queryTu15->getResult();

        $queryWe15 = $em->createQuery(
            "SELECT v.day,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Wednesday' AND v.hour = '15h-16h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvsWe15 = $queryWe15->getResult();

        $queryTh15 = $em->createQuery(
            "SELECT v.day,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Thursday' AND v.hour = '15h-16h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvsTh15 = $queryTh15->getResult();

        $queryFr15 = $em->createQuery(
            "SELECT v.day,v.doctorname From MyAppDoctorBundle:RDV v  
                                          WHERE v.day = 'Friday' AND v.hour = '15h-16h' AND v.doctorname= :userd")->setParameter('userd',$userd);
        $rdvsFr15 = $queryFr15->getResult();


        return $this->render('MyAppDoctorBundle:Cabinet:reservation.html.twig',array("rdvs"=>$rdvs,"userd"=>$userd,
                                                                                        "rdvsTu9"=>$rdvsTu9,"rdvsWe9"=>$rdvsWe9,
                                                                                        "rdvsTh9"=>$rdvsTh9,"rdvsFr9"=>$rdvsFr9,"rdvsMo10"=>$rdvsMo10,
                                            "rdvsTu10"=>$rdvsTu10,"rdvsWe10"=>$rdvsWe10,
                                            "rdvsTh10"=>$rdvsTh10,"rdvsFr10"=>$rdvsFr10,
            "rdvsMo11"=>$rdvsMo11,"rdvsTu11"=>$rdvsTu11,"rdvsWe11"=>$rdvsWe11,
            "rdvsTh11"=>$rdvsTh11,"rdvsFr11"=>$rdvsFr11,
            "rdvsMo14"=>$rdvsMo14,"rdvsTu14"=>$rdvsTu14,"rdvsWe14"=>$rdvsWe14,
            "rdvsTh14"=>$rdvsTh14,"rdvsFr14"=>$rdvsFr14,
            "rdvsMo15"=>$rdvsMo15,"rdvsTu15"=>$rdvsTu15,"rdvsWe15"=>$rdvsWe15,
            "rdvsTh15"=>$rdvsTh15,"rdvsFr15"=>$rdvsFr15));
    }

    public function Reservation1Action($userd){

        $day="Monday";
        $hour="9h-10h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


}



    public function Reservation2Action($userd){

        $day="Tuesday";
        $hour="9h-10h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


    }


    public function Reservation3Action($userd){

        $day="Wednesday";
        $hour="9h-10h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


    }


    public function Reservation4Action($userd){

        $day="Thursday";
        $hour="9h-10h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


    }


    public function Reservation5Action($userd){

        $day="Friday";
        $hour="9h-10h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


    }



    public function Reservation6Action($userd){

        $day="Monday";
        $hour="10h-11h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


    }



    public function Reservation7Action($userd){

        $day="Tuesday";
        $hour="10h-11h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


    }


    public function Reservation8Action($userd){

        $day="Wednesday";
        $hour="10h-11h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


    }


    public function Reservation9Action($userd){

        $day="Thursday";
        $hour="10h-11h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


    }


    public function Reservation10Action($userd){

        $day="Friday";
        $hour="10h-11h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


    }




    public function Reservation11Action($userd){

        $day="Monday";
        $hour="11h-12h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


    }



    public function Reservation12Action($userd){

        $day="Tuesday";
        $hour="11h-12h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


    }


    public function Reservation13Action($userd){

        $day="Wednesday";
        $hour="11h-12h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


    }


    public function Reservation14Action($userd){

        $day="Thursday";
        $hour="11h-12h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


    }


    public function Reservation15Action($userd){

        $day="Friday";
        $hour="11h-12h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


    }





    public function Reservation16Action($userd){

        $day="Monday";
        $hour="14h-15h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


    }



    public function Reservation17Action($userd){

        $day="Tuesday";
        $hour="14h-15h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


    }


    public function Reservation18Action($userd){

        $day="Wednesday";
        $hour="14h-15h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


    }


    public function Reservation19Action($userd){

        $day="Thursday";
        $hour="14h-15h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


    }


    public function Reservation20Action($userd){

        $day="Friday";
        $hour="14h-15h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


    }

    public function Reservation21Action($userd){

        $day="Monday";
        $hour="15h-16h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


    }



    public function Reservation22Action($userd){

        $day="Tuesday";
        $hour="15h-16h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


    }


    public function Reservation23Action($userd){

        $day="Wednesday";
        $hour="15h-16h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


    }


    public function Reservation24Action($userd){

        $day="Thursday";
        $hour="15h-16h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
        $rdv->setDay($day);
        $rdv->setHour($hour);
        $em = $this->getDoctrine()->getManager();
        $em->persist($rdv);
        $em->flush();
        $id=$rdv->getId();
        return $this->redirectToRoute('updaterdv', array('id' => $id));


    }


    public function Reservation25Action($userd){

        $day="Friday";
        $hour="15h-16h";

        $rdv = new RDV();
        $rdv->setDoctorname($userd);
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
            return $this->redirectToRoute('pdf');
        }
        return $this->render('MyAppDoctorBundle:Cabinet:updaterdv.html.twig',array("form"=>$form->createView()));
    }



}