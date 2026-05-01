<?php
include("../config/db.php");
include("../includes/header.php");

if ($_SESSION["role"] != "admin") {
    header("Location: ../auth/login.php");
}

// eliminar usuario
if (isset($_GET["delete"])) {
    $id = $_GET["delete"];
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location: users.php");
    exit();
}

$result = $conn->query("SELECT * FROM users");
?>

<div class="container">

<h2>Usuarios</h2>

<?php while($u = $result->fetch_assoc()): ?>
    <div class="card">
        <?= $u["name"] ?> (<?= $u["email"] ?>)
        <a href="?delete=<?= $r["id"] ?>" class="btn btn-danger">Eliminar</a>
    </div>
<?php endwhile; ?>

</div>

<?php include("../includes/footer.php"); ?>