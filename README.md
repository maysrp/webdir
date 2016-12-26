#webdir
##index.php
index.php放在你的网站根目录并且设置好你的所在目录权限即可[用于目录浏览]

1.图标图片预览支持IE浏览器
2.手机端自动缩放
只展示该目录以下的所有文件
通过添加禁止显示文件夹以及后缀文件来控制显示
例如:
```
$this->notex=array("php","js","tgz");//不允许显示的后缀名文件
$this->notdir=array("a","phpmyadmin");//不允许显示的文件夹
```

支持在线播放mp4视频和MP3音频以及PDF在线预览,对于手机的自适应不是特别完美。
eg：http://172.82.191.216/

LNMP LAMP 一键包测试通过， **windows下惨不忍睹** 

##wadir.php

**对于index.php的扩充**

基于<a href="https://github.com/shiny/php-aria2">php-aria2</a>，需要安装aria2的支持。
简单的管理:
<img src="http://inory.net/images/2016/12/26/bt1.png" alt="bt1.png" border="0">
<img src="http://inory.net/images/2016/12/26/ec7938932a3f4f0e.png" alt="ec7938932a3f4f0e.png" border="0">
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

##wardir/
将整个文件夹中的文件放在你的网站根目录中：

点击 
>详细管理>界面管理.html 

即可进入原有的<a href="https://binux.github.io/yaaw/">Yaaw</a>，可以在上面添加种子,管理之前的下载。
[iframe大法好，惊呼！]
![001](http://git.oschina.net/uploads/images/2016/1223/191116_8b496e8a_700748.png "wardir/")
![002](http://git.oschina.net/uploads/images/2016/1223/191131_b0e23a59_700748.png "wardir/")
![003](http://git.oschina.net/uploads/images/2016/1223/191140_3c93a4ee_700748.png "wardir/")


##jugg.php
该文件只用于检测你是否完成了aria2的配置，上传到你的网站根目录访问即可，如有正常的文件下载信息表示完成了aria2配置，删除该文件即可。
##dht.dat
有些新安装aria2，可能会因为缺少dht.dat导致无法magnet下载，拷贝该文件到你的/root/.aria2/下即可
##more.php
###简单的多用户实现
创建不同的目录每个目录都放入more.php，需要修改密码[不要设置相同的密码]

每个账户一个目录，登入后只能添加种子。
####缺点：
 1.无限制 [只能通过aria2的配置文件修改全局配置]
 
 2.每个用户都可以看到下载列表
####优点：
 1.简单，只要PHP就够了。
##ffmpge.php
服务器可玩，vps没用，115 牛逼..

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


