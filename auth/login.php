<?php
include("../config/db.php");
include("../includes/header.php");

// Si envía el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    // Buscar usuario
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verificar contraseña
        if (password_verify($password, $user["password"])) {

            // Guardar sesión
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["role"] = $user["role"];
            $_SESSION["name"] = $user["name"];

            // Redirigir según rol
            if ($user["role"] == "admin") {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../user/dashboard.php");
            }
        } else {
            echo "Contraseña incorrecta";
        }

    } else {
        echo "Usuario no encontrado";
    }
}
?>
<div class="container">
<div class="auth-container">

    <h2>Iniciar sesión</h2>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <button class="btn btn-primary">Entrar</button>
        <p style="text-align:center; margin-top:10px;">
        ¿No tienes cuenta?
        </p>
        <a href="register.php" class="btn btn-secondary" style="display:block; text-align:center;">
        Registrarse
        </a>
        </p>
    </form>

</div>
</div>
<?php include("../includes/footer.php"); ?>