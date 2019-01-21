<?php

namespace App\Controllers;

use App\Models\User;
use Respect\Validation\Validator;
use Zend\Diactoros\Response\RedirectResponse as Redirect;
use Zend\Diactoros\ServerRequest;

class AuthController extends BaseController
{
    public function getLogin()
    {
        return $this->renderHtml('login.twig');
    }

    public function postLogin(ServerRequest $request)
    {
        $responseMessage = null;

        $data = $request->getParsedBody();

        $user = User::where('email', $data['email'])->first();

        if ($user) {
            if (\password_verify($data['password'], $user->password)) {
                $_SESSION['user_id'] = $user->id;
                return new Redirect('admin');
            } else {
                $responseMessage = 'Bad credentials';
            }
        } else {
            $responseMessage = 'Bad credentials';
        }

        return $this->renderHtml(
            'login.twig', [
            'responseMessage' => $responseMessage
            ]
        );
    }

    public function getLogout()
    {
        unset($_SESSION['user_id']);
        return new Redirect('login');
    }
}
