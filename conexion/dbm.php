<?php
//require ('adodb.inc.php');
///////////////////////////////////////////////////////////////////
 //Clase para gestionar las operaciones a bases de datos MYSQL
 class ConectarMysql
 {
 	var $db;

 	// Constructor del objeto de conexión a la base de datos
 	function ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword) 
	{
  		$this->db = &ADONewConnection("$gloDbDriver"); 
		$this->db->Connect("$gloDbHost", "$gloDbUser", "$gloDbPassword", "$gloDb")
   			or die("Problemas Conectandose al Servidor de Base de Datos MYSQL");
		$this->db->SetFetchMode(ADODB_FETCH_ASSOC);
		//$this->db->debug= true;

	}

 	function cerrar() 
	{
  		$this->db->Close();
 	}	

 	function error($Url, $Mensaje, $Script, $Detalle="")
 	{
		if ($Detalle <> "")
			$Mensaje= $Mensaje . "<br><br> Detalle Error : " . $Detalle .  "<br><br> Script : " . $Script;
		else
			$Mensaje= $Mensaje . "<br><br> Detalle Error : " . $this->db->ErrorMsg() . "<br><br> Error Número : " .  $this->db->ErrorNo() . "<br><br> Script : " . $Script;
		$this->cerrar();
		header("location: $Url?Error=$Mensaje");
		exit;
	}
 }
 
///////////////////////////////////////////////////////////////////
 //Clase para gestionar las operaciones a bases de datos ISERIES
 class ConectarIseries
 {
 	var $db;

 	// Constructor del objeto de conexión a la base de datos
 	function ConectarIseries($gloDbDriverIseries, $gloDbDsnIseries, $gloDbUserIseries, $gloDbPasswordIseries) 
	{
  		$this->db = &ADONewConnection("$gloDbDriverIseries"); 
		$this->db->Connect("$gloDbDsnIseries", "$gloDbUserIseries", "$gloDbPasswordIseries")
   			or die("Problemas Conectandose al Servidor de Base de Datos ISERIES");
		$this->db->SetFetchMode(ADODB_FETCH_ASSOC);
		//$this->db->debug= true;

	}
	
 	function cerrar() 
	{
  		$this->db->Close();
 	}	
	////	////	////
 	function error($Url, $Mensaje, $Script, $Detalle="")
 	{
		if ($Detalle <> "")
			$Mensaje= $Mensaje . "<br><br> Detalle Error : " . $Detalle .  "<br><br> Script : " . $Script;
		else
			$Mensaje= $Mensaje . "<br><br> Detalle Error : " . $this->db->ErrorMsg() . "<br><br> Error Número : " .  $this->db->ErrorNo() . "<br><br> Script : " . $Script;
		$this->cerrar();
		header("location: $Url?Error=$Mensaje");
		exit;
	}
 }

///////////////////////////////////////////////////////////////////
 //Clase para gestionar conexiones a mysql sin ADODB
 class Conexion  {
 	var $status,$numerg;

 	// Constructor del objeto de conexión a la base de datos
 	function Conexion($gloDbHost, $gloDb, $gloDbUser, $gloDbPassword) 
	{
  		$this->status = mysql_pconnect("$gloDbHost", "$gloDbUser", "$gloDbPassword")
   			or die("Problemas Conectandose al servidor de base de datos");

  		//conexion si existe DB
  		if(isset($gloDb) && $gloDb <> "")
		{
   			mysql_select_db("$gloDb")
    			or die("Problemas Conectandose a la base de datos $gloDb");
  		}
 	}
 }
///////////////////////////////////////////////////////////////////

?>