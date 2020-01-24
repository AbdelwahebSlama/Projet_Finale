<?php

namespace App\Controller\etudiant;

use App\Entity\Contact;
use App\Entity\Etudiant;
use App\Entity\Message;
use App\Form\MessageType;
use App\Notificaton\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends AbstractController
{
    /**
     * @Route("/etudiant", name="etudiant")
     */
    public function index()
    {
        $user = $this->getUser();
        return $this->render('etudiant/profile_etudiant.html.twig', [
            "etud" => $user,

        ]);
    }

    /**
     * @Route("/etudiant/coordonne/{id<\d+>}", name="etudiant.coordonnee")
     */
    public function Affiche_Cordonne(Etudiant $etudiant = null)
    {

        return $this->render('etudiant/coordonnées.html.twig', [
            "etud" => $etudiant

        ]);
    }

    /**
     * @Route("/etudiant/{id}/ModifEtud", name="etudModifiEtud")
     */
    public function modifierProfile(Etudiant $etudiant = null, Request $request)
    {

        if ($request->getMethod() == 'POST') {
            $adresse = $request->get('adresse');
            $email = $request->get('email');
            $age = $request->get('age');
            if ($adresse) {
                $etudiant->setAdresse($adresse);
            }
            if ($email) {
                $etudiant->setEmail($email);
            }
            if ($age) {
                $etudiant->setAge($age);
            }

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($etudiant);
            $manager->flush();

            return $this->redirectToRoute("etudiant.coordonnee", [
                'id' => $etudiant->getId(),
                "etud" => $etudiant,
            ]);

        }

        return $this->render('etudiant/ModifProfile.html.twig',
            ["etud" => $etudiant]
        );
    }


    /**
     * @Route("/etudiant/{id}/paiement", name="etud.paiement")
     */
    public function paiement(Etudiant $etudiant)
    {

        return $this->render("etudiant/paiementEtud.html.twig", [
            "etud" => $etudiant
        ]);
    }


    /**
     * @Route("/etudiant/contact/{id}", name="etudiant.contact")
     */
    public function contact(Request $request, Notification $notification, Etudiant $etudiant = null)
    {

        $contact = new Message();
        $contact->setProperty($etudiant);

        $form = $this->createForm(MessageType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $notification->contact($contact);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($contact);
            $manager->flush();

            $this->addFlash('success', 'Votre messagea été envoyer avec succssé');
            return $this->redirectToRoute('etudiant');
        }


        return $this->render("etudiant/contactEtud.html.twig", [
            "form" => $form->createView(),
            "etud" => $this->getUser()
        ]);

    }
}
