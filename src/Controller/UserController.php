<?php
namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    #[Route('/user/new', name: 'user_new', methods: ['GET'])]
    public function showNewUserForm(): Response
    {
        $form = $this->createForm(UserType::class, new User());
        return $this->render('user/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/new', name: 'user_new_post', methods: ['POST'])]
    public function processNewUser(Request $request, EntityManagerInterface $em): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('user_success', ['id' => $user->getId()]);
        }

        return $this->render('user/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/success/{id}', name: 'user_success')]
    public function userSuccess(User $user): Response
    {
        return $this->render('user/success.html.twig', [
            'user' => $user,
        ]);
    }
}
