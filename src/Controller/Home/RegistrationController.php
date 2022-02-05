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

        /*  change the registrationActivated variable to false to disable registration */
        $registrationActivated = true;
        if ($registrationActivated) {
            $user = new User();
            $user->setUsername('admin');
            // encode the password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    'S3cr3T+'
                )
            );

            /* Only for create admin user */
            $roles[] = 'ROLE_ADMIN';
            $user->setRoles($roles);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('home_login');
        }
        return $this->render('home/registration/index.html.twig', [
            'registrationActivated' => $registrationActivated,
        ]);
    }
}
