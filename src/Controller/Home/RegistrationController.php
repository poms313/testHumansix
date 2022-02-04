<?php

namespace App\Controller\Home;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/home/register", name="home_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        /*  change the createNewUser variable to false to disable registration */
        $createNewUser = true;
        if ($createNewUser) {
            if ($form->isSubmitted() && $form->isValid()) {
                // encode the plain password
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

                /* Only for create admin user */
                $roles[] = 'ROLE_ADMIN';
                $user->setRoles($roles);

                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('admin');
            }
        }
        return $this->render('home/registration/index.html.twig', [
            'registrationForm' => $form->createView(),
            'createNewUser' => $createNewUser,
        ]);
    }
}
