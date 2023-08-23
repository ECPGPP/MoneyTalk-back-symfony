<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api')]
class ApiSecurityController extends AbstractController
{
    #[Route('/login', name: '_login', methods: ['GET'])]
    public function index(){
        return $this->json('oui');
    }
    #[Route('/login', name: '_login', methods: ['POST'])]
    public function login()
    {
        $user = $this->getUser();
        return $this->json([
            'email' => $user->getUserIdentifier(),
            'roles' => $user->getRoles()
        ]);

    }


    /** no need with JWT

    #[Route('/logout', name: '_logout', methods: ['POST'])]
    public function logout(){

    }
*/

}
