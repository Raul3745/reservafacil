<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ReservaFacil</title>

    <link rel="stylesheet" href="/reservafacil/public/style.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

</head>
<body>

<nav>

    <a href="/reservafacil/public/index.php">Inicio</a>

    <?php if(isset($_SESSION["user_id"])): ?>

        <?php if($_SESSION["role"] == "admin"): ?>
            <a href="/reservafacil/admin/dashboard.php">Admin</a>
            <a href="/reservafacil/admin/calendar.php">Calendario</a>
            <a href="/reservafacil/admin/users.php">Usuarios</a>
            <a href="/reservafacil/admin/services.php">Servicios</a>
            <a href="/reservafacil/admin/reservations.php">Reservas</a>
        <?php else: ?>
            <a href="/reservafacil/user/dashboard.php">Mi panel</a>
            <a href="/reservafacil/user/my_reservations.php">Mis reservas</a>
        <?php endif; ?>

        <button id="darkBtn" onclick="toggleDarkMode()">🌙</button>

        <a href="/reservafacil/auth/logout.php">Logout</a>

    <?php else: ?>
        <a href="/reservafacil/auth/login.php">Login</a>
    <?php endif; ?>

</nav>

<main>