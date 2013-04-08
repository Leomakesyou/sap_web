<?php
function createExcel($filename, $arrydata) {
$gloPathPublica = $_SERVER[DOCUMENT_ROOT] . "/consultas";
//	$excelfile = "xlsfile://".$filename; 
	$excelfile = "xlsfile://".$filename; 
	$excelfile = $gloPathPublica ."/informes/".$filename; 

	//$excelfile = "xlsfile:". $gloPathPublica ."/informes/".$filename; 	
	//$excelfile = "xlsfile:".$filename;  	
	//$excelfile = "informes/".$filename;
//	echo "".$excelfile;
	$fp = fopen($excelfile, "wb");  
	if (!is_resource($fp)) {  
		die("Error al crear $excelfile");  
	}  
	fwrite($fp, $arrydata);  
	fclose($fp);

    //echo "<br>Filename: ".$excelfile;
    sleep(10);
    $filezip = $excelfile;
    $filezip = str_replace(".xls", ".zip", $filezip);
	
	require($gloPathPublica .'/lib/pclzip.lib.php');
	
	if (file_exists($excelfile))
	{
		$zip = new PclZip($filezip);
		$zip->create($excelfile);
		sleep(30);	
		if (file_exists($filezip))
		{
			//$filelong = filesize($filezip);
			//echo "<br>Tamaño del archivo generado: ".$filelong;
			return $excelfile;
		}
		else{
			return 0;
		}
	}
	else{
		return 0;
	} // fin del id si el excel se creo




	//header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");  
	//header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");  
	//header ("Cache-Control: no-cache, must-revalidate");  
	//header ("Pragma: no-cache");  

/*	
	header ("Content-type: application/xls");	
	header ("Content-type: application/vnd.msexcel"); //x-msexcel  
	//Para IE
	 
	 header("Content-Description: File Transfer");
    // header('Content-disposition: attachment; filename='.basename($filename));
	// header("Content-disposition: attachment; filename=\"" . $filename . "\"");
	 header ("Content-Disposition: attachment; filename=$filename");
	//     header("Content-Type: application/pdf");
     //header("Content-Type: application/xls");	
     //header("Content-Transfer-Encoding: binary");
     //header('Content-Length: '. filesize($serve_file_path));
     //header ("Content-Disposition: force-download; filename=\"" . $filename . "\"" );	
	 header ("Expires: 0");  
	 header("Pragma: cache");
     header('Cache-Control: private');

	 //header("Pragma: public");
     //header('Cache-Control: max-age=0');
     //readfile($serve_file_path);
	//////////////////
*/
	//readfile($excelfile);  
	//echo $arrydata;
}
?>