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
<?php
	define("NAME","root");//用户名
	define("PASSWORD","a123456");//密码设置，非明文请自己添加
	session_start();
	if($_SESSION['user']){
		$dir=$_GET['dir']?$_GET['dir']:"";
		$dir=trim($dir);
		$jugg=dirpath($dir);
		if($jugg){
			//只能更目录上创建
			if($del=$_GET['del']){
				del($del);
			}
			if($mk=$_GET['mk']){
				mk_dir($mk);
			}
			if($_FILES['file']['name']){
				//$file_ex=strtolower(substr(strrchr($_FILES['name'], '.'), 1));//直接覆盖
				move_uploaded_file($_FILES['file']['tmp_name'],$_FILES['file']['name']);
				header("location:".$_SERVER['HTTP_REFERER']);
			}
?>
		<dir class="row">
			<form action="" method="post" enctype="multipart/form-data">
				<div class="col-md-4 col-md-offset-6">
					<input type="file" name="file" class="form-control">
				</div>
				<div class="col-md-1">
					<button class="btn btn-success">上传</button>
				</div>
				<span class="col-md-1">
					<span class="btn btn-info" data-toggle="modal" data-target=".bs-example-modal-sm">文件夹</span>
				</span>
			</form>
		</dir>
		<table class="table table-striped">
			<tr>
				<th>文件名</th><th>大小</th>
			</tr>
<?php	
	echo $jugg;
?>
		</table>
<?php
		}
	}else{//login	
		$name=$_POST['name'];
		$password=$_POST['password'];
		if($password==PASSWORD&&$name==NAME){
			$_SESSION['user']="root";
		}
?>
	<dir class="col-md-5 col-md-offset-3">
		<form method="post" action="">
			<div class="form-group">
				<label >用户名</label>
				<input type="text" name="name" class="form-control">
			</div>
			<div class="form-group">
				<label >密码 </label>
				<input type="password" name="password" class="form-control">
			</div>
			<div class="form-group">
				<button class="btn btn-primary">登入</button>
			</div>
		</form>
	</dir>
<?php		
	}	
?>
		<div class="col-md-5 col-md-offset-3">
		Powered by <a href="http://git.oschina.net/supercell/webdir/">Webdir</a>
		</div>
	</div>	
</body>
<?php
	function mk_dir($md){
		$re=mkdir($md);
		if($re){
			header("location:".$_SERVER['HTTP_REFERER']);
		}
	}
	function del($name){
		unlink($name);
		header("location:".$_SERVER['HTTP_REFERER']);
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
				$str=$str."<a href=\"./".$dir."/".$value."\"> ".$value."</a></td>";
				$str=$str."<td><a href=\"?del=./".$dir."/".$value."\"><span class=\"text-danger glyphicon glyphicon-remove\"></span></a> ".filesize($path)."B</td>";
			}		
			$str=$str."</tr>";
		}
		chdir($odir);
		$or=strlen(dirname(__FILE__));//  脚本所在目录修改。
		$now=strlen(getcwd());
		if($or>$now){
			return false;
		}else{
			return $str;
		}
	}
?>
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
    	<div class="modal-header">
    		<h4 class="modal-title" id="myModalLabel">添加文件夹</h4>
    	</div>
      	<div class="modal-body">
      		<input type="text" name="dir" id="dir" class="form-control">
      	</div>
      	<div class="modal-footer">
      		<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
      	 	<button type="button" class="btn btn-primary" id="qd">确定</button>
      	</div>
    </div>
  </div>
</div>
<script type="text/javascript">
	$("#qd").click(function(){
		var dir=$("#dir").val();
		if(dir){
			window.location.href="?mk="+dir;
		}
	})
</script>