<?php 
	/**
	* 
	*/
	//define("PASS", "123");//若要设置密码请将define()前的斜线删去
	class dir{
		public $dir;
		public $file;
		public $dirdir;
		public $notex;
		public $notdir;
		function __construct(){
			$this->notex=array("php","js","tgz");//不允许显示的后缀名文件
			$this->notdir=array("a","phpmyadmin");//不允许显示的文件夹
			if (isset($_GET['dir'])) {
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
		function ex($string){
			$ar=explode(".", $string);
			$ex=array_pop($ar);
			return strtolower($ex);
		}
		function open_dir(){
			if(is_dir($this->dir)){
				if($dh=opendir($this->dir)){
					while(($file=readdir($dh))!==false){
						$this->jugg($file);
					}
					//sort($this->file);
					//sort($this->dirdir);
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
					$ex=$this->ex($jugg);
					if(!in_array($ex, $this->notex)){
						$this->file[]=$this->dir."/".$jugg;
					}
				}
			}
		}
		function dirurl($dir){
			$urf=substr($dir,2 );
			return "?dir=".rawurlencode($urf);
		}
		function value($value){
			$urf=substr($value,2 );
			return $urf;
		}
		function type($file){
			$ex=$this->ex($file);
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
		function md5($file){
			return md5_file($file);
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
			$ar=explode("/", $file);
			return array_pop($ar);
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
			$ex=$this->ex($file);
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
				$step="";
				foreach ($dir_array as $key => $value) {
					$step=$step.$value."/";
					$url=$url."<a class=\"text-success\" href=\"?dir=".$step."\">/".$value."</a>";
				}
				return $url;
			}

		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="renderer" content="webkit">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
	<script src="https://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
	<script src="https://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdn.bootcss.com/dplayer/1.1.2/DPlayer.min.js"></script>
	<title>Webdir-danmu</title>
	<style type="text/css">
		body{
			background-color:#F1F1FA;
		}
		.container{
			margin-top: 100px;
			border-radius:15px;
			background-color:#FFFFFF;


		}

	</style>
</head>
<body>
<?php
$time=time();
$server=$_SERVER['HTTP_HOST'];	
$token=base64_encode($_SERVER['REMOTE_ADDR'].":".$time.":".$server);
if(defined("PASS")){
	session_start();
	if ($_SESSION['user']==PASS) {
	}else{
		if($_POST['pass']==PASS){
			$_SESSION['user']=PASS;
		}else{
?>
	<div class="container">
		<form method="POST" action="">
			<div class="row">
				<h1 class="text-center text-success">Webdir</h1>
			</div>
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<div class="input-group">
						<input type="password" name="pass" class="form-control">
						<span class="input-group-btn">
							<input type="submit" name="sub" value="登入" class="btn btn-danger">
						</span>
					</div>				
				</div>
			</div>
		</form>
		<div class="row">
			<span style="margin: 15px;">Powered by <a href="https://github.com/maysrp/webdir">Webdir</a></span>
		</div>
	</div>

<?php
			return false;
		}
		
	}



}
$x=new dir();
$x->open_dir();

?>
	<div class="container">
		<div class="row">
			<div class="col-md-1">
				<a href="
<?php echo isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"" ?>				"
				><h2 class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left " id="back"></span></h2></a>
			</div>
			<div class="col-md-10">
				<h3>
<?php		
	echo $x->pre();
?>				</h3>
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
if(isset($x->dirdir)){
	foreach ($x->dirdir as $key => $value) {
		echo "<tr>";
			echo "<td><a href=\"".$x->dirurl($value)."\"><span class=\"glyphicon glyphicon-list\"> ".$x->filename($value)."</span></a></td>";
				echo "<td>目录</td>";
				echo "<td>".$x->mtime($value)."</td>";
				echo "<td></td>";
		echo "</tr>";
	}
}
if(isset($x->file)){
	foreach ($x->file as $key => $value) {
		echo "<tr>";
			echo "<td><span class=\" click_onload ".$x->icon($value)." fileshow\" type=\"".$x->type($value)."\" value=\"".$x->value($value)."\" md5=\"".$x->md5($value)."\"> ".$x->filename($value)."</span></td>";
			echo "<td>".$x->size($value)."</td>";
			echo "<td>".$x->mtime($value)."</td>";
			echo "<td>".$x->download($value)."</td>";
		echo "</tr>";
	}
}



?>


		</table>
			<span>Powered by <a href="https://github.com/maysrp/webdir">webdir</a></span>
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
		var md5=$(this).attr("md5");
		switch(type){
			case "img":
				$(".modal-title").html("");
				$(".modal-title").html(name);
				$(".modal-body").html("");
				$(".modal-body").html("<a href=\""+value+"\"><img style=\"max-width:80%;\" src=\""+value+"\"></a>");
				$("#modal").modal();
			break;
			case "video":
			case "mp3":
				$(".modal-title").html("");
				$(".modal-title").html(name);
				$(".modal-body").html("");
				$(".modal-body").html("<div id=\"player1\" class=\"dplayer\"></div>");
				//$(".modal-body").html("<video width=\"80%\" autoplay controls id=\"play\" src=\""+value+"\"></video>");
				$("#modal").modal();
				dp = new DPlayer({
    				element: document.getElementById('player1'),                       // Optional, player element
    				autoplay: false,                                                   // Optional, autoplay video, not supported by mobile browsers
    				theme: '#FADFA3',                                                  // Optional, theme color, default: #b7daff
    				loop: true,                                                        // Optional, loop play music, default: true
    				lang: 'zh',                                                        // Optional, language, `zh` for Chinese, `en` for English, default: Navigator language
    				screenshot: true,                                                  // Optional, enable screenshot function, default: false, NOTICE: if set it to true, video and video poster must enable Cross-Origin
    				hotkey: true,                                                      // Optional, binding hot key, including left right and Space, default: true
    				preload: 'auto',                                                   // Optional, the way to load music, can be 'none' 'metadata' 'auto', default: 'auto'
    				video: {                                                           // Required, video info
        				url: value,                                         // Required, video url
        				pic: 'a.jpg'                                          // Optional, music picture
    				},
    				danmaku: {                                                         // Optional, showing danmaku, ignore this option to hide danmaku
        				id: md5,                                        // Required, danmaku id, NOTICE: it must be unique, can not use these in your new player: `https://api.prprpr.me/dplayer/list`
        				api: 'http://dm.loli.mba:1024',                             // Required, danmaku api
        				token: '<?php echo $token ?>',                                            // Optional, danmaku token for api
        				maximum: 1000,                                                 // Optional, maximum quantity of danmaku IP base64
    				}
				});			
			break;
			case "text":
				$(".modal-title").html("");
				$(".modal-title").html(name);
				$(".modal-body").html("");
				$(".modal-body").html("<iframe width=\"80%\" height=\"600px\" src=\""+value+"\">");
				$("#modal").modal();
			break;
			case "pdf":
				$(".modal-title").html("");
				$(".modal-title").html(name);
				$(".modal-body").html("");
				$(".modal-body").html("<iframe width=\"80%\" height=\"800px\" src=\""+value+"\">");
				$("#modal").modal();
			default:
		}
	})
	$('#modal').on('hidden.bs.modal', function (e) {
  		if(window.dp){
  			dp.pause();
  		}
	})
	$(".click_onload").mouseover(function(){
		$(this).addClass("text-primary");
	})
	$(".click_onload").mouseout(function(){
		$(this).removeClass("text-primary");
	})	


</script>
<script type="text/javascript">
	
</script>
</body>
</html>
