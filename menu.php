<?php
if (!defined('IN_APP')) { http_response_code(403); exit('Доступ запрещен'); }

function getMenu() {
    $page = $_GET['page'] ?? 'view';
    $sort = $_GET['sort'] ?? 'id';

    $menuItems = [
        'view'   => 'Просмотр',
        'add'    => 'Добавление записи',
        'edit'   => 'Редактирование записи',
        'delete' => 'Удаление записи'
    ];

    $html = '<header>';
    foreach ($menuItems as $key => $title) {
        $active = ($page === $key) ? 'class="active"' : '';
        $html .= "<a href=\"index.php?page=$key\" $active>$title</a>";
    }
    $html .= '</header>';

    if ($page === 'view') {
        $sortItems = [
            'id'      => 'По умолчанию',
            'surname' => 'По фамилии',
            'date'    => 'По дате рождения'
        ];
        $html .= '<div class="submenu">';
        foreach ($sortItems as $sKey => $sTitle) {
            $activeSub = ($sort === $sKey) ? 'class="active"' : '';
            $html .= "<a href=\"index.php?page=view&sort=$sKey\" $activeSub>$sTitle</a>";
        }
        $html .= '</div>';
    }

    return $html;
}
