<?php include 'header.php' ?>
    <div class="container">
        <h1>
            Добавить задачу
        </h1>
        <form method="POST">
            <div class="form-group <?=(isset($errors['username'])?'has-error':'')?>">
                <label for="username">Имя пользователя</label>
                <input type="text" class="form-control" id="username" name="username" <?=isset($oldRequest['username'])?'value="'.$oldRequest['username'].'"':''?>>
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
                <input type="text" class="form-control" id="email" name="email" <?=isset($oldRequest['email'])?'value="'.$oldRequest['email'].'"':''?>>
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
                <textarea class="form-control <?=(isset($errors['text'])?'is-invalid':'')?>" id="text" rows="3" name="text"><?=isset($oldRequest['text'])?$oldRequest['text']:''?></textarea>
                <?
                if(isset($errors['text'])) {
                    echo '
                        <span class="help-block">
                            '.$errors['text'].'
                        </span>';
                }
                ?>
            </div>

            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div><!-- /.container -->
<?php include 'footer.php'?>