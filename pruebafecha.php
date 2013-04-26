<?php 
$conexion=mysqli_connect("localhost", "tqgroup_guest", "T&QGroup", "tqgroup_awid");


	// $fecha = date("Ymd");
	// $hora = date("His");



	// $sql="INSERT INTO oscl(createDate)
	// VALUES('$fecha')";


	// if(mysqli_query($conexion, $sql)){
	// 	echo "<p>los datos se insertaron correctamente</p>";
	// }
	// else{
	// 	echo "<p>pipe es marica</p>";
	// }


$customer = 'C80053934';
$sql ="SELECT cardname from ocrd where cardcode = '$customer' ";
$custmrNameqry = mysqli_query($conexion,$sql) or die (mysql_error());
$custmrNamerow = mysqli_fetch_assoc($custmrNameqry);
if ($customer <> ''){
	$custmrName = $custmrNamerow[cardname];
}


echo $custmrName;
?>

