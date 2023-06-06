<?php

namespace App\Controller;

use App\Entity\Intervention;
use App\Form\FormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class
InterventionController extends AbstractController
{
    #[Route('/intervention', name: 'app_intervention')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Intervention::class);

        $interventions= $repository->findAll();

        $intervention= new Intervention();

        $form = $this->createForm(FormType::class, $intervention, [
            'action' => $this->generateUrl('app_intervention_add'),
            'method' => 'POST'
        ]);


        return $this->render('intervention/index.html.twig', [
            'form' => $form->createView(),
            'interventions' => $interventions
        ]);
    }


    #[Route('/dashboard', name: 'app_dashboard')]
    public function dashboard(): Response
    {
        return $this->render('layout/dashboard.html.twig');
    }

    #[Route('/add', name: 'app_intervention_add')]
    public function addIntervention(EntityManagerInterface $entityManager, Request $request, Intervention $intervention = null): Response
    {
        $new = false;

        if(!$intervention){
            $new = true;
            $intervention = new Intervention();
        }

        $form= $this->createForm(FormType::class, $intervention);

        // handleRequest permet de mapper les informations du formulaire avec le form de la classe PersonneType
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            if ($new){
                $message = " a ete ajouter avec success";
            }
            else{

                $message=" a ete mis à jour avec success";
            }

            $entityManager->persist($intervention);

            $entityManager->flush();

            $this->addFlash('success', $intervention->getDescrptionDeLaPanne(). $message);

            return $this->redirectToRoute('app_intervention');
        }
        else
        {
            return $this->redirectToRoute('app_intervention');
        }
    }

    #[Route('/update/{id<\d+>', name: 'app_intervention_modifier')]
    public function updateIntervention(EntityManagerInterface $entityManager, $id,Request $request, Intervention $intervention = null): Response
    {
        $intervention  = $entityManager->getRepository(Intervention::class)->find($id);

        $new = false;

        if(!$intervention){
            $new = true;
            $intervention = new Intervention();
        }

        $form= $this->createForm(FormType::class, $intervention);

        // handleRequest permet de mapper les informations du formulaire avec le form de la classe PersonneType
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            if ($new){
                $message = " a ete ajouter avec success";
            }
            else{

                $message=" a ete mis à jour avec success";
            }

            $intervention->setDirectionEtService('directionETService');

            $intervention->setTypeDePanne('typeDePanne');

            $intervention->setDescrptionDeLaPanne('descriptionDeLaPanne');

            $entityManager->persist($intervention);

            $entityManager->flush();

            $this->addFlash('success', $intervention->getDescrptionDeLaPanne(). $message);

            return $this->redirectToRoute('app_intervention');
        }
        else
        {
            return $this->redirectToRoute('app_intervention');
        }
    }

    #[Route('/delete/{id<\d+>}', name: 'app_intervention_supprimer')]
    public function deleteIntervention(EntityManagerInterface $entityManager, Intervention $intervention = null, $id): RedirectResponse
    {
        $intervention  = $entityManager->getRepository(Intervention::class)->find($id);

        if (!$intervention) {
            $this->addFlash('error', "Cette Intervention n'existe pas");

            return $this->redirectToRoute('app_intervention');
        }
        $entityManager->remove($intervention);

        $entityManager->flush();

        $this->addFlash('success', "Cette Intervention a ete supprimer avec success");

        return $this->redirectToRoute('app_intervention');
    }
}