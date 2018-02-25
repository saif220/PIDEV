<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 13/02/2018
 * Time: 16:27
 */

namespace MyApp\ShopBundle\Controller;



use blackknight467\StarRatingBundle\Form\RatingType;
use MyApp\ShopBundle\Entity\Produit;
use MyApp\ShopBundle\Form\ProduitType;
use MyApp\ShopBundle\Form\RatingTypes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;

class ShopController extends Controller
{
    public function AjouterProduitAction (Request $request){
        $prod= new Produit();
        $form = $this->createForm(ProduitType::class,$prod);
        $form->handleRequest($request);
        if($form->isValid()){

            $file = $prod->getImage();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $prod->setImage($fileName);

            // ... persist the $product variable or any other work
            $em=$this->getDoctrine()->getManager();
            $em->persist($prod);
            $em->flush();
            return $this->redirectToRoute('shop_AfficherProduit');
        }
        return $this->render ("MyAppShopBundle:Default:Ajouter.html.twig",array("Form"=>$form->createView()));
    }

    public function AfficherProduitAction (Request $request){

        $em=$this->getDoctrine()->getManager();
        $Modeles=$em->getRepository("MyAppShopBundle:Produit")
            ->findAll();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $Modeles,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',9)

        );
        return $this->render("MyAppShopBundle:Default:Afficher.html.twig",array("Modeles"=>$result));

    }
    public function DeleteProduitAction(Request $request){
        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $prod=$em->getRepository("MyAppShopBundle:Produit")->find($id);
        $em->remove($prod);
        $em->flush();
        return $this->redirectToRoute('shop_AfficherProduit');

    }
    public function UpdateProduitAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository("MyAppShopBundle:Produit")->find($id);
        $form = $this->createForm(ProduitType::class, $prod);
        $prod->setImage(
            new File($this->getParameter('brochures_directory') . '/' . $prod->getImage())
        );
        $form->handleRequest($request);
        if ($form->isValid()) {
            $file = $prod->getImage();

            $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $prod->setImage($fileName);
            $em->persist($prod);
            $em->flush();
            return $this->redirectToRoute('shop_AfficherProduit');

        }

        return $this->render("MyAppShopBundle:Default:Update.html.twig", array("Form" => $form->createView()));
    }

        public function RechercherProduitAction (Request $request) {
         $em=$this->getDoctrine()->getManager();
            $s=$em->getRepository("MyAppShopBundle:Produit")->findAll();
            /**
             * @var $paginator \Knp\Component\Pager\Paginator
             */
            $paginator = $this->get('knp_paginator');
            $result = $paginator->paginate(
                $s,
                $request->query->getInt('page',1),
                $request->query->getInt('limit',9)

            );
            $s1=$request->get('recherche');


            if($request->isMethod('POST')and $s1!=''){
                $this->redirectToRoute('shop_AfficherProduit');
                $a=$em->createQuery("Select d from MyAppShopBundle:Produit d WHERE d.libelle LIKE :i OR d.type LIKE :i OR d.prix LIKE :i ")
                    ->setParameter('i','%'.$s1.'%')
                    ;
                $s=$a->getResult();
            }
            return $this->render('MyAppShopBundle:Default:Rechercher.html.twig', array("Modeles"=>$s, "Mod"=>$result));
        }

    /*public function RechercherProduitAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository("MyAppShopBundle:Produit")->findAll();
        if($request->isMethod("post")) {
            $criteria = $request->get('libelle');
            $em=$this->getDoctrine()->getManager();
            $prod = $em->getRepository("MyAppShopBundle:Produit")->findBy(array('libelle'=>$criteria));

        }

        return $this->render ('MyAppShopBundle:Default:Rechercher.html.twig',array("prods"=>$prod));

    }*/

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
    public function AfficherDetailAction (Request $request){

        $em=$this->getDoctrine()->getManager();
        $Modeles=$em->getRepository("MyAppShopBundle:Produit")
            ->findAll();
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $Modeles,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',3)
        );
        $id = $request->get('id');
        $type = $request->get('type');
        $libelle = $request->get('libelle');
        $prix = $request->get('prix');
        $categorie = $request->get('categorie');
        $description = $request->get('description');
        $tel = $request->get('tel');
        $image = $request->get('image');
        $rating = $request->get('rating');

        return $this->render('MyAppShopBundle:Default:AfficherDetail.html.twig',
            array('id'=>$id,'type'=>$type, 'libelle'=>$libelle, 'prix'=>$prix, 'categorie'=>$categorie, 'description'=>$description,'tel'=>$tel, 'image'=>$image, 'rating'=>$rating, "Modeles"=>$result));


    }
    public function ratingAction(Request $request, $id) {
        $em= $this->getDoctrine()->getManager();
        $prod = $em->getRepository("MyAppShopBundle:Produit")->find($id);
        $r=$prod->getNbrrating();
        $form = $this->createForm(RatingTypes::class, $prod);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $prod->setNbruser($prod->getNbruser()+1);
            $prod->setNbrrating($prod->getRating()+$r);
            $a=($form['rating']->getData()+$r)/$prod->getNbruser();
            $prod->setRating($a);
            $em->persist($prod);
            $em->flush();
            return $this->redirectToRoute("shop_AfficherProduit");

        }
        return $this->render('MyAppShopBundle:Default:Rating.html.twig', array('form' => $form->createView()));
    }

  public function SuppAjaxProduitAction (Request $request) {

      $id=$request->get('id');
      $em=$this->getDoctrine()->getManager();
      $prod=$em->getRepository("MyAppShopBundle:Produit")->find($id);
      $em->remove($prod);
      $em->flush();
      /*$new = $em->getRepository("")->findBy(array('id' => $this->getId()));*/
      return $this->render('MyAppShopBundle:Default:SupprimerAjax.html.twig');
  }

    public function AjouterProduitBackAction (Request $request){
        $prod= new Produit();
        $form = $this->createForm(ProduitType::class,$prod);
        $form->handleRequest($request);
        if($form->isValid()){

            $file = $prod->getImage();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $prod->setImage($fileName);

            // ... persist the $product variable or any other work
            $em=$this->getDoctrine()->getManager();
            $em->persist($prod);
            $em->flush();
            return $this->redirectToRoute('shop_AfficherProduit_Back');
        }
        return $this->render ("MyAppShopBundle:Default:AjouterBack.html.twig",array("Form"=>$form->createView()));
    }
    public function AfficherProduitBackAction (Request $request){

        $em=$this->getDoctrine()->getManager();
        $Modeles=$em->getRepository("MyAppShopBundle:Produit")
            ->findAll();

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $Modeles,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',9)

        );
        return $this->render("MyAppShopBundle:Default:AfficherBack.html.twig",array("Modeles"=>$result));

    }
    public function DeleteProduitBackAction(Request $request){
        $id=$request->get('id');
        $em=$this->getDoctrine()->getManager();
        $prod=$em->getRepository("MyAppShopBundle:Produit")->find($id);
        $em->remove($prod);
        $em->flush();
        return $this->redirectToRoute('shop_AfficherProduit_Back');

    }

    public function UpdateProduitBackAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository("MyAppShopBundle:Produit")->find($id);
        $form = $this->createForm(ProduitType::class, $prod);
        $prod->setImage(
            new File($this->getParameter('brochures_directory') . '/' . $prod->getImage())
        );
        $form->handleRequest($request);
        if ($form->isValid()) {
            $file = $prod->getImage();

            $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('brochures_directory'),
                $fileName
            );

            // Update the 'brochure' property to store the PDF file name
            // instead of its contents
            $prod->setImage($fileName);
            $em->persist($prod);
            $em->flush();
            return $this->redirectToRoute('shop_AfficherProduit_Back');

        }

        return $this->render("MyAppShopBundle:Default:UpdateBack.html.twig", array("Form" => $form->createView()));
    }
    public function RechercherProduitBackAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $prod = $em->getRepository("MyAppShopBundle:Produit")->findAll();
        if($request->isMethod("post")) {
            $criteria = $request->get('libelle');
            $em=$this->getDoctrine()->getManager();
            $prod = $em->getRepository("MyAppShopBundle:Produit")->findBy(array('libelle'=>$criteria));

        }

        return $this->render ('MyAppShopBundle:Default:RechercherBack.html.twig',array("prods"=>$prod));

    }

    public function AfficherDetailBackAction (Request $request){

        $em=$this->getDoctrine()->getManager();
        $Modeles=$em->getRepository("MyAppShopBundle:Produit")
            ->findAll();
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $Modeles,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',3)
        );
        $id = $request->get('id');
        $type = $request->get('type');
        $libelle = $request->get('libelle');
        $prix = $request->get('prix');
        $categorie = $request->get('categorie');
        $description = $request->get('description');
        $tel = $request->get('tel');
        $image = $request->get('image');
        $rating = $request->get('rating');

        return $this->render('MyAppShopBundle:Default:AfficherDetailBack.html.twig',
            array('id'=>$id,'type'=>$type, 'libelle'=>$libelle, 'prix'=>$prix, 'categorie'=>$categorie, 'description'=>$description,'tel'=>$tel, 'image'=>$image, 'rating'=>$rating, "Modeles"=>$result));


    }
    public function TrierProduitAction (Request $request) {
        $em=$this->getDoctrine()->getManager();
        $s=$em->getRepository("MyAppShopBundle:Produit")->findBy([], ['prix' => 'ASC']);
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $s,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',9)

        );
        $s1=$request->get('recherche');


        if($request->isMethod('POST')and $s1!=''){
            $this->redirectToRoute('shop_AfficherProduit');
            $a=$em->createQuery("Select d from MyAppShopBundle:Produit d WHERE d.libelle LIKE :i OR d.type LIKE :i OR d.prix LIKE :i ORDER BY d.prix ASC")
                ->setParameter('i','%'.$s1.'%')
            ;
            $s=$a->getResult();
        }
        return $this->render('MyAppShopBundle:Default:TrierProduit.html.twig', array("Modeles"=>$s, "Mod"=>$result));
    }



}