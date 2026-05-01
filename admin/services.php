<?php
include("../config/db.php");
include("../includes/header.php");

//  ELIMINAR SERVICIO
if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    $conn->query("DELETE FROM services WHERE id=$id");

    header("Location: services.php");
    exit();
}

// Crear servicio
if (isset($_POST["name"])) {
    $name = $_POST["name"];
    $desc = $_POST["description"];

    $conn->query("INSERT INTO services (name, description) VALUES ('$name','$desc')");
}

// Listar servicios
$result = $conn->query("SELECT * FROM services");
?>

<div class="container">

<h2>Servicios</h2>

<form method="POST">
    <input name="name" placeholder="Nombre">
    <input name="description" placeholder="Descripción">
    <button>Crear</button>
</form>

<?php while($row = $result->fetch_assoc()): ?>
    <div class="card">
        <?= $row["name"] ?>
        <a href="?delete=<?= $r["id"] ?>" class="btn btn-danger">Eliminar</a>
    </div>
<?php endwhile; ?>

</div>

<?php include("../includes/footer.php"); ?>