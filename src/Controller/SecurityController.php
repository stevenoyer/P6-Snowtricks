<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ForgotPasswordType;
use App\Form\LoginFormType;
use App\Form\RegistrationFormType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use App\Service\SecurityService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{

    private $userRepository;
    private $securityService;

    public function __construct(UserRepository $userRepository, SecurityService $securityService)
    {
        $this->userRepository = $userRepository;
        $this->securityService = $securityService;
    }

    /**
     * Login page
     */
    #[Route(path: '/login', name: 'security_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils, FormFactoryInterface $factory): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('user_profile');
        }

        $form = $factory->createNamed('', LoginFormType::class);

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'loginForm' => $form->createView()
        ]);
    }

    /**
     * Account validation
     */
    #[Route('/registration/validate/{token}', name: 'security_registration_validation', methods: ['GET'])]
    public function validate($token)
    {
        $validate = $this->securityService->validateAccount($token);

        $this->addFlash($validate['type'], $validate['message']);
        return $this->redirectToRoute($validate['redirectRoute'], $validate['paramsRoute']);
    }

    /**
     * Registration
     */
    #[Route('/registration', name: 'security_register', methods: ['GET', 'POST'])]
    public function register(Request $request): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('user_profile');
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $register = $this->securityService->registerUser($user, $form->get('password')->getData());

            $this->addFlash($register['type'], $register['message']);
            return $this->redirectToRoute($register['redirectRoute'], $register['paramsRoute']);
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * Forgot password
     */
    #[Route('/forgot_password', name: 'security_forgot_password', methods: ['GET', 'POST'])]
    public function forgotPassword(Request $request): Response
    {
        $form = $this->createForm(ForgotPasswordType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $forgot = $this->securityService->forgotPassword($form->get('email')->getData());

            $this->addFlash($forgot['type'], $forgot['message']);
            return $this->redirectToRoute($forgot['redirectRoute'], $forgot['paramsRoute']);
        }

        return $this->render('security/forgot_password.html.twig', [
            'forgotForm' => $form->createView()
        ]);
    }

    /**
     * Reset password
     */
    #[Route('/reset_password/{token}', name: 'security_reset_password', methods: ['POST', 'GET'])]
    public function resetPassword($token, Request $request): Response
    {
        $user = $this->userRepository->findOneBy(['token_validation' => $token]);

        if (!$user) {
            $this->addFlash('danger', 'This token is invalid.');
            return $this->redirectToRoute('security_forgot_password');
        }

        if ($user->getTokenExpiration() < time()) {
            $this->addFlash('danger', 'The token has expired. You need to request a new password reset.');
            return $this->redirectToRoute('security_forgot_password');
        }

        $form = $this->createForm(ResetPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reset = $this->securityService->resetPassword($user, $form->get('password')->getData());

            $this->addFlash($reset['type'], $reset['message']);
            return $this->redirectToRoute($reset['redirectRoute'], $reset['paramsRoute']);
        }

        return $this->render('security/reset.html.twig', [
            'resetForm' => $form->createView()
        ]);
    }

    /**
     * Logout
     */
    #[Route(path: '/logout', name: 'security_logout', methods: ['GET'])]
    public function logout(): void
    {
    }
}
