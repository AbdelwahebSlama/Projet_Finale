<?php

namespace App\Controller\enseignant;

use App\Entity\Enseignant;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/enseignant/CV/{id<\d+>}", name="enseignant.Cv")
     */
    public function Affiche_CV(Enseignant $enseignant = null)
    {


        return $this->render('enseignant/CvEnseignant.html.twig', [
            "ensg" => $enseignant

        ]);
    }

}
