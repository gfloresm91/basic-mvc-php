<?php

namespace App\Controllers;

use Zend\Diactoros\ServerRequest;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Zend\Diactoros\Response\RedirectResponse;

class ContactController extends BaseController
{
    public function indexAction()
    {
        return $this->renderHTML('contact/index.twig');
    }

    public function sendAction(ServerRequest $request)
    {
        $data = $request->getParsedBody();

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
                'Hi you have a message. Name: '. $data['name']
                . ' Email: ' . $data['email'] . ' Message: ' . $data['message']
            );

        // Send the message
        $result = $mailer->send($message);

        return new RedirectResponse('/contact');
    }
}