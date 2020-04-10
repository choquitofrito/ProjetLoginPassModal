<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    /**
     * @Route("/login/modal", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $req): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $response = new JsonResponse(['lastUsername' => $lastUsername]); // cas de base : pas d'erreur 

        // si erreur, on envoie le message. Il faut choisir le message qu'on affiche selon l'erreur
        // ou tout simplement afficher login/pass incorrecte
        if (!is_null($error)) {
            $response = new JsonResponse([
                'error' => 'Utilisateur ou mot de passe incorrectes', //$error->getMessage(), // autrement on envoie tout un objet!
                'lastUsername' => $lastUsername
            ]);
        }

        return $response; // on renvoie la reponse dans tous les cas. Elle sera traitée en JS

    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
