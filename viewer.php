<?php
if (!defined('IN_APP')) { http_response_code(403); exit('Доступ запрещен'); }

function renderViewer($sort = 'id', $p = 1) {
    global $pdo;

    $allowedSorts = ['id' => 'id ASC', 'surname' => 'surname ASC', 'date' => 'date ASC'];
    $orderBy = $allowedSorts[$sort] ?? 'id ASC';

    $limit = 10;
    $p = max(1, (int)$p);
    $offset = ($p - 1) * $limit;

    $totalRows = $pdo->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
    $totalPages = ceil($totalRows / $limit);

    $stmt = $pdo->prepare("SELECT * FROM contacts ORDER BY $orderBy LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll();

    $html = '<table>';
    $html .= '<tr>
                <th>Фамилия</th><th>Имя</th><th>Отчество</th><th>Пол</th>
                <th>Дата рождения</th><th>Телефон</th><th>Адрес</th><th>Email</th><th>Комментарий</th>
              </tr>';

    if (empty($rows)) {
        $html .= '<tr><td colspan="9">Записей пока нет</td></tr>';
    } else {
        foreach ($rows as $r) {
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($r['surname']) . '</td>';
            $html .= '<td>' . htmlspecialchars($r['name']) . '</td>';
            $html .= '<td>' . htmlspecialchars($r['lastname']) . '</td>';
            $html .= '<td>' . htmlspecialchars($r['gender']) . '</td>';
            $html .= '<td>' . htmlspecialchars($r['date']) . '</td>';
            $html .= '<td>' . htmlspecialchars($r['phone']) . '</td>';
            $html .= '<td>' . htmlspecialchars($r['location']) . '</td>';
            $html .= '<td>' . htmlspecialchars($r['email']) . '</td>';
            $html .= '<td>' . htmlspecialchars($r['comment']) . '</td>';
            $html .= '</tr>';
        }
    }
    $html .= '</table>';

    if ($totalPages > 1) {
        $html .= '<div class="pagination">';
        for ($i = 1; $i <= $totalPages; $i++) {
            $active = ($i === $p) ? 'class="active"' : '';
            $html .= "<a href=\"index.php?page=view&sort=$sort&p=$i\" $active>$i</a>";
        }
        $html .= '</div>';
    }

    return $html;
}
