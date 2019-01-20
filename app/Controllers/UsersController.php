<?php

namespace App\Controllers;

use App\Models\User;
use Respect\Validation\Validator;

class UsersController extends BaseController {
    public function getAddUser() {
        return $this->renderHtml('addUser.twig');
    }

    public function postCreateUser($request) {
        $data = $request->getParsedBody();

        // TODO: Validate

        $user = new User();
        $user->email = $data['email'];
        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
        $user->save();

        return $this->renderHtml('addUser.twig');
    }
}

