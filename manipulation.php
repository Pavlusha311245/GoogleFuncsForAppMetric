<?php

$file = file_get_contents('manipulation.json'); //подгружается файл json
$taskList = json_decode($file, TRUE); //расшифровка json
$id = strtolower(trim(htmlspecialchars($_POST['id'])));
$name = strtolower(trim(htmlspecialchars($_POST['app_name']))); //приходящий POST запрос преобразуется в нижний регистр, убирая лишние пробелы
$token = trim(htmlspecialchars($_POST['token']));
$presence = false; //перенная, которая смотрит повторение в json

unset($file); //выгрузка $file из памяти


if (isset($_POST['add_btn'])) { //Обработчик кнопки добавить, которая в index.php помечена как name="add_btn"
    if (!empty($name) && !empty($token)) {
        foreach ($taskList  as $key => $value) {
            if (in_array($name, $value)) {
                $presence = true;
            }
        }

        if ($presence === false) {
            $taskList[] = array('id' => $id, 'name' => $name, 'token' => $token);
            file_put_contents('manipulation.json', json_encode($taskList)); //сохранения результата в файл
            $response = http_build_query(array('success' => true)); //положительный результат
        } else
            $response = http_build_query(array('success' => false)); //отрицательный результат
    } else {
        $response = http_build_query(array('success' => false)); //отрицательный результат
    }
}
if (isset($_POST['remove_btn'])) { //Обработчик кнопки удалить, которая в index.php помечена как name="remove_btn"
    if (!empty($id)) { //Если имя не пустое
        foreach ($taskList as $key => $item) { //Если пустое поле токена и id
            if ($item['id'] == $id) {
                unset($taskList[$key]);
            }
        }
        $response = http_build_query(array('success' => true));
    } else {
        if (!empty($name)) {
            foreach ($taskList as $key => $item) {
                if ($item['name'] == $name) {
                    unset($taskList[$key]);
                }
            }
            $response = http_build_query(array('success' => true));
        } else {
            if (!empty($token)) {
                foreach ($taskList as $key => $item) { //Если пустое поле токена и id
                    if ($item['token'] == $token) {
                        unset($taskList[$key]);
                    }
                }
                $response = http_build_query(array('success' => true));
            } else {
                $response = http_build_query(array('success' => false));
            }
        }
    }
    file_put_contents('manipulation.json', json_encode($taskList)); //сохранения результата в файл
}
if (isset($_POST['change_btn'])) { //Обработчик кнопки изменить, которая в index.php помечена как name="change_btn"
    if (!empty($id) && !empty($token)) {
        foreach ($taskList  as $key => $value) {
            if (in_array($id, $value)) {
                $taskList[$key] = array('id' => $id, 'name' => $taskList[$key]['name'], 'token' => $token);
                $presence = true;
            }
        }

        if ($presence) {
            file_put_contents('manipulation.json', json_encode($taskList)); //сохранения результата в файл
            $response = http_build_query(array('success' => true)); //положительный результат
        } else {
            $response = http_build_query(array('success' => false)); //отрицательный результат
        }
    } else if (!empty($name) && !empty($token)) {
        foreach ($taskList  as $key => $value) {
            if (in_array($name, $value)) {
                $taskList[$key] = array('id' => $taskList[$key]['id'], 'name' => $name, 'token' => $token);
                $presence = true;
            }
        }
        if ($presence) {
            file_put_contents('manipulation.json', json_encode($taskList)); //сохранения результата в файл
            $response = http_build_query(array('success' => true)); //положительный результат
        } else {
            $response = http_build_query(array('success' => false)); //отрицательный результат
        }
    } else {
        $response = http_build_query(array('success' => false)); //отрицательный результат
    }
}

unset($taskList); //выгрузка $taskList из памяти

header('Location: index.php' . '?' . $response); //Переход обратно на страницу, с передачей параметра success => 0(не успешно/false)/1(успешно/true)
