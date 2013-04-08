<?php
function LlenarPaises()
{
	global $oConn, $sql, $rs;
	
	$sql = "Select * From paises";
	$rs->Open($sql,$oConn);
	while(!$rs->EOF())
	{ 
		$id = $rs->Fields("codpais");
		$descripcion = $rs->Fields("nompais");
		echo "<option value=\"$id\">$descripcion</option>";
		$rs->moveNext();
	}
}


function LlenarAreas()
{
	global $oConn, $sql, $rs;
	
	$sql = "Select distinct(J0.codarea), J0.* From areas as J0";
	$sql = $sql . " INNER JOIN usuarios as J1 ON J0.codarea = J1.codarea";
	$sql = $sql . " order by J0.desarea";
	$rs->Open($sql,$oConn);
	while(!$rs->EOF())
	{ 
		$id = $rs->Fields("codarea");
		$descripcion = $rs->Fields("desarea");
		echo "<option value=\"$id\">$id.$descripcion</option>";
		$rs->moveNext();
	}
}

function LlenarAreasCia($cia)
{
	global $oConn, $sql, $rs;
	
	if ($cia == 99)
	{
		$sql = "Select distinct(J0.codarea), J0.* From areas as J0";
		$sql = $sql . " INNER JOIN usuarios as J1 ON J0.codarea = J1.codarea";
//		$sql = $sql . " WHERE J0.codcia = '$cia'";
		$sql = $sql . " order by J0.desarea";
		$rs->Open($sql,$oConn);
	}
	
	else
	{
		$sql = "Select distinct(J0.codarea), J0.* From areas as J0";
		$sql = $sql . " INNER JOIN usuarios as J1 ON J0.codarea = J1.codarea";
		$sql = $sql . " WHERE J0.codcia = '$cia'";
		$sql = $sql . " order by J0.desarea";
		$rs->Open($sql,$oConn);
	}


	while(!$rs->EOF())
	{ 
		$id = $rs->Fields("codarea");
		$descripcion = $rs->Fields("desarea");
		$descia = $rs->Fields("codcia");
		echo "<option value=\"$id\">$id.$descripcion</option>";
		$rs->moveNext();
	}
}

function LlenarAreas1()
{
	global $oConn, $sql, $rs;
	
	$sql = "Select distinct(J0.codarea),J0.* From areas as J0";
	$sql = $sql . " INNER JOIN cargos as J1 ON J0.codarea = J1.codarea";
	$sql = $sql . " order by J0.desarea";
	$rs->Open($sql,$oConn);
	while(!$rs->EOF())
	{ 
		$id = $rs->Fields("codarea");
		$descripcion = $rs->Fields("desarea");
		echo "<option value=\"$id\">$id.$descripcion</option>";
		$rs->moveNext();
	}
}

function LlenarGestion($cia, $pqr)
{
	global $oConn, $sql, $rs;
	
	$sql = "Select distinct(J0.codtipges), J0.*, J1.codcia, J1.codtippqr From tipos_gestion as J0";
	$sql = $sql . " INNER JOIN tipificacionxgestion as J1 ON J0.codtipges = J1.codtipges and J1.codcia = '$cia' and J1.activo = 'Y'";
	$sql = $sql . " WHERE J1.codcia = '$cia'";
	$sql = $sql . " AND J1.codtippqr = '$pqr'";
	$sql = $sql . " AND J0.activo = 'Y'";
	$sql = $sql . " order by J0.destipges";
	$rs->Open($sql,$oConn);
	while(!$rs->EOF())
	{ 
		$id = $rs->Fields("codcia")."-".$rs->Fields("codtipges")."-".$rs->Fields("codtippqr");
		$ges = $rs->Fields("codtipges");
		$descripcion = $rs->Fields("destipges");
		echo "<option value=\"$id\">$ges.$descripcion</option>";
		$rs->moveNext();
	}
}

function LlenarCompania()
{
	global $oConn, $sql, $rs;
	
	$sql = "Select distinct(J0.codcia), J0.nomcia From companias as J0";
//	$sql = $sql . " INNER JOIN tipificacionxgestion as J1 ON J0.codtipges = J1.codtipges";
//	$sql = $sql . " WHERE J1.codcia = '$cia'";
//	$sql = $sql . " AND J1.codtippqr = '$pqr'";
	$sql = $sql . " order by J0.codcia";
	$rs->Open($sql,$oConn);
	while(!$rs->EOF())
	{ 
		$id = $rs->Fields("codcia");
		//$ges = $rs->Fields("codtipges");
		$descripcion = $rs->Fields("nomcia");
		echo "<option value=\"$id\">$descripcion</option>";
		$rs->moveNext();
	}
}

?>