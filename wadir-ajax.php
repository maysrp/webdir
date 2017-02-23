<?php 
	/**
	* 
	*/
	define("PASS", "admin");
	class Aria2{
    	protected $ch;
    	function __construct($server='http://127.0.0.1:6800/jsonrpc'){
        	$this->ch = curl_init($server);
        	curl_setopt_array($this->ch, [
            	CURLOPT_POST=>true,
            	CURLOPT_RETURNTRANSFER=>true,
            	CURLOPT_HEADER=>false
        	]);
    	}
    	function __destruct(){
        	curl_close($this->ch);
    	}
    	protected function req($data){
        	curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);        
        	return curl_exec($this->ch);
    	}
    	function __call($name, $arg){
        	$data = [
            	'jsonrpc'=>'2.0',
            	'id'=>'1',
            	'method'=>'aria2.'.$name,
            	'params'=>$arg
        	];
        	$data = json_encode($data);
        	$response = $this->req($data);
        	if($response===false) {
            	trigger_error(curl_error($this->ch));
        	}
        	return json_decode($response, 1);
    	}
	}
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
		function open_dir(){
			if(is_dir($this->dir)){
				if($dh=opendir($this->dir)){
					while(($file=readdir($dh))!==false){
						$this->jugg($file);
					}
					if(count($this->file)>=1){
						sort($this->file);
					}
					if(count($this->dirdir)>=1){
						sort($this->dirdir);
					}
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
			$file_array=explode("/", $file);
			return array_pop($file_array);
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
		function ex($file){
			$file_array=explode(".", $file);
			$ex_n=array_pop($file_array);
			$ex=strtolower($ex_n);
			return $ex;
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
				foreach ($dir_array as $key => $value) {
					$step=$step.$value."/";
					$url=$url."<a class=\"text-success\" href=\"?dir=".$step."\">/".$value."</a>";
				}
				return $url;
			}

		}
	}
	function size($fz){
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
	
session_start();
if (isset($_SESSION['user'])&&$_SESSION['user']==PASS) {
	$aria2 = new Aria2('http://127.0.0.1:6800/jsonrpc');
	if(isset($_GET['url'])){
		$dir=dirname(__FILE__);
		$url=$_GET['url'];
		$json=$aria2->addUri(array($url),array('dir'=>$dir,));
		echo json_encode($json);
		return;
	}
	if(isset($_GET['aria2'])){
		$active=$aria2->tellActive();
		$waiting=$aria2->tellWaiting(0,100);
		$info['active']=$active['result'];
		$info['waiting']=$waiting['result'];
		echo json_encode($info);
		return;
	}
	if(isset($_GET['pause'])){
		$info=$aria2->pause($_GET['pause']);
		echo json_encode($info);
		return;
	}
	if(isset($_GET['unpause'])){
		$info=$aria2->unpause($_GET['unpause']);
		echo json_encode($info);
		return;
	}
	if(isset($_GET['remove'])){
		$info=$aria2->remove($_GET['remove']);
		echo json_encode($info);
		return;
	}	
}


$x=new dir();
$x->open_dir();
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
	<script src="https://cdn.bootcss.com/messenger/1.5.0/js/messenger.min.js"></script>
	<link href="https://cdn.bootcss.com/messenger/1.5.0/css/messenger.min.css" rel="stylesheet">
	<link href="https://cdn.bootcss.com/messenger/1.5.0/css/messenger-theme-future.min.css" rel="stylesheet">
	<title>Webdir</title>
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
	if (isset($_POST['password'])&&$_POST['password']==PASS) {
		$_SESSION['user']=PASS;
	}
	if(isset($_SESSION['user'])&&$_SESSION['user']==PASS){
	}else{
?>
	<div  class="container">
		<div class="row " style="margin:20px ">
			<div class="row">
					<center><h2 class="text-primary">Webdir</h2></center>	
			</div>
			<form class="form" action="" method="post">
				<div class="row">
					<div class="input-group col-md-4 col-md-offset-4">
						<input type="password" name="password" class="form-control">
						<span class="input-group-btn">
							<input type="submit" name="sub" class="btn btn-success" value="登入">
						</span>
					</div>
				</div>
			</form>
		</div>
		
	</div>
<?php
	return;
	}
	$free=@disk_free_space(".");//disk 
	$total=@disk_total_space(".");
	$used=$total-$free;
	$usp=round($used/$total*100,2);//used %
?>
	<div class="container">
		<div class="row">
			<div class="col-md-1" style="margin-bottom:10px; ">
				<a  href="
<?php echo $_SERVER['HTTP_REFERER'] ?>
				"
				><h2 class="btn btn-primary"><span class="glyphicon glyphicon-chevron-left " id="back"></span></h2></a>
			</div>
			<div class="col-md-6">
				<h3>
<?php 
echo $x->pre() ;
?>
				</h3>
			</div>
			<div class="col-md-5">
				<div class="input-group" style="margin-top:10px ">
					<input type="text" name="magnet" id="magnet" class="form-control">
					<span class="input-group-btn">
						<span class="btn btn-success" id="btn-magnet">Magnet</span>
						<span class="btn btn-info aria2">下载列表</span>
					</span>
				</div>
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
				echo "<td><span class=\" click_onload ".$x->icon($value)." fileshow\" type=\"".$x->type($value)."\" value=\"".$x->value($value)."\"> ".$x->filename($value)."</span></td>";
				echo "<td>".$x->size($value)."</td>";
				echo "<td>".$x->mtime($value)."</td>";
				echo "<td>".$x->download($value)."</td>";
			echo "</tr>";
		}
	}
