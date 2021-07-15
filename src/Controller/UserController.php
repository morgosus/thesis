<?php

namespace App\Controller;
//TODO: Refactor

use App\Model\User;

class UserController extends Controller
{
    function process($parameters)
    {
        if (isset($_SESSION['user'])) {
            $this->account();
        } else {
            switch ($parameters[0]) {
                case 'login':
                    $this->login();
                    break;
                default:
                    $this->redirect('user/login');
                    break;
            }
        }
    }
    
    private function login()
    {
        $this->view = 'user/login';
        if (isset($_POST['loginSubmit']) && isset($_POST['username']) && isset($_POST['password'])) {
            $user = new User(null, $_POST['username'], $this->handler);
            $user->login($_POST['password']);
            if (isset($_SESSION['user'])) {
                $this->redirect('notice/logged-in');
            }
        }
    }
    
    private function account()
    {
        if (isset($_POST['logout'])) {
            $_SESSION['user']->logout();
            $this->redirect('notice/logged-out');
        } elseif (isset($_POST['changePassword']) && isset($_POST['newPassword'])
            && isset($_POST['newPasswordCheck']) && isset($_POST['oldPassword'])) {
            $_SESSION['user']->changePassword($_POST['newPassword'], $_POST['newPasswordCheck'], $_POST['oldPassword']);
        } elseif (isset($_POST['changeEmail']) && isset($_POST['newEmail'])) {
            $_SESSION['user']->changeEmail($_POST['newEmail']);
        } elseif (isset($_POST['deleteAccount'])) {
            $_SESSION['user']->deleteAccount();
            $_SESSION['user']->logout();
            $this->redirect('notice/account-deleted');
        }
        
        $this->view = 'user/landing';
    }
    
    /**
     *
     * Just in case I need to quickly hack together a dummy account
     *
     * @param $password
     * @return bool|string
     *
     * @noinspection PhpUnusedPrivateMethodInspection
     */
    private function generateEmergencyHash($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}
