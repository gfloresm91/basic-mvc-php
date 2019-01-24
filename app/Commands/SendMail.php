<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Models\Message;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class SendMail extends Command
{
    protected static $defaultName = 'app:send-mail';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pendingMessage = Message::where('sent', false)->first();

        if ($pendingMessage) {
            // Create the Transport
            $transport = (new Swift_SmtpTransport(
                getenv('SMTP_HOST'), getenv('SMTP_PORT')
            ))
                ->setUsername(getenv('SMTP_USER'))
                ->setPassword(getenv('SMTP_PASS'));

            // Create the Mailer using your created Transport
            $mailer = new Swift_Mailer($transport);

            // Create a message
            $message = (new Swift_Message('Wonderful Subject'))
                ->setFrom(['contact@mail.com' => 'Contact Form'])
                ->setTo(['receiver@domain.org', 'other@domain.org' => 'A name'])
                ->setBody(
                    'Hi you have a message. Name: '. $pendingMessage->name
                    . ' Email: ' . $pendingMessage->email 
                    . ' Message: ' . $pendingMessage->message
                );

            // Send the message
            $result = $mailer->send($message);

            $pendingMessage->sent = true;
            $pendingMessage->save();
        }
        
    }
}