?>
		</table>
			<div class="row">
				<span class="col-md-2">Powered by <a href="https://github.com/maysrp/webdir">webdir</a></span>
				<div class="col-md-6 ">
					<div class="row">
						<span class="col-md-2 text-right"><b>磁盘信息:</b></span>
						<div class="col-md-10">
							<div class="progress">
								<div class="progress-bar 
								<?php
									if ($usp<30) {
										echo "progress-bar-success";
									}elseif($usp<60){
										echo "progress-bar-primary";
									}elseif($usp<90){
										echo "progress-bar-warning";
									}else{
										echo "progress-bar-danger";
									}

								?>" role="progressbar" aria-valuenow="<?php echo $usp ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $usp ?>%;">
							<?php echo $usp ?>%
								</div>
							</div>
						</div>
					</div>
				</div>
				<span class="col-md-4">
					<b><span class="text-danger">USED:<?php echo size($used)?></span> / <span class="text-success">FREE:<?php echo size($free)?></span> / <span class="text-primary">TOTAL:<?php echo size($total)?></span></b>
				</span>
			</div>

	</div>
	<div>
		<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal">
  			<div class="modal-dialog modal-lg">
    			 <div class="modal-content ">
    			  	<div class="modal-header">
        				<h4 class="modal-title title_m" id="myModalLabel"></h4>
      				</div>
      				<div class="modal-body text-center body_m">
      				</div>
      				<div class="modal-footer">
        				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      				</div>
    			 </div>
  			</div>
		</div>
	</div>
