<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminController extends AbstractController
{
    #[Route(path: '/', name: 'home')]
    public function login(EntityManagerInterface $em)
    {
        return $this->redirectToRoute('admin', status: 301);
    }

    #[Route(path: '/ajax/toggle-role/{id}', name: 'toggle_role_admin', options: ['expose' => true])]
    #[IsGranted('ROLE_ADMIN')]
    #[ParamConverter('user', class: 'App\Entity\User', options: ['id' => 'id'])]
    public function toggleRole(
        Request $request,
        EntityManagerInterface $em,
        User $user
    )
    {
        $role = $request->get("field");

        if(!$role){
            return $this->json(["success" => false]);
        }

        $user->toggleRole($role);

        $em->flush();

        return $this->json([
            "success" => true,
        ]);
    }
}
