<?php

namespace App\Controller\admin;

use App\Entity\Filiere;
use App\Entity\Message;
use App\Entity\Niveau;
use App\Entity\Type;
use App\Form\FiliereType;
use App\Form\NiveauType;
use App\Form\TypeForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminfiliereController extends AbstractController
{
    public $contact;

    public function message()
    {
        $this->contact = $this->getDoctrine()
            ->getManager()
            ->getRepository(Message::class)->findAll();
        return $this->contact;
    }

    /**
     * @Route("/admin/listefiliere", name="admin.liste.filiere")
     */
    public function ListeFiliere()
    {
        $mesg = $this->message();
        $manager = $this->getDoctrine()->getManager()->getRepository(Filiere::class);
        $fiel = $manager->findAll();

        return $this->render('admin/Filiere/listefiliere.html.twig', [
            "fiels" => $fiel,
            "contact" => $mesg
        ]);
    }

    /**
     * @Route("/admin/AjouterFiliere", name="admin.filiere.ajout")
     * @Route("/admin/{id}/ModiFiliere", name="admin.modif.fileiere")
     */
    public function AjoutModifStage(Filiere $filiere = null, Request $request)
    {
        $mesg = $this->message();
        if (!$filiere) {
            $filiere = new Filiere();
        }

        $form = $this->createForm(FiliereType::class, $filiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($filiere);
            $manager->flush();
            return $this->redirectToRoute("admin.liste.filiere");

        }

        return $this->render("admin/Filiere/ajoutFiliere.html.twig", [
            "formfiel" => $form->createView(),
            "Modifiel" => $filiere->getId() !== null,
            "contact" => $mesg
        ]);
    }


    /**
     * @Route("admin/typeStage", name="admin.type.liste")
     */
    public function Listetype()
    {
        $mesg = $this->message();
        $mamanager = $this->getDoctrine()->getManager()->getRepository(Type::class);
        $types = $mamanager->findAll();

        return $this->render('admin/TypeNiveau/listetype.html.twig', [
            "types" => $types,
            "contact" => $mesg
        ]);
    }

    /**
     * @Route("admin/ajoutertypeStage", name="admin.ajout.type")
     * @Route("admin/{id}/modifType" , name="admin.modif.type")
     */

    public function Ajout_Modif_Type(Type $type = null, Request $request)
    {
        $mesg = $this->message();
        if (!$type) {
            $type = new Type();
        }
        $form = $this->createForm(TypeForm::class, $type);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($type);
            $manager->flush();
            return $this->redirectToRoute("admin.type.liste");

        }

        return $this->render("admin/TypeNiveau/Ajoutertype.html.twig", [
            "formTy" => $form->createView(),
            "Modiftype" => $type->getId(),
            "contact" => $mesg

        ]);
    }

    /**
     * @Route("admin/listeniveau", name="admin.liste.niveau")
     */
    public function listeNiveau()
    {
        $mesg = $this->message();

        $mamanager = $this->getDoctrine()->getManager()->getRepository(Niveau::class);
        $niveau = $mamanager->findAll();

        return $this->render('admin/TypeNiveau/listeniveau.html.twig', [
            "niveau" => $niveau,
            "contact" => $mesg
        ]);
    }


    /**
     * @Route("admin/ajouterniveau", name="admin.ajout.niveau")
     * @Route("admin/{id}/modifNiveau" , name="admin.modif.niveau")
     */

    public function Ajout_Modif_Niveau(Niveau $niveau = null, Request $request)
    {
        $mesg = $this->message();
        if (!$niveau) {
            $niveau = new Niveau();
        }
        $form = $this->createForm(NiveauType::class, $niveau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($niveau);
            $manager->flush();
            return $this->redirectToRoute("admin.liste.niveau");

        }

        return $this->render("admin/TypeNiveau/AjouterNiveau.html.twig", [
            "form" => $form->createView(),
            "Modif" => $niveau->getId(),
            "contact" => $mesg

        ]);
    }

}
