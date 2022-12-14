<?php
$servername = "localhost";
$username = "root";
$password = "bigmais.123";
$dbname = "ticket_atendimento_geral";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
