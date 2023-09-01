<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ForgotPasswordType;
use App\Form\LoginFormType;
use App\Form\RegistrationFormType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use App\Service\TokenGenerator;
use App\Service\UserNotification;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SecurityController extends AbstractController
{

    private $urlGenerator;
    private $em;
    private $userRepository;
    private $tokenGenerator;
    private $userNotification;
    private $userPasswordHasher;

    public function __construct(UrlGeneratorInterface $urlGeneratorInterface, EntityManagerInterface $em, UserRepository $userRepository, TokenGenerator $tokenGenerator, UserNotification $userNotification, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->urlGenerator = $urlGeneratorInterface;
        $this->em = $em;
        $this->userRepository = $userRepository;
        $this->tokenGenerator = $tokenGenerator;
        $this->userNotification = $userNotification;
        $this->userPasswordHasher = $userPasswordHasher;
    }

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

    #[Route('/registration/validate/{token}', name: 'security_registration_validation', methods: ['GET'])]
    public function validate($token)
    {
        $user = $this->userRepository->findOneBy(['token_validation' => $token]);

        if (!$user) {
            $this->addFlash('danger', 'No users found.');
            return $this->redirectToRoute('security_login');
        }

        $user->setTokenValidation(null);
        $user->setValidate(true);

        $this->em->flush();

        $this->addFlash('success', 'Your account has been validated. You can now log in.');
        return $this->redirectToRoute('security_login');
    }

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
            // encode the password
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setValidate(false);
            $user->setCreatedAt(new DateTime('now'));
            $user->setAvatar('user_profile.png');

            $token = sha1(uniqid() . uniqid());
            $user->setTokenValidation($token);

            $this->em->persist($user);
            $this->em->flush();

            $url = $this->urlGenerator->generate('security_registration_validation', [
                'token' => $user->getTokenValidation()
            ], UrlGeneratorInterface::ABSOLUTE_URL);

            $this->userNotification->send(
                $user,
                'Validating your SnowTricks account',
                'To validate your account, click on the following link: <a href="' . $url . '">' . $url . '</a>'
            );

            $this->addFlash('success', 'Your account has been created. We have just sent you a confirmation email with a link to validate it.');

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/forgot_password', name: 'security_forgot_password', methods: ['GET', 'POST'])]
    public function forgotPassword(Request $request): Response
    {
        $form = $this->createForm(ForgotPasswordType::class, $this->getUser());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->userRepository->findOneBy(['email' => $form->get('email')->getData()]);
            $token = $this->tokenGenerator->generate($user->getEmail());

            $user->setTokenExpiration($this->tokenGenerator->getExpiration());
            $user->setTokenValidation($token);

            $this->em->flush();

            $url = $this->urlGenerator->generate('security_reset_password', [
                'token' => $user->getTokenValidation()
            ], UrlGeneratorInterface::ABSOLUTE_URL);

            $this->userNotification->send(
                $user,
                'Reset your SnowTricks account password',
                '<p>To reset your password, click on the following link: <a href="' . $url . '">' . $url . '</a></p>' .
                    '<p>This link expires in : ' . date('d-m-Y H:i', $user->getTokenExpiration()) . '</p>'
            );

            $this->addFlash('success', 'An e-mail has just been sent to you to reset your password.');
            return $this->redirectToRoute('home');
        }

        return $this->render('security/forgot_password.html.twig', [
            'forgotForm' => $form->createView()
        ]);
    }

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
            // encode the password
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $user->setTokenValidation(null);
            $user->setTokenExpiration(null);

            $this->em->flush();

            $this->addFlash('success', 'Your password has been changed!');
            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/reset.html.twig', [
            'resetForm' => $form->createView()
        ]);
    }

    #[Route(path: '/logout', name: 'security_logout', methods: ['GET'])]
    public function logout(): void
    {
    }
}
