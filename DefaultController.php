<?php

namespace Dwm\catalogueBundle\Controller;

use Dwm\catalogueBundle\Entity\produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);}


    /**
     * @Route("/somme/{a}/{b}")
     * @Template()
     */
    public function sommeAction($a,$b)
    {
        $s=$a+$b;
        return array('a' => $a,'b'=>$b,'somme'=>$s);
    }
    /**
     * @Route("/addProduit/{nom}/{prix}")
     * @Template()
     */
    public function addProduitAction($nom,$prix)
    {
        $p=new produit();
        $p->setNom($nom);
        $p->setPrix("$prix");
        $em=$this->getDoctrine()->getManager();
        $em->persist($p);
        $em->flush();
        return array('produit'=>$p);
    }
    /**
 * @Route("/listProduits",name="list")
 * @Template()
 */
    public function listProduitsAction()
    {
       $produits=$this->getDoctrine()->getRepository("DwmcatalogueBundle:Produit")->findAll();
        return array('produits'=>$produits);
    }

    /**
     * @Route("/formProduit")
     * @Template()
     */
    public function formProduitAction(Request $request)
    {
        $p=new produit();
        $form=$this->createFormBuilder($p)
        ->add('nom','text')
        ->add('prix','text')
        ->add('add','submit')
        ->getForm();
        $form->handleRequest($request);
        if($form->isValid() ) {
            $em=$this->getDoctrine()->getManager();
            $em->persist($p);
            $em->flush();
           return $this->redirect($this->generateUrl("list"));

        }
        return array('f'=>$form->createView());
    }

}
