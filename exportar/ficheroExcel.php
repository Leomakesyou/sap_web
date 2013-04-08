<?php 

header("Content-Type: application/octet-stream");
header("Content-Type: application/download"); 
header ("Content-type: application/xls");	
//header ("Content-type: application/csv; charset=utf-8");
header ("Content-type: application/vnd.msexcel"); 
header ("Content-Description: File Transfer");
header ("Content-Disposition: attachment; filename=Informe_Generado.xls");
header ("Expires: 0");  
header ("Pragma: cache");
header ('Cache-Control: public');

/*header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=ficheroExcel.xls");
header("Pragma: no-cache");
header("Expires: 0");*/

$_POST['datos_a_enviar'] = str_replace("DISPLAY:"," ",$_POST['datos_a_enviar']);
$_POST['datos_a_enviar'] = str_replace("display:"," ",$_POST['datos_a_enviar']);
$_POST['datos_a_enviar'] = str_replace("none"," ",$_POST['datos_a_enviar']);

echo $_POST['datos_a_enviar'];


?>