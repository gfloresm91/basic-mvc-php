<?php

namespace App\Controllers;

use App\Models\User;
use Respect\Validation\Validator;
use App\Services\UserService;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Response\RedirectResponse;

class UsersController extends BaseController
{
    private $_userService;

    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->_userService = $userService;
    }

    public function indexAction()
    {
        $users = User::all();

        return $this->renderHTML('/users/index.twig', compact('users'));
    }

    public function getAddUser()
    {
        return $this->renderHtml('users/addUser.twig');
    }

    public function postCreateUser($request)
    {
        $data = $request->getParsedBody();

        // TODO: Validate

        $user = new User();
        $user->email = $data['email'];
        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
        $user->save();

        return $this->renderHtml('addUser.twig');
    }

    public function deleteAction(ServerRequest $request)
    {
        $params = $request->getQueryParams();
        $this->_userService->deleteUser($params['id']);

        return new RedirectResponse('/users');
    }
}
