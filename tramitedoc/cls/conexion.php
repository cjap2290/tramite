<?
class Conexion{
var $link = 0;


var $host ="localhost";
//var $user ="areaspro_sistemas";
var $user ="root";
var $psw  ="1234";
//var $psw  ="AreaProteg2007";
var $db   ="bd_std_sernanp";



/*var $user ="root";
var $psw  ="admin";*/


function Conexion($dbs=""){		
	$this->link=mysql_connect($this->host,$this->user,$this->psw) or die(mysql_error() ."error al conectarse al servidor");		
	if($dbs==""){			
		mysql_select_db($this->db,$this->link);		
	}else{
			
		mysql_select_db($dbs,$this->link);		
	}				
		return $this->link;	
	}
}
?>


