#webdir
##index.php
index.php放在你的网站根目录并且设置好你的所在目录权限即可[用于目录浏览]

1.图标图片预览支持IE浏览器

2.手机端自动缩放

开启密码请将前面的"//"删去,默认密码为123
```
//define("PASS","123");//
```
只展示该目录以下的所有文件，通过添加禁止显示文件夹以及后缀文件来控制显示

例如:
```
$this->notex=array("php","js","tgz");//不允许显示的后缀名文件
$this->notdir=array("a","phpmyadmin");//不允许显示的文件夹
```

支持在线播放mp4视频和MP3音频以及PDF在线预览,对于手机的自适应不是特别完美。

eg：http://webdir.cc/

LNMP LAMP 一键包测试通过， **windows下惨不忍睹** 

##wadir.php

详细安装方法:https://github.com/maysrp/webdir/tree/master/doc


**对于index.php的扩充**

基于<a href="https://github.com/shiny/php-aria2">php-aria2</a>，需要安装aria2的支持。
简单的管理:
<img src="http://inory.net/images/2016/12/26/bt1.png" alt="bt1.png" border="0">
<img src="http://inory.net/images/2017/01/03/1561515.png" alt="ec7938932a3f4f0e.png" border="0">
关于导入Magnet成功却从未有速度，且不显示文件名的，可能存在的问题，缺少dht.dat,参考下文中的dht.dat的处理方法
###配置
密码:
```
define("PASS", "admin");
```
配置显示文件以及文件夹
```
$this->notex=array("php","js","tgz");//不允许显示的后缀名文件
$this->notdir=array("a","phpmyadmin");//不允许显示的文件夹
```
##more.php
###简单的多用户实现
创建不同的目录每个目录都放入more.php,配置如下(目录必须可写 0777)：
```
define("PASS", "admin");
define("TYPE","d");//定义结算方式,d为每日,m为每月
define("NUM", 1);//每个结束方式内可以下载的数量
```

每个账户一个目录，登入后能添加magnet，对其进行基本管理。

##moreinfo.php

<img src="http://inory.net/images/2016/12/27/121212112212.png" alt="121212112212.png" border="0" />

多用户控制，可以控制每个用户离线空间的总大小，周期结算类型，每个周期内可用的任务个数，每次任务的大小等......

创建不同的目录每个目录都放入moreinfo.php,配置如下(目录必须可写 0777)：
```
define("PASS", "admin");
define("TYPE","d");//定义结算方式,d为每日,m为每月
define("NUM", 1);//每个结束方式内可以下载的数量
define("DISK", 20);//单位GB,定义总空间大小
define("MAX", 10);//单位GB,定义每个任务的大小[超出自动删除任务]
```
每个账户一个目录，登入后能添加magnet，对其进行基本管理。


##wardir/

移动到:https://github.com/maysrp/wardir

##jugg.php
该文件只用于检测你是否完成了aria2的配置，上传到你的网站根目录访问即可，如有正常的文件下载信息表示完成了aria2配置，删除该文件即可。
##dht.dat
有些新安装aria2，可能会因为缺少dht.dat导致无法magnet下载，拷贝该文件到你的/root/.aria2/下即可

##ffmpge.php

基本界面和之前类似:
![ffmpeg](http://git.oschina.net/uploads/images/2016/1219/040352_a973d056_700748.png "界面")
黄色的就是转换符号，未用到任何数据库,没有转换完成通知，调用时间根据你的设置的PHP脚本运行时间为止。
在线转码，请
php.ini中修改:

删去禁用的exec

以及修改脚本运行时间1000s：

max_execution_time = 1000; 

修改配置后记得重新启动php端：

服务端安装ffmpeg
ubuntu/debian 安装ffmpeg
```
sudo apt-get install ffmpeg
```
VPS转码效率底下
[vultr](http://git.oschina.net/uploads/images/2016/1219/035456_77bbf7bf_700748.png "转换速度")
默认是webm格式的视频修改

```
return "<span class=\"ffmpeg  text-primary\" value=\"?video=".$file."\"><span class=\"glyphicon glyphicon-refresh\"></span></span>|<a href=\"".$file."\" ><span class=\"glyphicon glyphicon-download-alt\"></span></a>";
```

改变为:


 ```
return "<span class=\"ffmpeg text-primary\" value=\"?video=".$file."&type=mp4\"><span class=\"glyphicon glyphicon-refresh\"></span></span>|<a href=\"".$file."\" ><span class=\"glyphicon glyphicon-download-alt\"></span></a>";
```

##gbk.zip
如果中文乱码请解压使用该脚本


