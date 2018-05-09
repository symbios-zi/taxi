<?php

namespace App\Presentation\Controller;

use App\Domain\Entity\User;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/register", name="registration_form", methods="GET")
     */
    public function registerForm()
    {
        return $this->render('register.html.twig');
    }

    /**
     * @Route("/register", name="registration", methods="POST")
     * @param Request $request
     * @param PasswordEncoderInterface $passwordEncoder
     */
    public function register(Request $request, PasswordEncoderInterface $passwordEncoder)
    {
        $id             = Uuid::uuid4();
        $login          = $request->get('login');
        $email          = $request->get('email');
        $plainPassword  = $request->get('password');
        $password       = $passwordEncoder->encodePassword($plainPassword, null);


        $user = new User($id, $login, $email, $password);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
    }
}