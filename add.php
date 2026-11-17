<?php
if (!defined('IN_APP')) { http_response_code(403); exit('Доступ запрещен'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button'])) {
    try {
        $sql = "INSERT INTO contacts (surname, name, lastname, gender, date, phone, location, email, comment) 
                VALUES (:surname, :name, :lastname, :gender, :date, :phone, :location, :email, :comment)";
        $stmt = $pdo->prepare($sql);
        $ok = $stmt->execute([
            ':surname'  => trim($_POST['surname'] ?? ''),
            ':name'     => trim($_POST['name'] ?? ''),
            ':lastname' => trim($_POST['lastname'] ?? ''),
            ':gender'   => $_POST['gender'] ?? 'мужской',
            ':date'     => $_POST['date'] ?? '',
            ':phone'    => trim($_POST['phone'] ?? ''),
            ':location' => trim($_POST['location'] ?? ''),
            ':email'    => trim($_POST['email'] ?? ''),
            ':comment'  => trim($_POST['comment'] ?? '')
        ]);

        if ($ok && !empty(trim($_POST['surname'])) && !empty(trim($_POST['name']))) {
            echo '<div class="success">Запись добавлена</div>';
        } else {
            echo '<div class="error">Ошибка: запись не добавлена</div>';
        }
    } catch (Exception $e) {
        echo '<div class="error">Ошибка: запись не добавлена</div>';
    }
}
?>

<form name="form_add" method="post">
    <div class="column">
        <div class="add"><label>Фамилия</label> <input type="text" name="surname" placeholder="Фамилия" required></div>
        <div class="add"><label>Имя</label> <input type="text" name="name" placeholder="Имя" required></div>
        <div class="add"><label>Отчество</label> <input type="text" name="lastname" placeholder="Отчество"></div>
        <div class="add">
            <label>Пол</label> 
            <select name="gender">
                <option value="мужской">мужской</option>
                <option value="женский">женский</option>
            </select>
        </div>
        <div class="add"><label>Дата рождения</label> <input type="date" name="date"></div>
        <div class="add"><label>Телефон</label> <input type="text" name="phone" placeholder="Телефон"></div>
        <div class="add"><label>Адрес</label> <input type="text" name="location" placeholder="Адрес"></div>
        <div class="add"><label>Email</label> <input type="email" name="email" placeholder="Email"></div>
        <div class="add"><label>Комментарий</label> <textarea name="comment" placeholder="Краткий комментарий"></textarea></div>
        <button type="submit" value="Добавить" name="button" class="form-btn">Добавить</button>
    </div>
</form>
