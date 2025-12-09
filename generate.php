<?php
/******************************************************************
 * GENERADOR PNG POR CUI + LOCAL
 * PHP crudo – XAMPP – Postgres – GD
 * Versión calibrada con coordenadas fijas (CUI/SALA)
 ******************************************************************/

require 'db.php';
date_default_timezone_set("America/Argentina/Buenos_Aires");

// -------------------------------------------------------------
// CONFIG
// -------------------------------------------------------------

$base_img_path = __DIR__ . "/base/base.png";

/*** AQUÍ TOCÁS LA FUENTE DEL TEXTO ***/
$font_path = __DIR__ . "/fonts/Archivo-Medium.ttf";

/*** AQUÍ TOCÁS EL TAMAÑO DEL TEXTO ***/
$font_size = 130;

/*** AQUÍ TOCÁS EL COLOR DEL TEXTO (R, G, B) ***/
$text_color_rgb = [4, 48, 68];

$output_root = __DIR__ . "/output/";

if (!file_exists($base_img_path)) die("No se encuentra plantilla.");
if (!file_exists($font_path)) die("No se encuentra la fuente.");
if (!is_dir($output_root)) mkdir($output_root, 0777, true);


// -------------------------------------------------------------
// COORDENADAS FIJAS (definidas por el diseño del PNG)
// -------------------------------------------------------------
$x_valor  = 750;   // Columna fija donde se imprimen todos los valores
$y_CUI    = 972;   // Línea del valor de CUI
$y_SALA   = 1230;   // Línea del valor de Sala/aula


// -------------------------------------------------------------
// QUERY
// -------------------------------------------------------------
$q = "
    SELECT cui, local
    FROM cuis.aulas_qr
    ORDER BY local ASC
    LIMIT 6;
";

$res  = pg_query($pg_conn, $q);
$rows = pg_fetch_all($res);
if (!$rows) die("Query sin resultados.");


// -------------------------------------------------------------
// LOOP PARA GENERAR PNG
// -------------------------------------------------------------
$total = 0;

foreach ($rows as $r) {

    $cui   = trim($r['cui']);
    $local = trim($r['local']);

    // Texto a imprimir
    $line1 = $cui;
    $line2 = $local;

    // Carpeta por CUI
    $folder = $output_root . $cui . "/";
    if (!is_dir($folder)) mkdir($folder, 0777, true);

    $outfile = $folder . "{$cui}_{$local}.png";

    // Cargar la base
    $img = imagecreatefrompng($base_img_path);

    // Color del texto
    $color = imagecolorallocate($img, $text_color_rgb[0], $text_color_rgb[1], $text_color_rgb[2]);

    // ---------------------------------------------------------
    // IMPRESIÓN FIJA EN SUS COORDENADAS
    // ---------------------------------------------------------
    // Nueva columna para Sala/aula (200 px a la derecha)
    $x_valor_sala = $x_valor + 390;

    imagettftext($img, $font_size, 0, $x_valor,       $y_CUI,  $color, $font_path, $line1);
    imagettftext($img, $font_size, 0, $x_valor_sala,  $y_SALA, $color, $font_path, $line2);

    // Guardar
    imagepng($img, $outfile);
    imagedestroy($img);

    $total++;
}


// -------------------------------------------------------------
// FIN
// -------------------------------------------------------------
echo "<h2>OK</h2>";
echo "<p>Generadas <strong>$total</strong> imágenes.</p>";
echo "<p>Salida en <code>/output/</code></p>";

?>
