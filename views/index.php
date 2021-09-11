<?php
include 'header.php';

// helper functions
function showSortableColumn($column, $title, $sort) {
    $out = [];

    $out[] = '<a href="?'.($sort['queryString']?$sort['queryString'].'&':'').'sort='.$column.'&to='.(isset($sort['to']) && $sort['sort'] == $column && $sort['to'] == 'up'?'down':'up').'">'.$title.'
                                ';
        if(isset($sort['to']) && $sort['sort'] == $column) {
            if($sort['to'] == 'up') {
                $out[] =  '<i class="bi bi-arrow-down"></i>';
            } else {
                $out[] = '<i class="bi bi-arrow-up"></i>';
            }
        } else {
            $out[] =  '<i class="bi bi-arrow-down-up"></i>';
        }
   $out[] = '</a>';

    return join("\n", $out);
}


?>
    <div class="container">
        <div class="row">
            <div class="starter-template">
                <h1>Список задач</h1>
                <?=(isset($notification)?'<div class="alert alert-success" role="alert">'.$notification.'</div>':'')?>
                <?=(isset($warning)?'<div class="alert alert-danger" role="alert">'.$warning.'</div>':'')?>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">
                            <?=showSortableColumn('username', 'Имя пользователя', $sort)?>
                        </th>
                        <th scope="col">
                            <?=showSortableColumn('email', 'E-mail', $sort)?>
                        </th>
                        <th scope="col">Текст задачи</th>
                        <th scope="col">
                            <?=showSortableColumn('status', 'Статус', $sort)?>
                        </th>
                        <?=($isAdmin?'<th scope="col"></th>':'')?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($tasks as $task) {
                        echo '
                            <tr>
                                <th scope="row">'.$task->id.'</th>
                                <td>'.$task->username.'</td>
                                <td>'.$task->email.'</td>
                                <td>'.$task->text.'</td>
                                <td>
                                    '.($task->isDone()?'<span class="label label-success">Выполнено</span>':'<span class="label label-default">В процессе</span>').'
                                    '.($task->isEdited()?'<span class="label label-info">Отредактировано администратором</span>':'').'
                                </td>
                                '.($isAdmin?'<td><a href="/edit?id='.$task->id.'"><button type="button" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-edit"></span> ред.</button></a></td>':'').'
                            </tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <?php
                        if($currentPage > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?page='.($currentPage-1).($paginationQueryString?'&'.$paginationQueryString:'').'">Назад</a></li>';
                        }
                        if($maxPage > 1) {
                            for($i=1; $i<=$maxPage; $i++) {
                                echo '<li class="page-item '.($currentPage == $i?'active':'').'"><a class="page-link " href="?page='.$i.($paginationQueryString?'&'.$paginationQueryString:'').'">'.$i.'</a></li>';
                            }
                        }
                        if($currentPage < $maxPage) {
                            echo '<li class="page-item"><a class="page-link" href="?page='.($currentPage + 1).($paginationQueryString?'&'.$paginationQueryString:'').'">Вперед</a></li>';
                        }
                    ?>
                </ul>
            </nav>
        </div>
    </div><!-- /.container -->
<?php include 'footer.php'?>