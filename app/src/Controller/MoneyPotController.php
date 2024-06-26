<?php

namespace App\Controller;

use App\Entity\MoneyPot;
use App\Form\MoneyPotType;
use App\Repository\MoneyPotRepository;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/money_pot', name: 'money_pot')]
class MoneyPotController extends AbstractController
{
    #[Route('/all', name: '_index', methods: ['GET'])]
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

        return $this->render('money_pot/new.html.twig', [
            'money_pot' => $moneyPot,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: '_show', methods: ['GET'])]
    public function show(
        //MoneyPot $moneyPot,
        MoneyPotRepository $moneyPotRepository,
        TransactionRepository $transactionRepository,
        int $id
    ): Response
    {
        $moneyPot = $moneyPotRepository->findOneBy(['id'=> $id]);
//        $transactions[] = $transactionRepository->findByMoneyPotId($moneyPot->getId());
        $transactions = $moneyPotRepository->findTransactionsByMoneyPotId($id);
        return $this->render('money_pot/show.html.twig', [
            'money_pot' => $moneyPot,
            'transactions' => $transactions
        ]);
    }

    #[Route('/{id}/edit', name: '_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MoneyPot $moneyPot, MoneyPotRepository $moneyPotRepository): Response
    {
        $form = $this->createForm(MoneyPotType::class, $moneyPot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $moneyPotRepository->save($moneyPot, true);

            return $this->redirectToRoute('money_pot_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('money_pot/edit.html.twig', [
            'money_pot' => $moneyPot,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: '_delete', methods: ['POST'])]
    public function delete(Request $request, MoneyPot $moneyPot, MoneyPotRepository $moneyPotRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$moneyPot->getId(), $request->request->get('_token'))) {
            $moneyPotRepository->remove($moneyPot, true);
        }

        return $this->redirectToRoute('money_pot_index', [], Response::HTTP_SEE_OTHER);
    }


}
