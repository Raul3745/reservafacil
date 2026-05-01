<?php
$conn = new mysqli("localhost", "root", "", "reservafacil");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

session_start();
?>