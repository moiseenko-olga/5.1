<?php
if (!defined('IN_APP')) { http_response_code(403); exit('Доступ запрещен'); }

$list = $pdo->query("SELECT id, surname, name FROM contacts ORDER BY surname ASC, name ASC")->fetchAll();

if (empty($list)) {
    echo '<p>Записей для редактирования нет.</p>';
    return;
}

$currentId = isset($_GET['id']) ? (int)$_GET['id'] : (int)$list[0]['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button'])) {
    $sql = "UPDATE contacts SET surname = :surname, name = :name, lastname = :lastname, gender = :gender, 
            date = :date, phone = :phone, location = :location, email = :email, comment = :comment WHERE id = :id";
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
        ':comment'  => trim($_POST['comment'] ?? ''),
        ':id'       => $currentId
    ]);
    if ($ok) {
        echo '<div class="success">Запись обновлена</div>';
        $list = $pdo->query("SELECT id, surname, name FROM contacts ORDER BY surname ASC, name ASC")->fetchAll();
    }
}

$stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = :id");
$stmt->execute([':id' => $currentId]);
$row = $stmt->fetch();
?>

<div class="edit-container">
    <div class="div-edit">
        <?php foreach ($list as $item): ?>
            <?php $cls = ((int)$item['id'] === $currentId) ? 'class="currentRow"' : ''; ?>
            <a href="index.php?page=edit&id=<?= $item['id'] ?>" <?= $cls ?>>
                <?= htmlspecialchars($item['surname'] . ' ' . $item['name']) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <div style="flex: 1;">
        <form name="form_edit" method="post">
            <div class="column">
                <div class="add"><label>Фамилия</label> <input type="text" name="surname" value="<?= htmlspecialchars($row['surname'] ?? '') ?>" required></div>
                <div class="add"><label>Имя</label> <input type="text" name="name" value="<?= htmlspecialchars($row['name'] ?? '') ?>" required></div>
                <div class="add"><label>Отчество</label> <input type="text" name="lastname" value="<?= htmlspecialchars($row['lastname'] ?? '') ?>"></div>
                <div class="add">
                    <label>Пол</label> 
                    <select name="gender">
                        <option value="<?= htmlspecialchars($row['gender'] ?? '') ?>"><?= htmlspecialchars($row['gender'] ?? '') ?></option>
                        <option value="мужской">мужской</option>
                        <option value="женский">женский</option>
                    </select>
                </div>
                <div class="add"><label>Дата рождения</label> <input type="date" name="date" value="<?= htmlspecialchars($row['date'] ?? '') ?>"></div>
                <div class="add"><label>Телефон</label> <input type="text" name="phone" value="<?= htmlspecialchars($row['phone'] ?? '') ?>"></div>
                <div class="add"><label>Адрес</label> <input type="text" name="location" value="<?= htmlspecialchars($row['location'] ?? '') ?>"></div>
                <div class="add"><label>Email</label> <input type="email" name="email" value="<?= htmlspecialchars($row['email'] ?? '') ?>"></div>
                <div class="add"><label>Комментарий</label> <textarea name="comment"><?= htmlspecialchars($row['comment'] ?? '') ?></textarea></div>
                <button type="submit" value="Сохранить" name="button" class="form-btn">Сохранить</button>
            </div>
        </form>
    </div>
</div>
