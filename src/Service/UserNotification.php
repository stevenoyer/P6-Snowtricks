<?php 

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;

class UserNotification 
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(User $user, string $subject, string $message)
    {
        $mail = new Email();
        $mail
            ->from(new Address('steven@oyer.fr', 'Steven Oyer'))
            ->to($user->getEmail())
            ->subject($subject)
            ->html($message);

        $this->mailer->send($mail);
    }

}