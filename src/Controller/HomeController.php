<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class HomeController extends Controller
{
    /**
     * @Route("/home", name="app_lucky_number")
     */
    public function home()
    {
        return $this->render('home/home.html.twig');
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('/management/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

    public function errorAction()
    {
        //return $this->render('home/home.html.twig');
        return new Response("<h1>Błont</h1>");
    }
}