<?php
namespace App\Controller;

use App\Model\Task;

class TaskController extends Controller
{
    public const PER_PAGE = 3;

    public function list() {
        $title = 'Список задач';

        $taskModel = $this->modelRepository->setModel(Task::class);
        $orderColumns = ['username', 'email', 'status'];

        $sort = [
            'queryString' => $this->createQueryStringForSort($_GET)
        ];
        if(isset($_GET['sort']) && in_array($_GET['sort'], $orderColumns)) {
            $taskModel->orderBy($_GET['sort'], ($_GET['to'] == 'up'?'DESC':'ASC'));
            $sort['sort'] = $_GET['sort'];
            $sort['to'] = $_GET['to'];
        }
        $currentPage = $_GET['page'] ?? 1;
        $tasks = $taskModel->columns(['username', 'email', 'status', 'text', 'id', 'is_edited'])->paginate($currentPage,self::PER_PAGE);
        $taskCount = $taskModel->count();
        $perPage = self::PER_PAGE;
        $maxPage = ceil($taskCount/$perPage);
        $paginationQueryString = $this->createQueryStringForPagination($_GET);

        if(isset($_SESSION['notification'])) {
            $notification = $_SESSION['notification'];
            unset($_SESSION['notification']);
        }
        if(isset($_SESSION['warning'])) {
            $warning = $_SESSION['warning'];
            unset($_SESSION['warning']);
        }

        $isAdmin = isset($_SESSION['admin']);
        require __DIR__.'/../../views/index.php';
    }

    public function createPage() {
        $title = 'Добавить задачу';
        $errors = [];
        $oldRequest = [];
        if(isset($_SESSION['errors'])) {
            $errors = $_SESSION['errors'];
            $oldRequest = $_SESSION['oldRequest'];
            unset($_SESSION['errors']);
            unset($_SESSION['oldRequest']);
        }
        $isAdmin = isset($_SESSION['admin']);
        require __DIR__.'/../../views/create.php';
    }

    public function create() {
        $errors = [];

        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Введите корректный E-mail';
        }

        if(empty(trim($_POST['username']))) {
            $errors['username'] = 'Заполните это поле';
        }

        if(empty(trim($_POST['text']))) {
            $errors['text'] = 'Заполните это поле';
        }

        if(!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['oldRequest'] = $_POST;
            header('Location: /create', true, 301);
        } else {
            $taskModel = $this->modelRepository->setModel(Task::class);
            $taskModel->create(
                [
                    'username' => htmlentities($_POST['username']),
                    'email' => $_POST['email'],
                    'text' => htmlentities($_POST['text'])
                ]
            );

            $_SESSION['notification'] = 'Задача успешно добавлена';
            header('Location: /', true, 301);
        }
    }

    public function editPage() {
        $isAdmin = isset($_SESSION['admin']);
        if(!$isAdmin) {
            header('Location: /auth', true, 301);
            return;
        }

        $title = 'Редактировать задачу';
        $id = intval($_GET['id']);

        $errors = [];
        $oldRequest = [];
        if(isset($_SESSION['errors'])) {
            $errors = $_SESSION['errors'];
            $oldRequest = $_SESSION['oldRequest'];
            unset($_SESSION['errors']);
            unset($_SESSION['oldRequest']);
        }

        $task = $this->modelRepository->setModel(Task::class)->find($id);
        $isAdmin = isset($_SESSION['admin']);
        require __DIR__.'/../../views/edit.php';
    }

    public function edit() {
        $isAdmin = isset($_SESSION['admin']);
        if(!$isAdmin) {
            $_SESSION['warning'] = 'У вас нет прав для редактирования, авторизуйтесь';
            header('Location: /', true, 301);
            return;
        }

        $id = intval($_GET['id']);
        $task = $this->modelRepository->setModel(Task::class)->find($id);

        $errors = [];

        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Введите корректный E-mail';
        }

        if(empty(trim($_POST['username']))) {
            $errors['username'] = 'Заполните это поле';
        }

        if(empty(trim($_POST['text']))) {
            $errors['text'] = 'Заполните это поле';
        }

        if(!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['oldRequest'] = $_POST;
            header('Location: /edit?id='.$id, true, 301);
        } else {
            $taskModel = $this->modelRepository->setModel(Task::class);
            $taskModel->update($id,
                [
                    'username' => htmlentities($_POST['username']),
                    'email' => $_POST['email'],
                    'text' => htmlentities($_POST['text']),
                    'status' => isset($_POST['done'])?1:0,
                    'is_edited' => ($task->text != $_POST['text']?1:0)
                ]
            );

            $_SESSION['notification'] = 'Задача успешно отредактирована';
            header('Location: /', true, 301);
        }
    }

    private function createQueryStringForSort($query) {
        unset($query['sort']);
        unset($query['to']);

        return http_build_query($query);
    }

    private function createQueryStringForPagination($query) {
        unset($query['page']);

        return http_build_query($query);
    }
}
