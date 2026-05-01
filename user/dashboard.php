<?php include("../includes/header.php"); ?>

<div class="container">

    <h1>Bienvenido, <?= $_SESSION["name"] ?? "usuario" ?></h1>

    <div class="dashboard">

        <a href="my_reservations.php" class="card">
            📅 Mis reservas
        </a>

        <a href="../auth/logout.php" class="card">
            🚪 Cerrar sesión
        </a>

    </div>

</div>

<?php include("../includes/footer.php"); ?>