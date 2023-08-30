<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api')]
class ApiSecurityController extends AbstractController
{
    #[Route('/user', name: '_user', methods: ['GET'])]
    public function user(){
        $user = $this->getUser();
        $message = "user successfully retrieved !";
        return $this->json([
            'user'=>$user,
            'message'=>$message
        ]);
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
