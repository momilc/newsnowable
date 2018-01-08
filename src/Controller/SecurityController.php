<?php

namespace App\Controller;

use App\Security\Context\SecurityContextInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="user_login")
     * @param Request $request
     * @return Response
     */
    public function loginAction(Request $request): Response
    {
        $session = $request->getSession();
        // get the login error if there is one
        if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContextInterface::AUTHENTICATION_ERROR);
        } elseif (null !== $session && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        } else {
            $error = null;
        }

        // last username entered by the user
//        $lastUsername = $authUtils->getLastUsername();
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContextInterface::LAST_USERNAME);

        return $this->render('security/loginPage.html.twig', [
            'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__),
            'last_username' => $lastUsername,
            'error' => $error,

        ]);
    }

    /**
     * @Route("/logout", name="logoutAction")
     */
    public function logoutAction()
    {
        // replace this line with your own code!
        return $this->render('home/homePage.html.twig', [ 'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__) ]);
    }



}
