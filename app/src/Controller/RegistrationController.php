<?php

namespace App\Controller;

use App\Entity\MoneyPot;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\MoneyPotRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('api_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function apiRegister(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        MoneyPotRepository $moneyPotRepository
    ): Response
    {
        $data = json_decode($request->getContent(), true);
        //config new user
        $user = new User;
        $plaintextPassword = $data['password'];
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);
        $user->setEmail($data['username']);
        $user->setRoles(["ROLE_USER"]);
        //save new user
        $userRepository->save($user, true);

        //config his new moneyPot
        $moneyPot = new MoneyPot();
        $moneyPot->setOwner($user);
        $nowDatetime = new \DateTimeImmutable(date("Y-m-d H:i:s"));
        $moneyPot->setCreatedAt($nowDatetime);
        $moneyPot->setIsShared(false);
        //save his moneyPot
        $moneyPotRepository->save($moneyPot, true);

        return new JsonResponse([
            'username' => $data['username'],
            'message' => "Account created succesfully !",
            'moneypot' => $moneyPot->getId()
        ]);
        }
}
