<?php

namespace App\Service;

use Symfony\component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class SendMailService
{
    public function __construct(private readonly MailerInterface $mailer)
    {}
    public function send(
        string $from,
        string $to,
        string $subject,
        string $template,
        array $context): void
    {
        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->htmlTemplate("emails/$template.html.twig")
            ->context($context);
        

            $this->mailer->send($email);
       
    }
}
