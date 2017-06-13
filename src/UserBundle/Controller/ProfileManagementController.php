<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;
use UserBundle\Form\Type\UsernameEmailType;

class ProfileManagementController extends Controller
{
    public function manageAction(): Response
    {
        return $this->render('UserBundle:ProfileManagement:manage.html.twig');
    }

    public function editAction(Request $request, UserInterface $user): Response
    {
        $userForm = $this->createForm(
            UsernameEmailType::class,
            $user,
            [
                'action' => $this->generateUrl(
                    'criticalmass_user_usermanagement_edit'
                )
            ]
        );

        return $this->render(
            'UserBundle:ProfileManagement:edit.html.twig',
            [
                'userForm' => $userForm->createView()
            ]
        );
    }
}