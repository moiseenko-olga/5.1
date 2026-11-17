<?php
if (!defined('IN_APP')) { http_response_code(403); exit('Доступ запрещен'); }

if (isset($_GET['del_id'])) {
    $delId = (int)$_GET['del_id'];
    $stmt = $pdo->prepare("SELECT surname FROM contacts WHERE id = :id");
    $stmt->execute([':id' => $delId]);
    $target = $stmt->fetch();

    if ($target) {
        $del = $pdo->prepare("DELETE FROM contacts WHERE id = :id");
        if ($del->execute([':id' => $delId])) {
            $surname = htmlspecialchars($target['surname']);
            echo "<div class=\"success\">Запись с фамилией $surname удалена</div>";
        }
    }
}

$contacts = $pdo->query("SELECT id, surname, name, lastname FROM contacts ORDER BY surname ASC, name ASC")->fetchAll();

if (empty($contacts)) {
    echo '<p>Записей для удаления нет.</p>';
} else {
    echo '<div class="delete-list">';
    foreach ($contacts as $c) {
        $initials = iconv_substr($c['name'], 0, 1, 'UTF-8') . '.';
if (!empty($c['lastname'])) {
    $initials .= ' ' . iconv_substr($c['lastname'], 0, 1, 'UTF-8') . '.';
}
        
        $text = htmlspecialchars($c['surname'] . ' ' . $initials);
        echo "<a href=\"index.php?page=delete&del_id={$c['id']}\">$text</a>";
    }
    echo '</div>';
}