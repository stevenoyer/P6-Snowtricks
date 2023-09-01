<?php

namespace App\Service;

use App\Entity\User;
use App\Service\FileDeleter;
use App\Repository\UserRepository;
use App\Repository\ImageRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityService
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

    /**
     * Validate user account
     */
    public function validateAccount($token): array
    {
        $user = $this->userRepository->findOneBy(['token_validation' => $token]);

        if (!$user) {
            return [
                'type' => 'danger',
                'message' => 'No users found.',
                'redirectRoute' => 'security_login',
                'paramsRoute' => []
            ];
        }

        $user->setTokenValidation(null);
        $user->setValidate(true);

        $this->em->flush();

        return [
            'type' => 'success',
            'message' => 'Your account has been validated. You can now log in.',
            'redirectRoute' => 'security_login',
            'paramsRoute' => []
        ];
    }

    /**
     * Register user
     */
    public function registerUser(User $user, $password): array
    {
        // encode the password
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $password
            )
        );

        $user->setValidate(false);
        $user->setCreatedAt(new DateTime('now'));
        $user->setAvatar('user_profile.png');

        $token = sha1(uniqid() . uniqid());
        $user->setTokenValidation($token);

        $this->em->persist($user);
        $this->em->flush();

        // Generate an account validation link
        $url = $this->urlGenerator->generate('security_registration_validation', [
            'token' => $user->getTokenValidation()
        ], UrlGeneratorInterface::ABSOLUTE_URL);

        // Calls the UserNotification service to send the account validation email
        $this->userNotification->send(
            $user,
            'Validating your SnowTricks account',
            'To validate your account, click on the following link: <a href="' . $url . '">' . $url . '</a>'
        );

        return [
            'type' => 'success',
            'message' => 'Your account has been created. We have just sent you a confirmation email with a link to validate it.',
            'redirectRoute' => 'security_login',
            'paramsRoute' => []
        ];
    }

    /**
     * Forgot password
     */
    public function forgotPassword($email): array
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);
        $token = $this->tokenGenerator->generate($user->getEmail());

        // Generate token and token expiry and insert into entity
        $user->setTokenExpiration($this->tokenGenerator->getExpiration());
        $user->setTokenValidation($token);

        $this->em->flush();

        // Generate forgot password link
        $url = $this->urlGenerator->generate('security_reset_password', [
            'token' => $user->getTokenValidation()
        ], UrlGeneratorInterface::ABSOLUTE_URL);

        // Calls the UserNotification service to send the forgot password email
        $this->userNotification->send(
            $user,
            'Reset your SnowTricks account password',
            '<p>To reset your password, click on the following link: <a href="' . $url . '">' . $url . '</a></p>' .
                '<p>This link expires in : ' . date('d-m-Y H:i', $user->getTokenExpiration()) . '</p>'
        );

        return [
            'type' => 'success',
            'message' => 'An e-mail has just been sent to you to reset your password.',
            'redirectRoute' => 'home',
            'paramsRoute' => []
        ];
    }

    /**
     * Reset password
     */
    public function resetPassword(User $user, $password): array
    {
        // encode the password
        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $password
            )
        );

        // Reset values to null
        $user->setTokenValidation(null);
        $user->setTokenExpiration(null);

        $this->em->flush();

        return [
            'type' => 'success',
            'message' => 'Your password has been changed!',
            'redirectRoute' => 'security_login',
            'paramsRoute' => []
        ];
    }
}
