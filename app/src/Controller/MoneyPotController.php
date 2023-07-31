<?php

namespace App\Controller;

use App\Entity\MoneyPot;
use App\Form\MoneyPotType;
use App\Repository\MoneyPotRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[isGranted('ROLE_USER')]
#[Route('/money_pot', name:'money_pot')]
class MoneyPotController extends AbstractController
{
    #[Route('/', name: '_index', methods: ['GET'])]
    public function index(MoneyPotRepository $moneyPotRepository): Response
    {
        return $this->render('money_pot/index.html.twig', [
            'money_pots' => $moneyPotRepository->findAll(),
        ]);
    }

    #[Route('/new', name: '_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MoneyPotRepository $moneyPotRepository): Response
    {
        $moneyPot = new MoneyPot();
        $form = $this->createForm(MoneyPotType::class, $moneyPot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $moneyPotRepository->save($moneyPot, true);

            return $this->redirectToRoute('money_pot_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('money_pot/new.html.twig', [
            'money_pot' => $moneyPot,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_money_pot_show', methods: ['GET'])]
    public function show(MoneyPot $moneyPot): Response
    {
        return $this->render('money_pot/show.html.twig', [
            'money_pot' => $moneyPot,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_money_pot_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MoneyPot $moneyPot, MoneyPotRepository $moneyPotRepository): Response
    {
        $form = $this->createForm(MoneyPotType::class, $moneyPot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $moneyPotRepository->save($moneyPot, true);

            return $this->redirectToRoute('app_money_pot_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('money_pot/edit.html.twig', [
            'money_pot' => $moneyPot,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_money_pot_delete', methods: ['POST'])]
    public function delete(Request $request, MoneyPot $moneyPot, MoneyPotRepository $moneyPotRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$moneyPot->getId(), $request->request->get('_token'))) {
            $moneyPotRepository->remove($moneyPot, true);
        }

        return $this->redirectToRoute('app_money_pot_index', [], Response::HTTP_SEE_OTHER);
    }
}
