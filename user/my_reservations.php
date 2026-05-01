<?php
include("../config/db.php");
include("../includes/header.php");

// ELIMINAR RESERVA
if (isset($_GET["delete"])) {
    $id = $_GET["delete"];

    $conn->query("DELETE FROM reservations WHERE id=$id");

    header("Location: my_reservations.php");
    exit();
}

// MOSTRAR ERRORES (debug)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// MENSAJES
if (isset($_GET["error"])) {
    echo "<p style='color:red;'>Ese servicio ya está reservado ese día</p>";
}

if (isset($_GET["success"])) {
    echo "<p style='color:green;'>Reserva realizada correctamente</p>";
}

if (isset($_GET["error"]) && $_GET["error"] == "ya_reserva") {
    echo "<p style='color:red;'>Ya tienes una reserva activa de este servicio</p>";
}

// PROCESAR FORMULARIO
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $service_id = $_POST["service_id"];
    $date = $_POST["date"];
    $user_id = $_SESSION["user_id"];

    // COMPROBAR SI EL USUARIO YA TIENE ESE SERVICIO
    $checkUser = $conn->query("SELECT * FROM reservations 
        WHERE user_id='$user_id' AND service_id='$service_id'");

    if ($checkUser->num_rows > 0) {
        header("Location: my_reservations.php?error=ya_reserva");
        exit();
    }

    // COMPROBAR SI YA EXISTE
    $check = $conn->query("SELECT * FROM reservations 
        WHERE service_id='$service_id' AND date='$date'");

    if ($check->num_rows > 0) {
        header("Location: my_reservations.php?error=ocupado");
        exit();
    }

    // INSERT + REDIRECT
    if ($conn->query("INSERT INTO reservations (user_id, service_id, date)
        VALUES ('$user_id','$service_id','$date')")) {

        header("Location: my_reservations.php?success=1");
        exit();
    }
}

// CONSULTAS
$services = $conn->query("SELECT * FROM services");

$reservations = $conn->query("
    SELECT reservations.*, services.name 
    FROM reservations
    JOIN services ON reservations.service_id = services.id
    WHERE user_id = ".$_SESSION["user_id"]
);
?>

<div class="container">

<h2>Reservas municipales</h2>

<p>Visualiza tus reservas en el calendario</p>

<div id="calendar" style="margin: 40px 0;"></div>

<form method="POST" onsubmit="return validarFecha()">
    <select name="service_id" required>
        <option value="">Selecciona un servicio</option>
        <?php while($s = $services->fetch_assoc()): ?>
            <option value="<?= $s["id"] ?>"><?= $s["name"] ?></option>
        <?php endwhile; ?>
    </select>

    <input type="date" name="date" required>
    <button>Reservar</button>
</form>

<?php if ($reservations->num_rows == 0): ?>
    <p>No tienes reservas aún</p>
<?php endif; ?>

<?php while($r = $reservations->fetch_assoc()): ?>
    <div class="card">
        <strong><?= $r["name"] ?></strong><br>
        Fecha: <?= $r["date"] ?><br>

        <a href="?delete=<?= $r["id"] ?>" class="btn btn-danger">Cancelar</a>
    </div>
<?php endwhile; ?>

<script>

document.addEventListener('DOMContentLoaded', function() {

    var calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    // ARRAY CORRECTO (service + date)
    var reservas = [
    <?php
    $resAll = $conn->query("SELECT service_id, date FROM reservations");
    while($r = $resAll->fetch_assoc()):
    ?>
    {
        service: '<?= $r["service_id"] ?>',
        date: '<?= $r["date"] ?>'
    },
    <?php endwhile; ?>
    ];

    // CALENDARIO
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true,
        locale: 'es',

        dateClick: function(info) {

            let selectedService = document.querySelector("select[name='service_id']").value;

            if (!selectedService) {
                alert("Selecciona primero un servicio");
                return;
            }

            let ocupado = reservas.some(r => 
                r.service == selectedService && r.date == info.dateStr
            );

            if (ocupado) {
            alert("Este servicio no está disponible en esa fecha");
            return;
            }

            document.querySelector("input[name='date']").value = info.dateStr;
        },

        events: [
        <?php
        $res = $conn->query("
            SELECT reservations.*, services.name 
            FROM reservations
            JOIN services ON reservations.service_id = services.id
        ");

        while($r = $res->fetch_assoc()):

        // DIFERENCIAR USUARIO
        if ($r["user_id"] == $_SESSION["user_id"]) {
            $color = "#3498db"; // azul → tu reserva
            $title = $r["name"];
        } else {
            $color = "#e74c3c"; // rojo → ocupado por otro
            $title = $r["name"];
        }
        ?>
        {
            title: '<?= $title ?>',
            start: '<?= $r["date"] ?>',
            color: '<?= $color ?>'
        },
        <?php endwhile; ?>
        ]
    });

    calendar.render();

    // VALIDACIÓN FORMULARIO
    window.validarFecha = function() {
        let fecha = document.querySelector("input[name='date']").value;
        let servicio = document.querySelector("select[name='service_id']").value;

        let ocupado = reservas.some(r => 
            r.service == servicio && r.date == fecha
        );

        if (ocupado) {
            alert("Ese servicio ya está reservado ese día");
            return false;
        }

        return true;
    }

});
</script>

</div>

<?php include("../includes/footer.php"); ?>