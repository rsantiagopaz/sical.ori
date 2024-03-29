<?php
include("../control_acceso_flex.php");
include("../rutinas.php");

$html='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
body{font-size:13px;font-family:Arial, Helvetica, Serif;margin: 0 auto; width: 850px;}
h1,h2,h3{text-align:center;background-color:#999999;}
h1{font-size:20px;}
h2{font-size:18px;}
h3{font-size:15px;}
table{width:100%; border-collapse: collapse;}
th{font-weight: bold;text-align:center;background-color:#CCCCCC;}
.title{background-color:#CCCCCC;font-weight:bold;}
</style>
</head>
<body>';

$sql="SELECT * FROM escuelas WHERE id_escuela='$id_escuela'";						
				
$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
$row = mysqli_fetch_array($result);

$width="700px";

$html.='<h1 style="width:'.$width.'">Carreras y Espacios por Escuela</h1>';
$date = date("d/m/Y");
$html.='<h3 style="width:'.$width.'">Fecha: '. $date .'</h3>';
$html.='<h3 style="width:'.$width.'">ESCUELA: '.$row['nombre'].'</h3>';
		
$sql="SELECT id_escuela_carrera_espacio, id_carrera, cod_carrera, id_espacio, cod_espacio, nombre, denominacion, n.id_nivel 'id_nivel', 'A' as origen ";
$sql.="FROM escuelas_carreras_espacios ";
$sql.="INNER JOIN carreras ca USING(id_carrera) ";
$sql.="INNER JOIN espacios USING(id_espacio) ";
$sql.="INNER JOIN niveles n ON ca.id_nivel = n.id_nivel ";	
$sql.="WHERE id_escuela = '$id_escuela' ";
if ($SYSusuario_nivel_id != '4' && $_SESSION['usuario_organismo_area_id'] != '6')	
	$sql.="AND n.id_nivel = '$SYSusuario_nivel_id' ";
$sql.="ORDER BY nombre";

$result = mysqli_query($GLOBALS["___mysqli_ston"], $sql);
		
$html.='<table style="width:700px;">
			<tr>
				<td class="title" style="width:80px;">Cod. Carr.</td>
				<td class="title" style="width:200px;">Nombre</td>
				<td class="title" style="width:200px;">Cod. Esp.</td>
				<td class="title" style="width:220px;">Denominación</td>
			</tr>';
while ($row = mysqli_fetch_array($result)) {
	$html.='<tr>
				<td>'.$row['cod_carrera'].'</td>
				<td>'.$row['nombre'].'</td>
				<td>'.$row['cod_espacio'].'</td>
				<td>'.$row['denominacion'].'</td>
			</tr>';											
}
$html.='</table>';
$html.='</body></html>';

echo $html;	
?>