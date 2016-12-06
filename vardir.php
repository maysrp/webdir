<?php 
	/**
	* 
	*/
	class dir{
		public $dir;
		public $file;
		public $dirdir;
		public $notex;
		public $notdir;
		function __construct(){
			$this->notex=array("php","js","tgz");//不允许显示的后缀名文件
			$this->notdir=array("a");//不允许显示的文件夹
			if ($_GET['dir']) {
				$tom=trim($_GET['dir']);
				$tam=str_replace("..", ".", $tom);
				$this->dir="./".$tam;
			}else{
				$this->dir=".";
			}
		}
		function open_dir(){
			if(is_dir($this->dir)){
				if($dh=opendir($this->dir)){
					while(($file=readdir($dh))!==false){
						$this->jugg($file);
					}
					sort($this->file);
					sort($this->dirdir);
					closedir($dh);
				}
			}else{
				echo "error";
			}
		}
		function jugg($jugg){
			if($jugg!="."&&$jugg!=".."){
				if (is_dir($this->dir."/".$jugg)) {
					if(!in_array(strtolower($this->filename($jugg)), $this->notdir)){
						$this->dirdir[]=$this->dir."/".$jugg;
					}	
				}else{
					$ex=array_pop(explode(".", $jugg));
					if(!in_array(strtolower($ex), $this->notex)){
						$this->file[]=$this->dir."/".$jugg;
					}
				}
			}
		}
		function dirurl($dir){
			$urf=substr($dir,2 );
			return "?dir=".$urf;
		}
		function fileurl($file){
			$ex=array_pop(explode(".", $file));

		
		}
		function other($file){


		}
		function img($img){

		}
		function pdf($pdf){

		}
		function video($video){

		}
		function torrent($torrent){

		}
		function filename($file){
			return array_pop(explode("/", $file));
		}
		function size($file){
			$fz=filesize($file);
			if ($fz>(1024*1024*1024)) {
				return sprintf("%.2f",$fz/(1024*1024*1024))."GB";
			}elseif ($fz>(1024*1024)) {
				return sprintf("%.2f",$fz/(1024*1024))."MB";
			}elseif($fz>1024){
				return sprintf("%.2f",$fz/1024)."KB";
			}else{
				return $fz."B";
			}
		}
		function mtime($file){
			return date("Y-m-d H:i:s",filemtime($file));
		}
		function atime($file){
			return date("Y-m-d H:i:s",fileatime($file));
		}
		function ctime($file){
			return date("Y-m-d H:i:s",filectime($file));
			
		}
		function icon($file){
			$ex=strtolower(array_pop(explode(".", $file)));
			switch ($ex) {
				case 'png':
				case 'jpg':
				case 'gif':
				case 'bmp':
				case 'jpeg':
					return "glyphicon glyphicon-picture";
					break;
				case 'torrent':
					return "glyphicon glyphicon-magnet";
					break;
				case 'mp3':
					return "glyphicon glyphicon-music";
					break;
				case 'mp4':
				case 'ogg':
				case 'webm':
					return "glyphicon glyphicon-film";
					break;
				case 'xls':
				case 'xlsx':
				case 'doc':
				case 'docx':
				case 'ppt':
				case 'pptx':
					return "glyphicon glyphicon-pencil";
					break;
				case 'pdf':
					return "glyphicon glyphicon-book";
					break;
				default:
					return "glyphicon glyphicon-stop";
					break;
			}
		}
	}
	
$x=new dir();
$x->open_dir();

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
	<style type="text/css">
		.container{
			margin-top: 100px;
		}

	</style>
</head>
<body>
	<div class="container">
		<table class="table table-striped ">
			<tr>
				<th>文件名</th>
				<th></th>
				<th>大小</th>
				<th>时间</th>
			</tr>
<?php
	foreach ($x->dirdir as $key => $value) {
		//if(($key!="0")||($key!="1")){
		echo "<tr>";
			echo "<td><a href=\"".$x->dirurl($value)."\"><span class=\"glyphicon glyphicon-list\"> ".$x->filename($value)."</span></a></td>";
			echo "<td></td>";
			echo "<td>目录</td>";
			echo "<td>".$x->mtime($value)."</td>";
		echo "</tr>";
		//}
	}
	foreach ($x->file as $key => $value) {
		echo "<tr>";
			echo "<td><span class=\"".$x->icon($value)."\"> ".$x->filename($value)."</span></td>";
			echo "<td></td>";
			echo "<td>".$x->size($value)."</td>";
			echo "<td>".$x->mtime($value)."</td>";
		echo "</tr>";
	}



?>


		</table>
	</div>
</body>
</html>