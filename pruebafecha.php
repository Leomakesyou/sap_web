<?php 
$conexion=mysqli_connect("184.154.9.82", "tqgroup_guest", "T&QGroup", "tqgroup_awid");


	$fecha = date("Ymd");
	$hora = date("His");



	$sql="SELECT  * from oscl";


	if(mysqli_query($conexion, $sql)){
		echo "<p>los datos se insertaron correctamente</p>";
	}
	else{
		echo "<p>pipe es marica</p>";
	}


// $customer = 'C80053934';
// $sql ="SELECT cardname from ocrd where cardcode = '$customer' ";
// $custmrNameqry = mysqli_query($conexion,$sql) or die (mysql_error());
// $custmrNamerow = mysqli_fetch_assoc($custmrNameqry);
// if ($customer <> ''){
// 	$custmrName = $custmrNamerow[cardname];
// }


echo $custmrName;
?>

