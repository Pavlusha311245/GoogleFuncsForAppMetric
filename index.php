<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminPanel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <section class="manipulation">
        <form action="manipulation.php" class="form" method="POST">
            <input type="text" class="label" placeholder="ID приложения" name="id">
            <input type="text" class="label" placeholder="Название приложения" name="app_name">
            <input type="text" class="label" placeholder="Токен" name="token">
            <div>
                <button class="btn btn-primary" name="add_btn">Добавить</button>
                <button class="btn btn-success" name="change_btn">Изменить</button>
                <button class="btn btn-danger" name="remove_btn">Удалить</button>
            </div>
            <?php
            if ($_GET) { //Отображение результата действий
                $success = $_GET;
                if ($success['success']) {
                    print('<p class="text-success">Успешно завершено</p>');
                } else {
                    print('<p class="text-danger">Что-то пошло не так</p>');
                }
                
            }
            ?>
        </form>
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Имя приложения</th>
                <th>Токен</th>
            </tr>
            <?php //Поля таблицы с данными
            $data = file_get_contents('manipulation.json');
            $data = json_decode($data, true);
            foreach ($data as $key => $item) {
                print('<tr>');
                print('<td>' . $data[$key]['id'] . '</td>');
                print('<td>' . $data[$key]['name'] . '</td>');
                print('<td>' . $data[$key]['token'] . '</td>');
                print('</tr>');
            }
            ?>
        </table>
    </section>
</body>

</html>