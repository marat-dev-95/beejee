<?php


namespace App\Controller;


class AuthController extends Controller
{
    public function loginPage() {
        $title = 'Войти';
        $errors = [];
        $oldRequest = [];

        if(isset($_SESSION['errors'])) {
            $errors = $_SESSION['errors'];
            $oldRequest = $_SESSION['oldRequest'];
            unset($_SESSION['errors']);
            unset($_SESSION['oldRequest']);
        }
        $isAdmin = isset($_SESSION['admin']);
        require __DIR__.'/../../views/auth.php';
    }

    public function login() {
        $data = [
            'login' => 'admin',
            'password' => 123 //конечно пароли нужно хранить в зашифрованном виде
        ];

        $errors = [];

        if(empty(trim($_POST['login']))) {
            $errors['login'] = 'Заполните это поле';
        }
        if(empty(trim($_POST['password']))) {
            $errors['password'] = 'Заполните это поле';
        }
        if(empty($errors) && ($_POST['login'] != $data['login'] || $_POST['password'] != $data['password'])) {
            $errors['login'] = 'Логин или пароль неверный';
        }

        if(!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['oldRequest'] = $_POST;
            header('Location: /auth', true, 301);
        } else {
            $_SESSION['admin'] = 'admin';
            header('Location: /', true, 301);
        }
    }

    public function logout() {
        unset($_SESSION['admin']);
        header('Location: /', true, 301);
    }
}