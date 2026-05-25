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

function getCargo(): string {
    return (string)($_SESSION['cargo'] ?? '');
}

/**
 * Compatibilidad de roles antiguos:
 * - admin => gerente
 * - usuario => contador (por defecto, ajustable si necesitas otra compatibilidad)
 */

function normalizeCargo(string $cargo): string {
    $cargo = strtolower(trim($cargo));
    if ($cargo === 'admin') return 'gerente';
    if ($cargo === 'usuario') return 'contador';
    return $cargo;
}

function requireRole(array $roles) {
    requireAuth();
    $cargo = normalizeCargo(getCargo());
    if (!in_array($cargo, $roles, true)) {
        header('Location: dashboard.php?error=ups_algo_salio_mal');
        exit;
    }
}


function hasRole(string $role): bool {
    return normalizeCargo(getCargo()) === $role;
}

function currentUser() {
    return $_SESSION['usuario'] ?? '';
}

