<?php
header('Content-Type:text/html; charset=ISO-8859-1'); 
//Variables utilizadas en todo el programa
//referencias

$gloRutaPublica= "http://" . $_SERVER[HTTP_HOST] . "/sqrf";
$gloRutaAdmin= $gloRutaPublica . "/admon_general";
$gloRutaAplicacion= $gloRutaPublica . "/extranet";
$gloRutaErrorAdmin= $gloRutaAdmin . "/error.php";
$gloRutaErrorAplicacion= $gloRutaAplicacion . "/error.php";
$gloRutaVentanaAplicacion= $gloRutaAplicacion . "/abre_ventana.php";
$gloRutaAyudaAplicacion= $gloRutaAplicacion . "/ayuda/";
$gloRutaSecureImage = $gloRutaPublica . "/includes/securimage";
$gloRutaLenguaje = $gloRutaPublica . "/config/lenguaje";

$gloPathPublica= $_SERVER[DOCUMENT_ROOT] . "/sqrf";
$gloPathAdmin= $gloPathPublica . "/admon_general";
$gloPathAplicacion= $gloPathPublica . "/extranet";
$gloTamanoArchivos= "50000000";

$gloInclude= $gloPathPublica . "/conexion";
$gloIncludeAdmin= $gloInclude . "/adm_includes";
$gloIncludeAplicacion= $gloInclude . "/extranet_includes";
$gloPathAplicacionMenus= $gloInclude . "/menus";
$gloPathAplicacionMenusClientes= $gloInclude . "/menus_clientes";
$gloPathAplicacionMenusFinales= $gloInclude . "/menus_finales";
$gloIncludeIdiomas= $gloInclude . "/idiomas";
$gloIncludeFpdf= $gloInclude . "/fpdf";
$gloIncludeEditorHtml= $gloInclude . "/area_html";
$gloBaseEditorHtml= "/consultas/includes/area_html/";
$gloIncludeSecureImage = $gloInclude . "/securimage";
$gloIncludeNuSoap = $gloInclude . "/nusoap";
//***************************************************
$gloArchivoInicio = $gloRutaPublica . "/inicio.php";
$gloArchivoValida = $gloInclude . "/validar.php";
$gloArchivoComprueba = $gloRutaPublica . "/comprueba.php";
$ArchivoIdioma = $gloRutaLenguaje . "/idioma.php";
$ArchivoError = $gloRutaPublica . "/error.php";
$Color_Celda1 = "#989ACB";	//Color Azul opaco
$Color_Celda2 = "#1A50B8";	//Color Azul Servi 
$Color_Celda3 = "#CCCCCC";	//Color Gris
//ERROR NUMERO 1 = CONSULTAS
//***************************************************

$gloIdiomaAplicacion= "es";

$gloAdodb= $gloInclude . "/adodb";
//***********************************************
$clase_BD= $gloInclude . "/dbm.php";
//***********************************************

$gloPaginar= $gloInclude . "/paginar.php";

$gloNombrePublico= " SISTEMA DE CONSULTA ::";
$gloNombreAdmin= " ADMINISTRADOR GENERAL ::";
$gloNombreAplicacion= " SISTEMA DE CONSULTA ::";

$gloNombreCliente= "SERVIEFECTIVO S.A.";
$gloNumRegistro= "";
$gloVersionPaquete= "Versión 1.0 - 2009.";

//base de datos
//mysql
$gloDbDriver= "mysqlt";
$gloDbHost= "localhost";
$gloDb= "verificacion_email";
$gloDbUser= "root";
$gloDbPassword = "misato28";

//Db Usuarios
$gloBaseUsuarios = "serviefectivo";


//iSeries
$gloDbDriverIseries = "odbc"; //ADODB driver
$gloDbHostIseries = "192.168.2.3";
$gloDbPortIseries = "50000";
//
$gloDbEsqIseries = "";
$gloDbUserIseries = "SSPEBS";
$gloDbPasswordIseries = "woigxnme";
$gloDbDsnIseries = "DRIVER={iSeries Access ODBC Driver};SYSTEM=$gloDbHostIseries;DATABASE=$gloDbEsqIseries;PROTOCOL=TCPIP;PORT=$gloDbPortIseries;"; 

//Aspecto en Pantalla
//Cantidad de registros que contendrá como máximo cada página en administrador.
$pagi_cuantos= 20;
//Cantidad de enlaces a los números de página que se mostrarán como máximo en la barra de navegación en administrtador
$nav_num_enlaces= 10;
//Cantidad de registros que contendrá como máximo cada página en extranet.
$gloNumPagExtranet= 20;
//Cantidad de registros que contendrá como máximo cada resumes en extranet.
$gloNumResExtranet= 20;
//////////////////////////////////////////////////////////////
//---------------------------------------2010/11/16
$Login;
$Nomusuario;
$Codusuario;
$Codperfil;

//****************************************
function restaFechas($dFecIni, $dFecFin)
{
    $dFecIni = str_replace("-","",$dFecIni);
    $dFecIni = str_replace("/","",$dFecIni);
    $dFecFin = str_replace("-","",$dFecFin);
    $dFecFin = str_replace("/","",$dFecFin);

    ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecIni, $aFecIni);
    ereg( "([0-9]{1,2})([0-9]{1,2})([0-9]{2,4})", $dFecFin, $aFecFin);

    $date1 = mktime(0,0,0,$aFecIni[2], $aFecIni[1], $aFecIni[3]);
    $date2 = mktime(0,0,0,$aFecFin[2], $aFecFin[1], $aFecFin[3]);

    return round(($date2 - $date1) / (60 * 60 * 24));
}

function suma_fechas($fecha,$ndias)
 {
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
              list($dia,$mes,$año)=split("/", $fecha);
      

      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
              list($dia,$mes,$año)=split("-",$fecha);

        $nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
        $nuevafecha=date("d-m-Y",$nueva);

      return ($nuevafecha);  
}

function FechaVencimiento($MaxDias)
{ 
     for ($i=0; $i<$MaxDias; $i++)  
     {  
         //Acumulamos la cantidad de segundos que tiene un dia en cada vuelta del for  
         $Segundos = $Segundos + 86400;  
         //Obtenemos el dia de la fecha, aumentando el tiempo en N cantidad de dias, segun la vuelta en la que estemos  
         $caduca = date("D",time()+$Segundos);  
         //Comparamos si estamos en sabado o domingo, si es asi restamos una vuelta al for, para brincarnos el o los dias...  
         	if ($caduca == "Sat")  
             { $i--;  }  
           else if ($caduca == "Sun")  
             {  $i--; }  
           else  
             {  //Si no es sabado o domingo, y el for termina y nos muestra la nueva fecha  
               $FechaFinal = date("Y-m-d",time()+$Segundos);  
             }  
     }
	 return $FechaFinal;  
}


////////////////////////////////////////////////////////////

function cambiarFormatoFecha($fecha){
    list($dia,$mes,$anio)=explode("-",$fecha);
    return $anio."-".$mes."-".$dia;
}  

function FormatoFechaResta($fecha){
    list($anio,$mes,$dia)=explode("-",$fecha);
    return $dia."/".$mes."/".$anio;
}

/////////////////////////////////////////////////////////
function EncriptarDato($cadena){
	$cadena = base64_encode($cadena);
return $cadena;
}

function DesencriptarDato($cadena){
	$cadena = base64_decode($cadena);
return $cadena;
}

//****************************************
?>