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
<label>Cliente &nbsp; </label>
<select id="cardcode" name="cardcode" style="width:300px;">
	<option></option>
	<?php
		$sql  = "Select cardcode, cardname From ocrd ";
		$sql .= " Where id_integra = '$identificador'";
		$sql .= " Order by cardname";
		$result = $conexionMysql->db->Execute($sql);
		while ($row=$result->FetchNextObj())
		{  ?>
			<option value="<?= $row->cardcode; ?>" ><?= $row->cardcode . " - " . $row->cardname; ?></option>
		<?php
		}
	?>
</select>
</div>
<?php

}

?>