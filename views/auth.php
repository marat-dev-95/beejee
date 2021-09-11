<?php include 'header.php' ?>
    <div class="container">
        <h1>
            Войти
        </h1>
        <div class="row">
            <div class="col-md-4">
                <form method="POST">
                    <div class="form-group <?=(isset($errors['login'])?'has-error':'')?>">
                        <label for="login">Логин</label>
                        <input type="text" class="form-control" id="login" name="login" <?=isset($oldRequest['login'])?'value="'.$oldRequest['login'].'"':''?>>
                        <?
                        if(isset($errors['login'])) {
                            echo '
                        <span class="help-block">
                            '.$errors['login'].'
                        </span>';
                        }
                        ?>
                    </div>
                    <div class="form-group <?=(isset($errors['password'])?'has-error':'')?>">
                        <label for="password">Пароль</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <?
                        if(isset($errors['password'])) {
                            echo '
                        <span class="help-block">
                            '.$errors['password'].'
                        </span>';
                        }
                        ?>
                    </div>
                    <button type="submit" class="btn btn-primary">Войти</button>
                </form>
            </div>
        </div>

    </div><!-- /.container -->
<?php include 'footer.php'?>