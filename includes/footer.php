</main>
<footer>
    <p>ReservaFacil - Proyecto DAW</p>
</footer>
<script>
function toggleDarkMode() {
    document.body.classList.toggle("dark");

    let btn = document.getElementById("darkBtn");

    if (document.body.classList.contains("dark")) {
        localStorage.setItem("darkMode", "on");
        btn.textContent = "☀️";
    } else {
        localStorage.setItem("darkMode", "off");
        btn.textContent = "🌙";
    }
}

window.onload = function() {
    let btn = document.getElementById("darkBtn");

    if (localStorage.getItem("darkMode") === "on") {
        document.body.classList.add("dark");
        btn.textContent = "☀️";
    }
};
</script>
</body>
</html>