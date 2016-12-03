<?php 
	session_start();
	$_SESSION[]=".";
	$_SESSION[]="..";
		$_SESSION[]="..";
			$_SESSION[]=".wdwd..";
	$ax[]=".";
	$ax[]="..";
	$ax[]="..";
	$ax[]="..";

	var_dump($ax);

var_dump($_SESSION['dir']);

	

	function dir_pre(){//返回前路径
		$swap="";
		foreach ($_SESSION['dir'] as $key => $value) {
			 $swap=$swap.$value."/";
		}
		return $swap;
	}
	function jugg($jugg){

	}

	function direct($dir){
		
	}
	function other($file){


	}
	function img($img){

	}
	function pdf($pdf){

	}
	function torrent($torrent){

	}

?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
		<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
		<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
		<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<head>
	<title>Vardir</title>
</head>
<body>

</body>
</html>