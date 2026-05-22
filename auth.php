<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requireAuth() {
    if (empty($_SESSION['usuario'])) {
        header('Location: login.php');
        exit;
    }
}

function requireAdmin() {
    requireAuth();
    if (!isset($_SESSION['cargo']) || $_SESSION['cargo'] !== 'admin') {
        header('Location: dashboard.php');
        exit;
    }
}

function isAdmin() {
    return isset($_SESSION['cargo']) && $_SESSION['cargo'] === 'admin';
}

function currentUser() {
    return $_SESSION['usuario'] ?? '';
}
