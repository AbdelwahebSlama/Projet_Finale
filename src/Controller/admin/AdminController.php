<?php

namespace App\Controller\admin;

use App\Entity\Enseignant;
use App\Entity\Etudiant;
use App\Entity\Message;
use App\Form\EnseignantType;
use App\Form\EtudiantType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
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
     * @Route("/admin", name="admin")
     */
    public function index(Request $request)
    {

        $mesg = $this->message();
        $admin = $this->getUser();

        return $this->render('admin/indexadmin.html.twig', [
            "admin" => $admin,
            "contact" => $mesg

        ]);
    }

    /**
     * @Route("/admin/listeEnsg", name="adminListeEnsg")
     */
    public function listeEnseignant()
    {
        $mesg = $this->message();
        $repo = $this->getDoctrine()->getRepository(Enseignant::class);
        $ensg = $repo->findAll();
        return $this->render('admin/Enseignant/listeEnseingnat.html.twig', array(
            "ensg" => $ensg,
            "contact" => $mesg

        ));

    }

    /**
     * @Route("/admin/detail/{id<\d+>}", name="enseignant.detail")
     */
    public function detailEnseignat(Enseignant $enseignant = null)
    {
        $mesg = $this->message();
        return $this->render('admin/Enseignant/detailEnseingnat.html.twig', array(
            'ensg' => $enseignant,
            'contact' => $mesg
        ));

    }

    /**
     * @Route("/admin/delete/{id<\d+>}", name="enseignant.delete")
     */
    public function deletePersonne(Enseignant $enseignant = null)
    {
        if ($enseignant) {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($enseignant);
            $manager->flush();
        }
        return $this->forward('App\Controller\Admin\AdminController::listeEnseignant');
    }

    /**
     * @Route("/admin/ajoutEnsg", name="adminAjoutEnsg")
     * @Route("/admin/{id}/ModifEns", name="adminModifiEnsg")
     */
    public function ajouterEnseignant(Enseignant $enseignant = null, Request $request,
                                      UserPasswordEncoderInterface $encoder)
    {
        $mesg = $this->message();
        if (!$enseignant) {
            $enseignant = new Enseignant();
        }

        $form = $this->createForm(EnseignantType::class, $enseignant);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $file = $enseignant->getCV();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('upload_directory'), $fileName);
            $enseignant->setCV($fileName);

            $file1 = $enseignant->getImage();
            $fileName1 = md5(uniqid()) . '.' . $file1->guessExtension();
            $file1->move($this->getParameter('upload_directory3'), $fileName1);
            $enseignant->setImage($fileName1);

            $hash = $encoder->encodePassword($enseignant, $enseignant->getPassword());
            $enseignant->setPassword($hash);


            $manager = $this->getDoctrine()->getManager();
            $manager->persist($enseignant);
            $manager->flush();
            return $this->redirectToRoute('enseignant.detail', ['id' =>
                $enseignant->getId()]);
        }
        return $this->render('admin/Enseignant/ajoutEnseignant.html.twig', [
            "formEns" => $form->createView(),
            "modifEns" => $enseignant->getId() !== null,
            "contact" => $mesg
        ]);
    }


    /**
     * @Route("/admin/listeEtud", name="adminListeEtud")
     */
    public function listeEtudiant()
    {
        $mesg = $this->message();
        $repo = $this->getDoctrine()->getRepository(Etudiant::class);
        $etud = $repo->findAll();

        return $this->render('admin/Etudiant/listeEtudiant.html.twig', [
            "etud" => $etud,
            "contact" => $mesg

        ]);
    }

    /**
     * @Route("/admin/detailEtud/{id<\d+>}", name="etudiant.detail")
     */
    public function detailEtudiant(Etudiant $etudiant = null)
    {
        $mesg = $this->message();

        return $this->render('admin/Etudiant/DetailEtudiant.html.twig', array(
            'etud' => $etudiant,
            "contact" => $mesg
        ));

    }

    /**
     * @Route("/admin/deleteEtud/{id<\d+>}", name="etudiant.delete")
     */
    public function deleteEtudiant(Etudiant $etudiant = null)
    {
        if ($etudiant) {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($etudiant);
            $manager->flush();
        }
        return $this->forward('App\Controller\Admin\AdminController::listeEtudiant');
    }


    /**
     * @Route("/admin/ajoutEtud", name="adminAjoutEtud")
     * @Route("/admin/{id}/ModifEtud", name="adminModifiEtud")
     */
    public function ajouterEtudiant(Etudiant $etudiant = null, Request $request,
                                    UserPasswordEncoderInterface $encoder)
    {
        $mesg = $this->message();

        if (!$etudiant) {
            $etudiant = new Etudiant();
        }

        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $etudiant->getImage();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('upload_directory2'), $fileName);
            $etudiant->setImage($fileName);

            $hash = $encoder->encodePassword($etudiant, $etudiant->getPassword());
            $etudiant->setPassword($hash);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($etudiant);
            $manager->flush();

            return $this->redirectToRoute('etudiant.detail', ['id' =>
                $etudiant->getId()]);
        }
        return $this->render('admin/Etudiant/ajoutEtudiant.html.twig', [
            "formEtud" => $form->createView(),
            "modifEtud" => $etudiant->getId() !== null,
            "contact" => $mesg

        ]);
    }

    /**
     * @Route("/listeMat", name="adminListeMat")
     */
    public function listeMatiere()
    {
//        $repo = $this->getDoctrine()->getRepository(Filiere::class);
//        $matiere = $repo->findAll();
        $mesg = $this->message();
        return $this->render('admin/Matiere/listefiliere.html.twig', [
            "contact" => $mesg
        ]);
    }


}
