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
			$this->notdir=array("a","phpmyadmin");//不允许显示的文件夹
			if (!empty($_GET['dir'])) {
				foreach ($this->notdir as $key => $value) {
					if(strtolower($_GET['dir'])==$value){
						$_GET['dir']=".";
					}
				}
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
                    $arrJugg = explode(".", $jugg);
					$ex=array_pop($arrJugg);
					//如果报错可将前一行代码写成以下形式
					//$ar=explode(".", $jugg);
					//$ex=array_pop($ar);
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
		function type($file){
            $arrFile = explode(".", $file);
			$ex=strtolower(array_pop($arrFile));
			switch ($ex) {
				case 'png':
				case 'jpg':
				case 'gif':
				case 'bmp':
				case 'jpeg':
					return "img";
					break;
				case 'torrent':
					return "torrent";
					break;
				case 'mp3':
					return "mp3";
					break;
				case 'mp4':
				case 'ogg':
				case 'webm':
					return "video";
					break;
				case 'xls':
				case 'xlsx':
				case 'doc':
				case 'docx':
				case 'ppt':
				case 'pptx':
					return "other";
					break;
				case 'pdf':
					return "pdf";
					break;
				case 'txt':
				case 'json':
				case 'xml':
				case 'html':
				case 'md':
					return "text";
					break;
				default:
					return "other";
					break;
			}
		}
		function download($file){
			return "<a href=\"".$file."\" ><span class=\"glyphicon glyphicon-download-alt\"></span></a>";
		}
		function other($file){


		}
		function img($img){

		}
		function pdf($pdf){

		}
		function video($video){

		}
		function mp3($mp3){

		}
		function torrent($torrent){

		}
		function filename($file){
            $arrFiles = explode("/", $file);
			return array_pop($arrFiles);
		}
		function text($file){

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
            $arrFile = explode(".", $file);
			$ex=strtolower(array_pop($arrFile));
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
				case 'txt':
				case 'md':
					return "glyphicon glyphicon-file";
					break;
				default:
					return "glyphicon glyphicon-stop";
					break;
			}
		}
		function pre(){
			$dir_array=explode("/", $this->dir);
			$num=count($dir_array);
			if($num>=2){
				@array_shift($dir_array);
				$url="<a class=\"text-success\" href=?>/.</a>";
				foreach ($dir_array as $key => $value) {
					$step=$step.$value."/";
					$url=$url."<a class=\"text-success\" href=\"?dir=".$step."\">/".$value."</a>";
				}
				return $url;
			}

		}
	}
	
$x=new dir();
$x->open_dir();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
	<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<title>Vardir</title>
	<style type="text/css">
	body{
			background-color:#F1F1FA;
		}
		.container{
			margin-top: 100px;
			border-radius:10px;
			background-color:#FFFFFF;


		}


	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-1">
				<a href="
<?php echo $_SERVER['HTTP_REFERER'] ?>
				"
				><h2 class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left " id="back"></span></h2></a>
			</div>
			<div class="col-md-10">
				<h1>
<?php		
	echo $x->pre();
?>				</h1>
			</div>
		</div>
		<table class="table table-striped ">
			<tr>
				<th>文件名</th>
				<th>大小</th>
				<th>时间</th>
				<th>下载</th>
			</tr>
<?php
	foreach ($x->dirdir as $key => $value) {
		echo "<tr>";
			echo "<td><a href=\"".$x->dirurl($value)."\"><span class=\"glyphicon glyphicon-list\"> ".$x->filename($value)."</span></a></td>";
				echo "<td>目录</td>";
				echo "<td>".$x->mtime($value)."</td>";
				echo "<td></td>";
		echo "</tr>";
	}
	foreach ($x->file as $key => $value) {
		echo "<tr>";
			echo "<td><span class=\" click_onload ".$x->icon($value)." fileshow\" type=\"".$x->type($value)."\" value=\"".rawurlencode($value)."\"> ".$x->filename($value)."</span></td>";
			echo "<td>".$x->size($value)."</td>";
			echo "<td>".$x->mtime($value)."</td>";
			echo "<td>".$x->download($value)."</td>";
		echo "</tr>";
	}



?>


		</table>
			<span>Powered by <a href="https://git.oschina.net/supercell/webdir">webdir</a></span>
	</div>

	<div>
		<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal">
  			<div class="modal-dialog modal-lg">
    			 <div class="modal-content ">
    			  	<div class="modal-header">
        				<h4 class="modal-title" id="myModalLabel"></h4>
      				</div>
      				<div class="modal-body text-center">
      				</div>
      				<div class="modal-footer">
        				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      				</div>
    			 </div>
  			</div>
		</div>
	</div>
<script type="text/javascript">
	$(".fileshow").click(function(){
		var type=$(this).attr("type");
		var name=$(this).text();
		var value=$(this).attr("value");
		switch(type){
			case "img":
				$(".modal-title").html("");
				$(".modal-title").html(name);
				$(".modal-body").html("");
				$(".modal-body").html("<a href=\""+value+"\"><img style=\"max-width:600px;\" src=\""+value+"\"></a>");
				$("#modal").modal();
			break;
			case "video":
				$(".modal-title").html("");
				$(".modal-title").html(name);
				$(".modal-body").html("");
				$(".modal-body").html("<video width=\"800px\" autoplay controls id=\"play\" src=\""+value+"\"></video>");
				$("#modal").modal();
			break;
			case "mp3":
				$(".modal-title").html("");
				$(".modal-title").html(name);
				$(".modal-body").html("");
				$(".modal-body").html("<audio src=\""+value+"\" id=\"play\" autoplay controls>您的浏览器不支持 audio 标签。</audio>");
				$("#modal").modal();
			break;
			case "text":
				$(".modal-title").html("");
				$(".modal-title").html(name);
				$(".modal-body").html("");
				$(".modal-body").html("<iframe width=\"800px\" height=\"600px\" src="+value+">");
				$("#modal").modal();
			break;
			case "pdf":
				$(".modal-title").html("");
				$(".modal-title").html(name);
				$(".modal-body").html("");
				$(".modal-body").html("<iframe width=\"800px\" height=\"800px\" src="+value+">");
				$("#modal").modal();
			default:
		}
	})
	$('#modal').on('hidden.bs.modal', function (e) {
  		var play=$("#play")[0];
  			play.pause();
	})
	$(".click_onload").mouseover(function(){
		$(this).addClass("text-primary");
	})
	$(".click_onload").mouseout(function(){
		$(this).removeClass("text-primary");
	})	


</script>
</body>
</html>
