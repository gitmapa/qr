<?php
/**
 * Conexión a Postgres para el generador de PNG.
 * Ajustada para XAMPP + PHP crudo.
 * Cambiar xxxx por los datos de conexión
 */

$pg_host = "host=xxxx";
$pg_port = "port=5432";
$pg_db   = "dbname=xxxx";
$pg_user = "user=xxxx";
$pg_pass = "password=xxxx";

$pg_conn = pg_connect("$pg_host $pg_port $pg_db $pg_user $pg_pass");

if (!$pg_conn) {
    die("Error: no se pudo conectar a la base de datos Postgres.");
}
?>


