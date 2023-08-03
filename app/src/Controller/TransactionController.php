<?php

namespace App\Controller;

use App\Entity\MoneyPot;
use App\Entity\Transaction;
use App\Form\TransactionType;
use App\Repository\MoneyPotRepository;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/transaction',name: 'transaction')]
class TransactionController extends AbstractController
{
    #[Route('/all', name: '_index', methods: ['GET'])]
    public function index(TransactionRepository $transactionRepository): Response
    {
        return $this->render('transaction/index.html.twig', [
            'transactions' => $transactionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: '_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        TransactionRepository $transactionRepository,
        MoneyPotRepository $moneyPotRepository,
        EntityManagerInterface $em
    ): Response
    {
        $transaction = new Transaction();
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transaction->setLabel($form->get('label')->getData());
            $transaction->setAmount($form->get('amount')->getData());
            $transaction->setCreatedAt($form->get('createdAt')->getData());
            if ($form->get('editedAt')->getData() !== null){
                $transaction->setEditedAt($form->get('editedAt')->getData());
            }
            $moneypotId = $form->get('moneyPots')->getData()[0]->getId();
            $moneypot = $moneyPotRepository->find($moneypotId);
            $transaction->addMoneyPot($moneypot);
            $em->persist($transaction);
            //dd($transaction);
            $em->flush();


            dump($moneypot);
            $transaction->addMoneyPot($moneypot);
            dump($moneypot);
            if ($moneypot instanceof MoneyPot){
                dump('oui mp');
            } else {
                dump('non');
            }
            $transactionRepository->save($transaction, true);

            return $this->redirectToRoute('transaction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('transaction/new.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: '_show', methods: ['GET'])]
    public function show(Transaction $transaction): Response
    {
        return $this->render('transaction/show.html.twig', [
            'transaction' => $transaction,
        ]);
    }

    #[Route('/{id}/edit', name: '_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Transaction $transaction, TransactionRepository $transactionRepository): Response
    {
        $form = $this->createForm(TransactionType::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transactionRepository->save($transaction, true);

            return $this->redirectToRoute('transaction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('transaction/edit.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: '_delete', methods: ['POST'])]
    public function delete(Request $request, Transaction $transaction, TransactionRepository $transactionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transaction->getId(), $request->request->get('_token'))) {
            $transactionRepository->remove($transaction, true);
        }

        return $this->redirectToRoute('transaction_index', [], Response::HTTP_SEE_OTHER);
    }
}
