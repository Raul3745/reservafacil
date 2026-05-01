<?php
include("../config/db.php");
include("../includes/header.php");

$services = $conn->query("SELECT * FROM services");
?>

<div class="container">

    <h1>Portal de reservas del Ayuntamiento</h1>

    <p>Servicios disponibles:</p>

    <div class="dashboard">

        <?php while($s = $services->fetch_assoc()): ?>
            <div class="card">
                <strong><?= $s["name"] ?></strong><br>
                <?= $s["description"] ?>
            </div>
        <?php endwhile; ?>

    </div>

    <?php if(isset($_SESSION["user_id"])): ?>

        <p>Ya has iniciado sesión</p>

        <a href="../user/my_reservations.php" class="btn btn-primary">
            Ver mis reservas
        </a>

    <?php else: ?>

        <a href="../auth/login.php" class="btn btn-primary">
            Iniciar sesión
        </a>

    <?php endif; ?>

</div>

<?php include("../includes/footer.php"); ?>