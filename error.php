<?php
//  header("Cache-control: no-cache");
 require_once('conexion/conf.php');
 $idioma = $_SESSION['idioma'];
 $ArchivoLangaje = "config/lenguaje/" . $idioma . ".php";
//****************************************************
function error_handler($level, $message, $file, $line, $context) {
    //Handle user errors, warnings, and notices ourself
    if($level === E_USER_ERROR || $level === E_USER_WARNING || $level === E_USER_NOTICE) {
        echo '<strong>Error: </strong> '.$message;
        return(true); //And prevent the PHP error handler from continuing
    }
    return(false); //Otherwise, use PHP's error handler
}
function trigger_my_error($message, $level, $numerror) {
    ?>
	<br>
	<table border=0 width="80%" align="center">
		<tr>
			<td class="label_error">
				<img src="<?= $gloRutaPublica."/pqr/imagenes/error.png"; ?>" height="30" width="30" />
	<?PHP	
	//Get the caller of the calling function and details about it
    $callee = next(debug_backtrace());
    	//Trigger appropriate error
    	trigger_error('<BR>'.$numerror.' '. $message.' En <strong>'.$callee['file'].'</strong> Linea <strong>'.$callee['line'].'</strong>', $level);
	?>
			</td>
		</tr>
	</table>
	<?php 
}
//Use our custom handler
set_error_handler('error_handler');
//****************************************************
?>