<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    return htmlspecialchars($html);
}

function esUltimo(string $actual, string $proximo) : bool {
    return $actual !== $proximo;
}

// Revisar si el usuario está autenticado
function isAuth() : void {
    if(!isset($_SESSION['login'])) {
        header('Location: /');
    }
}
function isAdmin() : void {
    if(!isset($_SESSION['admin'])) {
        header('Location: /');
    }
}
