<?php
include("../config/db.php");
include("../includes/header.php");

if ($_SESSION["role"] != "admin") {
    header("Location: ../auth/login.php");
}
?>

<div class="container-wide">

    <h2>Calendario de reservas</h2>

    <div id="calendar" style="margin: 40px 0;"></div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
        
        events: [
            <?php
            $res = $conn->query("
                SELECT reservations.*, users.name as user, services.name as service
                FROM reservations
                JOIN users ON reservations.user_id = users.id
                JOIN services ON reservations.service_id = services.id
            ");

            while($r = $res->fetch_assoc()):

            $color = "#3498db";

            ?>
            {
                title: '<?= $r["service"] ?> - <?= $r["user"] ?>',
                start: '<?= $r["date"] ?>',
                color: '<?= $color ?>'
            },
            <?php endwhile; ?>
        ]
    });

    calendar.render();
});
</script>

</div>

<?php include("../includes/footer.php"); ?>