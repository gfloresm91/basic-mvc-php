<?php

namespace App\Controllers;

use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response\RedirectResponse;
use App\Models\Message;

class ContactController extends BaseController
{
    public function indexAction()
    {
        return $this->renderHTML('contact/index.twig');
    }

    public function sendAction(ServerRequest $request)
    {
        $data = $request->getParsedBody();

        $message = new Message();

        $message->name = $data['name'];
        $message->email = $data['email'];
        $message->message = $data['message'];
        $message->sent = false;
        $message->save();

        return new RedirectResponse('/contact');
    }
}