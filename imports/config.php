<?php

$menu_items = [
    ['title' => 'Главная', 'file' => 'index.php', 'access' => ['guest', 'author', 'admin']],
    ['title' => 'Блоги', 'file' => 'posts.php', 'access' => ['guest', 'author', 'admin']],
    ['title' => 'Пользователи', 'file' => 'users.php', 'access' => ['admin']],
    ['title' => 'О нас', 'file' => 'about.php', 'access' => ['guest', 'author', 'admin']],
    ['title' => 'Вход', 'file' => 'login.php', 'access' => ['guest']],
    ['title' => 'Регистрация', 'file' => 'register.php', 'access' => ['guest']],
    ['title' => 'Выход', 'file' => 'logout.php', 'access' => ['author', 'admin']],
];

$db_params = [
    'hostname' => '127.0.0.1',
    'username' => 'root',
    'password' => '',
    'database' => 'posts_system',
    'port' => "3306",
    'charset' => 'utf8mb4',
];
