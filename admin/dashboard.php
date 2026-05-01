<?php
include("../config/db.php");
include("../includes/header.php");

if ($_SESSION["role"] != "admin") {
    header("Location: ../auth/login.php");
}
?>
<div class="container-wide">
    <div class="panel">
        <h1>Panel de Administración</h1>

<?php
$totalUsers = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()["total"];
$totalRes = $conn->query("SELECT COUNT(*) as total FROM reservations")->fetch_assoc()["total"];
$totalServices = $conn->query("SELECT COUNT(*) as total FROM services")->fetch_assoc()["total"];
?>

<div class="dashboard">

    <div class="card">
        <h3>Usuarios registrados</h3>
        <p><?= $totalUsers ?></p>
    </div>

    <div class="card">
        <h3>Reservas</h3>
        <p><?= $totalRes ?></p>
    </div>

    <div class="card">
        <h3>Servicios</h3>
        <p><?= $totalServices ?></p>
    </div>

</div>

<div class="dashboard">

    <a href="calendar.php" class="card">📅 Ver calendario</a>
    <a href="users.php" class="card">👥 Usuarios</a>
    <a href="services.php" class="card">🛠 Servicios</a>
    <a href="reservations.php" class="card">📋 Reservas</a>

</div>

<?php
$totalUsers = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()["total"];
$totalRes = $conn->query("SELECT COUNT(*) as total FROM reservations")->fetch_assoc()["total"];
?>

</div>
</div>

<?php include("../includes/footer.php"); ?>