<?php
// declare (strict_types=1);

function debuguear($variable): string
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html): string
{
    $s = htmlspecialchars($html);
    return $s;
}

function esUltimo($actual, $proximo): bool
{
    if ($actual !== $proximo) {
        return true;
    }
    return false;
}

/**Verificar si el usuario esta autenticado */
function isAuth(): void
{
    /**Verificar si la superglobal esta definida o no */
    if (!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

/**Verificar si el admin esta verificado */
function isAdmin(): void
{
    if (!isset($_SESSION['admin'])) {
            header('Location: /');
    }
}
