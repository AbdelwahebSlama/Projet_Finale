<?php

namespace App\Controller\enseignant;

use App\Entity\Enseignant;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @IsGranted("ROLE_ENSEIGNANT")
 */
class EnseignantController extends AbstractController
{
    /**
     * @Route("/enseignant", name="enseignant")
     */
    public function index(Enseignant $enseignant = null)
    {
        $enseignant = $this->getUser();
        return $this->render('enseignant/profileEnseignant.html.twig', [
            'ensg' => $enseignant
        ]);
    }

    /**
     * @Route("/enseignant/coordonne/{id<\d+>}", name="enseignant.coordonnee")
     */
    public function Affiche_Cordonne(Enseignant $enseignant = null)
    {


        return $this->render('enseignant/cooordonneEnsg.html.twig', [
            "ensg" => $enseignant

        ]);
    }

    /**
     * @Route("/enseignant/modifieprofile/{id<\d+>}", name="enseignant.modifprofil")
     */
    public function modifierprofile(Enseignant $enseignant = null, Request $request)
    {
        if ($request->getMethod() == 'POST') {
            $adresse = $request->get('adresse');
            $email = $request->get('email');
            $age = $request->get('age');
            if ($adresse) {
                $enseignant->setAdresse($adresse);
            }
            if ($email) {
                $enseignant->setEmail($email);
            }
            if ($age) {
                $enseignant->setAge($age);
            }

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($enseignant);
            $manager->flush();

            return $this->redirectToRoute("enseignant.coordonnee", [
                'id' => $enseignant->getId(),
                "ensg" => $enseignant,
            ]);

        }


        return $this->render('enseignant/modifprofile.html.twig', [
            "id" => $enseignant->getId(),
            "ensg" => $enseignant

        ]);
    }

    /**
     * @Route("/enseignant/CV/{id<\d+>}", name="enseignant.Cv")
     */
    public function Affiche_CV(Enseignant $enseignant = null)
    {


        return $this->render('enseignant/CvEnseignant.html.twig', [
            "ensg" => $enseignant

        ]);
    }

    /**
     * @Route("/enseignant/stages/{id<\d+>}", name="enseignant.stage")
     */
    public function listeStage(Enseignant $enseignant = null)
    {


        return $this->render('enseignant/listestage.html.twig', [
            "ensg" => $enseignant

        ]);
    }


}
