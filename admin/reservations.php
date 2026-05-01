<?php
include("../config/db.php");
include("../includes/header.php");

if ($_SESSION["role"] != "admin") {
    header("Location: ../auth/login.php");
    exit();
}

//  ELIMINAR RESERVA
if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    $conn->query("DELETE FROM reservations WHERE id=$id");

    header("Location: reservations.php");
    exit();
}

//  OBTENER RESERVAS
$result = $conn->query("
    SELECT reservations.*, users.name as user, services.name as service
    FROM reservations
    JOIN users ON reservations.user_id = users.id
    JOIN services ON reservations.service_id = services.id
");
?>

<div class="container">
    
<h2>Reservas (Admin)</h2>

<?php while($r = $result->fetch_assoc()): ?>
    <div class="card">
        <strong><?= $r["user"] ?></strong><br>
        <?= $r["service"] ?><br>
        Fecha: <?= $r["date"] ?><br>

        <a href="?delete=<?= $r["id"] ?>" class="btn btn-danger">Eliminar</a>
    </div>
<?php endwhile; ?>

</div>

<?php include("../includes/footer.php"); ?>