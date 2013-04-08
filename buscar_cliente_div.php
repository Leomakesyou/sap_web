<?php
	
if(!empty($_POST['dato'])) {
//echo "Resultados para: ".$_POST['dato']."<br />".$_POST['tipo']."-".$_POST['fila'];
search($_POST['dato'], $_POST['tipo'], $_POST['fila']);
} 
function search($valor, $tipo, $fila) {
	$valor = trim($valor);
	$fila = trim($fila);
include ("conexion/Conect_DB.php");
$link = mysql_connect($hostname_cn_MySQL, $username_cn_MySQL, $password_cn_MySQL) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_select_db($database_cn_MySQL, $link) or die (mysql_error());
if ($valor == '*')
{
	$sql  = "SELECT * FROM ocrd where groupcode = '100' ";
}
else{
	$sql  = "SELECT * FROM ocrd WHERE $tipo LIKE '%{$valor}%'";	
}

$sql .= " Order by $tipo";

$result = mysql_query($sql,$link) or die(mysql_error());	
$numDatos = @mysql_num_rows($result);

if ($numDatos > 0){

?>
<select name="listbox" id="<?= $fila; ?>" size="5" ondblclick="LlevarValor(this.value,this.id);" width="300px"> 
<!-- LlevarValor -->
<?php
$j = 1;
	while($row = mysql_fetch_assoc($result))
	{
			?>
			<option value="<?= $row[cardcode].";".$row[cardname] ?>"><?= $row[cardname] ?></option>
			<?php
	}
	?>
</select>
	<?php
}
else {
	echo "<br /><br /> No se han encontrado datos.";
}

//Create an array with the results
/*
$results=array();

while($v = mysql_fetch_object($sql)){
$results[] = array(
'login'=>$v->login,
'nomusuario'=>$v->nomusuario,
'idperfil'=>$v->idperfil
);
}
*/
//using JSON to encode the array
//echo json_encode($results);

}
?>

<html>
	<head>
		<script type="text/javascript" src="jquery.js"></script>
    	<script type="text/javascript">
    	function LlevarValor(valor, fila)
		    {
		    	var arreglo = valor.split(';');
		    	$("#cardcode").val(arreglo[0]);
		    	$("#cardname").val(arreglo[1]);
		    	var list1 = "cliente";
		    	Cab=eval(list1);
		    	with (Cab.style) 
						display="none";
				
				var list2 = "celda"+fila;
		    	Cab=eval(list2);
		    	with (Cab.style) 
						display="none";
			}

	</script>
	</head>
	
</html>