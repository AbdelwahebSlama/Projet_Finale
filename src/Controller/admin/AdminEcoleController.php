<?php
namespace App\Controller\admin;

use App\Entity\Classe;
use App\Entity\Ecole;
use App\Entity\Message;
use App\Entity\Stage;
use App\Form\ClasseType;
use App\Form\EcoleType;
use App\Form\StageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminEcoleController extends AbstractController
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
     * @Route("/admin/ecole", name="admin_ecole")
     */
    public function index()
    {
        $mesg = $this->message();
        return $this->render('admin_ecole/index.html.twig', [
            'controller_name' => 'AdminEcoleController',
            "contact" => $mesg
        ]);
    }
    /**
     * @Route("/admin/listeClasse", name="admin.liste.classe")
     */
    public function ListeClass()
    {
        $mesg = $this->message();

        $manager = $this->getDoctrine()->getManager();
        $classe = $manager->getRepository(Classe::class)->findAll();
        return $this->render('admin/Classe/listeClasse.html.twig', [
            "classe" => $classe,
            "contact" => $mesg
        ]);
    }
    /**
     * @Route("/admin/AjouterClasse", name="admin.classe.ajout")
     * @Route("/admin/{id}/ModifClasse", name="admin.modif.classe")
     */
    public function AjoutModifClasse(Classe $classe = null, Request $request)
    {
        $mesg = $this->message();
        if (!$classe) {
            $classe = new Classe();
        }
        $form = $this->createForm(ClasseType::class, $classe);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($classe);
            $manager->flush();
            return $this->redirectToRoute("admin.liste.classe");
        }
        return $this->render("admin/Classe/AjoutClasse.html.twig", [
            "formcl" => $form->createView(),
            "ModifClas" => $classe->getId() !== null,
            "contact" => $mesg
        ]);
    }
    /**
     * @Route("/admin/listeStage", name="admin.liste.stage")
     */
    public function ListeStage()
    {
        $mesg = $this->message();
        $manager = $this->getDoctrine()->getManager();
        $stages = $manager->getRepository(Stage::class)->findAll();
        return $this->render('admin/Stage/listeStage.html.twig', [
            "stages" => $stages,
            "contact" => $mesg
        ]);
    }
    /**
     * @Route("/admin/AjouterStage", name="admin.stage.ajout")
     * @Route("/admin/{id}/ModifStage", name="admin.modif.stage")
     */
    public function AjoutModifStage(Stage $stage = null, Request $request)
    {
        $mesg = $this->message();
        if (!$stage) {
            $stage = new Stage();
        }
        $form = $this->createForm(StageType::class, $stage);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($stage);
            $manager->flush();
            return $this->redirectToRoute("admin.liste.stage");
        }
        return $this->render("admin/Stage/AjoutStage.html.twig", [
            "formStg" => $form->createView(),
            "ModifStg" => $stage->getId() !== null,
            "contact" => $mesg
        ]);
    }

    /**
     * @Route("/admin/Ecole", name="admin.ecole")
     */
    public function Ecole()
    {
        $mesg = $this->message();
        $manager = $this->getDoctrine()->getManager()->getRepository(Ecole::class);
        $ecole = $manager->findAll();
        return $this->render('admin/Ecole/ecoleListe.html.twig', [
            "ecoles" => $ecole,
            "contact" => $mesg
        ]);
    }

    /**
     * @Route("/admin/AjouterEcole", name="admin.ajout.ecole")
     * @Route("/admin/{id}/ModifStage", name="admin.modif.stage")
     */
    public function AjoutEcole(Request $request)
    {
        $mesg = $this->message();

        $ecole = new Ecole();
        $form = $this->createForm(EcoleType::class, $ecole);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($ecole);
            $manager->flush();
            return $this->redirectToRoute("admin.ecole");
        }
        return $this->render("admin/Ecole/AjoutEcole.html.twig", [
            "form" => $form->createView(),
            "contact" => $mesg
        ]);
    }
}


