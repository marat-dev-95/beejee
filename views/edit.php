<?php
include 'header.php';

function getOldInputValue($name, $oldRequest, $task) {
    if(isset($oldRequest[$name])) {
        return $oldRequest[$name];
    }
    return $task->{$name};
}
?>
    <div class="container">
        <h1>
            Редактировать задачу
        </h1>
        <form method="POST">
            <div class="form-group <?=(isset($errors['username'])?'has-error':'')?>">
                <label for="username">Имя пользователя</label>
                <input type="text" class="form-control" id="username" name="username" value="<?=getOldInputValue('username', $oldRequest, $task)?>">
                <?
                if(isset($errors['username'])) {
                    echo '
                        <span class="help-block">
                            '.$errors['username'].'
                        </span>';
                }
                ?>
            </div>
            <div class="form-group <?=(isset($errors['email'])?'has-error':'')?>">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" value="<?=getOldInputValue('email', $oldRequest, $task)?>">
                <?
                if(isset($errors['email'])) {
                    echo '
                        <span class="help-block">
                            '.$errors['email'].'
                        </span>';
                }
                ?>
            </div>
            <div class="form-group <?=(isset($errors['text'])?'has-error':'')?>">
                <label for="text">Текст задачи</label>
                <textarea class="form-control <?=(isset($errors['text'])?'is-invalid':'')?>" id="text" rows="3" name="text"><?=getOldInputValue('text', $oldRequest, $task)?></textarea>
                <?
                if(isset($errors['text'])) {
                    echo '
                        <span class="help-block">
                            '.$errors['text'].'
                        </span>';
                }
                ?>
            </div>
            <div class="form-group">
                <input type="checkbox" name="done" id="done" <?=($task->status == 1?'checked':'')?>>
                <label for="done">Выполнено</label>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div><!-- /.container -->
<?php include 'footer.php'?>