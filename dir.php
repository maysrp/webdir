<!DOCTYPE>
<head>
    <META CHARSET="utf-8"/>
	<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
	<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<table class="table table-striped">
			<tr>
				<th>文件名</th>
				<th>大小</th>
			</tr>
<?php

	$dir=$_GET['dir']?$_GET['dir']:".";
	$jugg=dirpath($dir);
	if($jugg){
		echo $jugg;
	}
	function dirpath($dir){
		$host=$_SERVER['HTTP_HOST'];
		$primary=strstr($_SERVER['SCRIPT_NAME'],basename(__FILE__),TRUE);
		$odir="./".$dir;
		$dir_array=scandir($odir);
		$str="";
		foreach ($dir_array as $key => $value) {
			$str=$str."<tr>";
			$path=$odir."/".$value;
			if(is_dir($path)){
				$str=$str."<td><span class=\"glyphicon glyphicon-folder-close\"></span><a href=\"?dir=".$dir."/".$value."\"> ".$value."</a></td><td>目录</td>";
			}else{
				$str=$str."<td>";
				$ex=strtolower(substr(strrchr($value, '.'), 1));
				switch ($ex) {
					case 'jpg':
					case 'jpeg':
					case 'gif':
					case 'ico':
					case 'png':
					case 'bmp':
						$str=$str."<span class=\"glyphicon glyphicon-picture\"></span>";
						break;
					case 'mp4':
					case 'avi':
					case 'mkv':
					case 'ogg':
					case 'webm':
					case 'rmvb':
					case 'wmv':
					case 'rm':
						$str=$str."<span class=\"glyphicon glyphicon-film\"></span>";
						break;
					case 'zip':
					case 'rar':
					case '7z':
					case 'gz':
					case 'tgz':
						$str=$str."<span class=\"glyphicon glyphicon-tasks\"></span>";
						break;
					case 'pdf':
					case 'doc';
					case 'xls';
					case 'txt';
					case 'docx';
					case 'ppt';
					case 'pptx';
						$str=$str."<span class=\"glyphicon glyphicon-book\"></span>";
						break;
					case 'php':
					case 'py':
					case 'c':
					case 'jar':
					case 'js':
					case 'html':
					case 'ini':
					case 'json':
						$str=$str."<span class=\"glyphicon glyphicon-file\"></span>";
						break;
					case 'exe':
					case 'bat':
					case 'dll':
						$str=$str."<span class=\"glyphicon glyphicon-th-large\"></span>";
						break;
					case 'mp3':
					case 'wav':
					case 'flv':
						$str=$str."<span class=\"glyphicon glyphicon-music\"></span>";
						break;
					case 'torrent':
						$str=$str."<span class=\"glyphicon glyphicon-magnet\"></span>";
						break;
					default:
						$str=$str."<span class=\"glyphicon glyphicon-stop\"></span>";
						break;
				}
				$str=$str."<a href=\"".$dir."/".$value."\"> ".$value."</a></td>";
				$str=$str."<td>".filesize($path)."B</td>";
			}		
			$str=$str."</tr>";
		}
		chdir($odir);
		$or=strlen(dirname(__FILE__));
		$now=strlen(getcwd());
		if($or>$now){
			return false;
		}else{
			return $str;
		}

	}
?>
		</table>
		<div>
		Powered by <a href="http://git.oschina.net/supercell/webdir/">Webdir</a>
		</div>
	</div>	
	
</body>



