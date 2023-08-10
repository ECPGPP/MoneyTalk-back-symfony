<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api')]
class ApiSecurityController extends AbstractController
{
    #[Route('/login', name: '_login', methods: ['POST'])]
    public function login()
    {
        $user = $this->getUser();
        return $this->json([
            'email' => $user->getUserIdentifier(),
            'roles' => $user->getRoles()
        ]);

    }
    #[Route('/register', name:'_register', methods:['POST'])]
    public function register(){

    }

    /** no need with JWT

    #[Route('/logout', name: '_logout', methods: ['POST'])]
    public function logout(){

    }
*/

}
