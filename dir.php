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
	dirpath($dir);
	function dirpath($dir){
		$host=$_SERVER['HTTP_HOST'];
		$primary=strstr($_SERVER['SCRIPT_NAME'],basename(__FILE__),TRUE);
		$odir="./".$dir;
		$dir_array=scandir($odir);
		foreach ($dir_array as $key => $value) {
			echo "<tr>";
			$path=$odir."/".$value;
			//$bm=mb_detect_encoding($value);
			//echo $bm;
			$value=iconv("GBK","UTF-8",$value);
			if(is_dir($path)){
				echo "<td><span class=\"glyphicon glyphicon-folder-close\"></span><a href=\"?dir=".$dir."/".$value."\"> ".$value."</a></td>";
				echo "<td>目录</td>";
			}else{
				echo "<td>";
				$ex=strtolower(substr(strrchr($value, '.'), 1));
				switch ($ex) {
					case 'jpg':
					case 'jpeg':
					case 'gif':
					case 'ico':
					case 'png':
					case 'bmp':
						echo "<span class=\"glyphicon glyphicon-picture\"></span>";
						break;
					case 'mp4':
					case 'avi':
					case 'mkv':
					case 'ogg':
					case 'webm':
					case 'rmvb':
					case 'wmv':
					case 'rm':
						echo "<span class=\"glyphicon glyphicon-film\"></span>";
						break;
					case 'zip':
					case 'rar':
					case '7z':
					case 'gz':
					case 'tgz':
						echo "<span class=\"glyphicon glyphicon-tasks\"></span>";
						break;
					case 'pdf':
					case 'doc';
					case 'xls';
					case 'txt';
					case 'docx';
					case 'ppt';
					case 'pptx';
						echo "<span class=\"glyphicon glyphicon-book\"></span>";
						break;
					case 'php':
					case 'py':
					case 'c':
					case 'jar':
					case 'js':
					case 'html':
					case 'ini':
					case 'json':
						echo "<span class=\"glyphicon glyphicon-file\"></span>";
						break;
					case 'exe':
					case 'bat':
					case 'dll':
						echo "<span class=\"glyphicon glyphicon-th-large\"></span>";
						break;
					case 'mp3':
					case 'wav':
					case 'flv':
						echo "<span class=\"glyphicon glyphicon-music\"></span>";
						break;
					case 'torrent':
						echo "<span class=\"glyphicon glyphicon-magnet\"></span>";
						break;
					default:
						echo "<span class=\"glyphicon glyphicon-stop\"></span>";
						break;
				}
				echo "<a href=\"".$dir."/".$value."\"> ".$value."</a></td>";
				echo  "<td>".filesize($path)."B</td>";
			}		
			echo "</tr>";
		}
	}
?>
		</table>
		<div>
		Powered by <a href="http://git.oschina.net/supercell/webdir/">Webdir</a>
		</div>
	</div>	
	
</body>



