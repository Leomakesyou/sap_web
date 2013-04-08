<?php

// require_once('conexion/conf.php');
// include $clase_BD; 
// include $gloInclude . "/adodb.inc.php"; 
 
//$conexionMysql = new ConectarMysql($gloDbDriver, $gloDbHost, $gloDb, $gloDbUser, $gloDbPassword);
			
/*function validate_user($username,$password,$identity){
  global $mydatabase; 
  //AND claveusuario='".filter_sql(md5($password))."' 
  $sql = "SELECT * from usuarios WHERE codusuario='".filter_sql($username)."' AND claveusuario='".filter_sql($password)."' ";
    
  			$qry1 = $conexionMysql->db->Execute($sql);
			$resultset_1 = $conexionMysql->db->Execute($sql);
		
	if($row_2=$resultset_2->FetchNextObj())
	{
		return true;}
	else
	{
	return false;}	
  
  /*$data = $mydatabase->query($sqlquery);
  if($data->numrows() != 0){
    $sqlquery = "UPDATE livehelp_users 
              SET 
                authenticated='Y' 
              WHERE sessionid='" . $identity['SESSIONID'] . "'";
    $mydatabase->query($sqlquery);

    return true;
  }
  return false;*/  
//}

$UNTRUSTED = parse_incoming($addslashes);

function parse_incoming($addslashes=false){
   global $_REQUEST;

   if($addslashes){
      return my_addslashes($_REQUEST);}               
   else {
      return my_stripslashes($_REQUEST);}     
}

function my_addslashes($what){
  
  if(is_array($what)){
     while (list($key, $val) = each($what)) {
       $what[$key] = my_addslashes($val);
     }
     return $what;
  } else {   	
   if (!(get_magic_quotes_gpc()))
    return addslashes($what);
   else
    return $what;
  }
}

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ 

function my_stripslashes($what){
	if(is_array($what)){
     while (list($key, $val) = each($what)) {
       $what[$key] = my_stripslashes($val);
     }
     return $what;
  } else {    
    if (!(get_magic_quotes_gpc())) 
       return $what;
    else
       return stripslashes($what);
  }
}
//-----------------------------------------------------------

//--------------------------------------------------------------
function filter_sql($what,$addslashes=true,$numeric=false,$maxsize=0){	 
	 
	 if($addslashes)
	   $what = addslashes($what);
	 else
	   $what = addslashes(stripslashes($what));
	   
	 if($numeric)
	   $what = intval($what);
	   
	 if($maxsize!=0)
	   $what = substr($what,0,$maxsize);
   
	 $what = str_replace("`","",$what);
	 
   // un-comment the following lines for compatability with Microsoft SQL server:
   // may cause problems with txt-db-api if uncommented...
	  //$what = str_replace("\'", "''", $what);
	  //$what = str_replace("\"", "\"\"", $what);
	 
	 return $what;	   
}
//--------------------------------------------

?>
