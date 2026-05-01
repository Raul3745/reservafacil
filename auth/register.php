<?php
include("../config/db.php");
include("../includes/header.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password)
            VALUES ('$name','$email','$password')";

    if ($conn->query($sql)) {
        echo "Usuario registrado";
    } else {
        echo "Error";
    }
}
?>

<div class="container">

<h2>Crear cuenta</h2>
<p>Regístrate para poder realizar reservas</p>

<form method="POST" onsubmit="return validar()">
    <input type="text" name="name" placeholder="Nombre" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button>Registrarse</button>
</form>

<script>
function validar() {
    let pass = document.querySelector("input[name='password']").value;

    if (pass.length < 4) {
        alert("La contraseña debe tener al menos 4 caracteres");
        return false;
    }
}
</script>

</div>

<?php include("../includes/footer.php"); ?>