<?php
try {
    $pdo = new PDO("sqlite:" . __DIR__ . "/notebook.sqlite");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $pdo->exec("CREATE TABLE IF NOT EXISTS contacts (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        surname TEXT NOT NULL,
        name TEXT NOT NULL,
        lastname TEXT DEFAULT '',
        gender TEXT NOT NULL,
        date TEXT DEFAULT NULL,
        phone TEXT DEFAULT '',
        location TEXT DEFAULT '',
        email TEXT DEFAULT '',
        comment TEXT
    )");
} catch (PDOException $e) {
    die("Ошибка базы данных: " . $e->getMessage());
}
