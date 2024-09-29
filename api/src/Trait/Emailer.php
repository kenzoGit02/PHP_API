<?php

namespace App\Trait;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;

trait Emailer
{

    private function createEmail($to, $verification_code): bool
    {

        $transport = Transport::fromDsn('smtp://kenzorivas16@gmail.com:ozbneoistibdqvlm@smtp.gmail.com:587');

        $mailer = new Mailer($transport);

        $email = (new Email())
            ->from('kenzorivas16@gmail.com')
            ->to($to)
            ->subject('Account Verification')
            ->text("Verification Code: $verification_code")
            ->html("<p>Verification Code: <b>$verification_code</b></p>");

        $mailer->send($email);

        return true;
    }
}
