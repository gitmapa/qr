<?php
/**
 * Conexión a Postgres para el generador de PNG.
 * Ajustada para XAMPP + PHP crudo.
 */

$pg_host = "host=localhost";
$pg_port = "port=5432";
$pg_db   = "dbname=sig";
$pg_user = "user=postgres";
$pg_pass = "password=Qatarairways";

$pg_conn = pg_connect("$pg_host $pg_port $pg_db $pg_user $pg_pass");

if (!$pg_conn) {
    die("Error: no se pudo conectar a la base de datos Postgres.");
}
?>
