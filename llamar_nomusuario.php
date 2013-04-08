<?php  session_start();

 header("Cache-control: no-cache");
 require_once('conexion/conf.php');
 include $gloInclude . "/adodb.inc.php"; 
 include $clase_BD;
 //include ("conexion/Conect_DB.php");  

$conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);
$identificador = $_POST[identificador];
$accion = $_POST[accion];

if (isset($accion) && isset($identificador))
{

?>
<div align="center" id="cuadro">
<label>Nombre de Usuario &nbsp; </label>
<select id="usuarioweb" name="usuarioweb" style="width:300px;">
	<option></option>
	<?php
		$sql  = "Select login, nombre From usuarios ";
		$sql .= " Where activo = 'Y'";
		$sql .= " Order by nombre";
		$result = $conexionMysql->db->Execute($sql);
		while ($row=$result->FetchNextObj())
		{  ?>
			<option value="<?= $row->login; ?>" ><?= $row->login . " - " . $row->nombre; ?></option>
		<?php
		}
	?>
</select>
</div>
<?php

}

?>