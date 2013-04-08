<?php

//Variables utilizadas en todo el programa
//referencias

$gloRutaPublica= "http://" . $_SERVER[HTTP_HOST] . "/consultas";
$gloRutaAdmin= $gloRutaPublica . "/admon_general";
$gloRutaAplicacion= $gloRutaPublica . "/extranet";
$gloRutaErrorAdmin= $gloRutaAdmin . "/error.php";
$gloRutaErrorAplicacion= $gloRutaAplicacion . "/error.php";
$gloRutaVentanaAplicacion= $gloRutaAplicacion . "/abre_ventana.php";
$gloRutaAyudaAplicacion= $gloRutaAplicacion . "/ayuda/";
$gloRutaSecureImage = $gloRutaPublica . "/includes/securimage";

$gloPathPublica= $_SERVER[DOCUMENT_ROOT] . "/consultas";
$gloPathAdmin= $gloPathPublica . "/admon_general";
$gloPathAplicacion= $gloPathPublica . "/extranet";
$gloTamanoArchivos= "50000000";

$gloInclude= $gloPathPublica . "/includes";
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

$gloIdiomaAplicacion= "es";

$gloAdodb= $gloInclude . "/adodb";
$clase_BD= $gloInclude . "/dbm.php";
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
$gloDb= "serviefectivo";
$gloDbUser= "root";
$gloDbPassword = "misato28";

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
?>