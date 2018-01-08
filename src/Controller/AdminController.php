<?php

namespace App\Controller;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     * @return Response
     * @throws \Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException
     */
    public function admin(): Response
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render(
                'security/loginPage.html.twig');
        }

        return $this->render('admin/adminPage.html.twig', [ 'path' => str_replace($this->getParameter('kernel.project_dir').'/', '', __FILE__) ]);
    }

    public function delete(Request $request)
    {
        $submittedToken = $request->request->get('token');

        // 'delete-item' is the same value used in the template to generate the token
        if ($this->isCsrfTokenValid('delete-item', $submittedToken)) {
            $this->delete($request);
        }
    }
}