<div class="modal fade aria2_control" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">Aria2后台下载进程</div>
      <div class="modal-body">
		<div class="row" style="margin: 10px;">		
			<div class="input-group">
				<input type="text" name="magnet_uri" class="magnet_uri form-control " placeholder="MAGNET  的地址 例如:magnet:?xt=urn:btih:2fffb617d9acd3b1d28f697e2b34da659e7846f1">		
				<div class="input-group-addon magnet_up">
					<span class="glyphicon glyphicon-ok text-success "></span>
				</div>		
			</div>
		</div>
		<div class="row aria2_active" style="margin: 10px;">
			<H3>进行中的任务  <span onClick="aria2_re()" class="glyphicon glyphicon-refresh text-success"></span></H3>
			<table class="table table_active">
				<tr>
					<th>任务名</th>
					<th title="title">已经完成/总量</th>
					<th>速度</th>
					<th>操作</th>
				</tr>
			</table>
		</div>
		<div class="row aria2_waiting" style="margin: 10px;">
			<h3>等待中的任务</h3>
			<table class="table table_waiting">
				<tr>
					<th>任务名</th>
					<th title="title">已经完成/总量</th>
					<th>速度</th>
					<th>操作</th>
				</tr>
			</table>
		</div>      	
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
				$(".title_m").html(name);
				$(".body_m").html("<a href=\""+value+"\"><img style=\"max-width:80%;\" src=\""+value+"\"></a>");
				$("#modal").modal();
			break;
			case "video":
				$(".title_m").html(name);
				$(".body_m").html("<video width=\"80%\" autoplay controls id=\"play\" src=\""+value+"\"></video>");
				$("#modal").modal();
			break;
			case "mp3":
				$(".title_m").html(name);
				$(".body_m").html("<audio src=\""+value+"\" id=\"play\" autoplay controls>您的浏览器不支持 audio 标签。</audio>");
				$("#modal").modal();
			break;
			case "text":
				$(".title_m").html(name);
				$(".body_m").html("<iframe width=\"80%\" height=\"600px\" src=\""+value+"\">");
				$("#modal").modal();
			break;
			case "pdf":
				$(".title_m").html(name);
				$(".body_m").html("<iframe width=\"80%\" height=\"800px\" src=\""+value+"\">");
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
	$("#btn-magnet").click(function(){
		var magnet=$("#magnet").val();
		$.get("?url="+magnet,function(data){
			var re=eval("("+data+")");
			if(typeof(mx) != 'undefined' ){
				mx.hide();
			}
			if(re.result){
				mx=Messenger().post("你已经添加一个离线任务！");
			}else{
				mx=Messenger().post("添加失败:"+re.error.message);
			}
		});
		$("#magnet").val("");
	})
	$(".aria2").click(function(){
		$(".aria2_control").modal('show');
			aria2_re();
			a_r=setInterval('aria2_re()',30000);//定时刷新
	})
	function aria2_re(){
		if($(".aria2_load")){
			$(".aria2_load").remove();
		}
		aria2_achieve();
	}
	function aria2_achieve(){
		$.ajax({
			url:"?aria2=1",
			success:function(data){
				var re=eval("("+data+")");
				table(re.active,"active");
				table(re.waiting,"waiting");
			}
		})
	}
	function table(data,type){
		for (x in data){
			var tr=$("<tr class=\"aria2_load\"></tr>");
			var td_name=$("<td width=\"60%\" style=\"word-wrap:break-word;word-break:break-all;\">"+data[x].bittorrent.info.name+"</td>");
			var td_total=$("<td title=\""+Math.floor(data[x].completedLength/data[x].totalLength*10000)/100+"%\">"+size_show(data[x].completedLength)+"/"+size_show(data[x].totalLength)+"</td>");
			var td_speed=$("<td>"+size_show(data[x].downloadSpeed)+"/S</td>");
			if(type=="active"){
				var td_cz=$("<td ><span  class=\"glyphicon glyphicon-pause text-primary\" onClick=\"stop(\'"+data[x].gid+"\')\" ></span> <span class=\"glyphicon glyphicon-trash text-danger\" onClick=\"del(\'"+data[x].gid+"\')\" ></span></td>");
			}else{
				var td_cz=$("<td ><span  class=\"glyphicon glyphicon-ok text-success\" onClick=\"active(\'"+data[x].gid+"\')\" ></span> <span class=\"glyphicon glyphicon-trash text-danger\" onClick=\"del(\'"+data[x].gid+"\')\" ></span></td>");
			}
			td_name.appendTo(tr);
			td_total.appendTo(tr);
			td_speed.appendTo(tr);
			td_cz.appendTo(tr);
			tr.appendTo(".table_"+type);
		}
	}
	function active(gid){
		$.ajax({
			url:"?unpause="+gid,
			success:function(data){
				var re=eval("("+data+")");
				if(typeof(mx) != 'undefined' ){
					mx.hide();
				}
				if(re.result){
					mx=Messenger().post("你已经启动一个离线任务！");
					aria2_re();
				}else{
					mx=Messenger().post("启动失败:"+re.error.message);
				}
			}
		})
	}
	function stop(gid){
		$.ajax({
			url:"?pause="+gid,
			success:function(data){
				var re=eval("("+data+")");
				if(typeof(mx) != 'undefined' ){
					mx.hide();
				}
				if(re.result){
					mx=Messenger().post("你已经停止一个离线任务！");
					aria2_re();
				}else{
					mx=Messenger().post("停止失败:"+re.error.message);
				}
			}
		})
	}
	function del(gid){
		$.ajax({
			url:"?remove="+gid,
			success:function(data){
				var re=eval("("+data+")");
				if(typeof(mx) != 'undefined' ){
					mx.hide();
				}
				if(re.result){
					mx=Messenger().post("你已经删除一个离线任务！");
					aria2_re();
				}else{
					mx=Messenger().post("删除失败:"+re.error.message);
				}
			}
		})
	}
	function size_show(file_size){
		if(file_size>Math.pow(2,30)){
			var size=Math.floor(file_size/Math.pow(2,30)*100)/100;
			return size+"GB";
		}else if(file_size>Math.pow(2,20)){
			 var size=Math.floor(file_size/Math.pow(2,20)*100)/100;
			return size+"MB";
		}else if(file_size>Math.pow(2,10)){
			var size=Math.floor(file_size/Math.pow(2,10)*100)/100;
			return size+"KB";
		}else{
			return file_size+"B";
		}
	}
	$(".magnet_up").click(function(){
		var magnet=$(".magnet_uri").val();
		if(magnet){
			$.ajax({
				url:"?url="+magnet,
				success:function(data){
					var re=eval("("+data+")");
					if(typeof(mx) != 'undefined' ){
						mx.hide();
					}
					if(re.result){
						mx=Messenger().post("你已经添加一个离线任务！");
					}else{
						mx=Messenger().post("添加失败:"+re.error.message);
					}
					$(".magnet_uri").val("");
				}
			})
		}
	})
	

</script>
</body>
</html>
