<?php
$serverurl='http://127.0.0.1/';
$projectname='imagenew/';
$ERRORPAGE='error';
$Default_Language='FA';
$Default_Style='style1';
define("GOOGLE_API_KEY", "AIzaSyAJ-dW9h5_Jys8tw20hg9Dh1Sh9LpnEE5U"); // Place your Google API Key
define('RECAPTCHA_SITEKEY', '6LfgDw8TAAAAAJIWH9H8JxsToBsR5RYJXi_6S1fL');
define('RECAPTCHA_SECRET', '6LfgDw8TAAAAAAbHVgYgokR4VFriq0es_1k0glR4');
define('URL_ERROR', $ERRORPAGE);
define('DEFAULT_LANGUAGE', $Default_Language);
define('DEFAULT_STYLE', $Default_Style);
define('URL', $serverurl.$projectname);
define('PROJECTNAME', '/'.trim($projectname,'/'));
$USERCSS_Folder='publicuser/'.Style::reqstyle().'/css/';
$ADMINCSS_Folder='publicadmin/'.Style::reqstyle().'/css/';
$USERJS_Folder='publicuser/'.Style::reqstyle().'/js/';
$ADMINJS_Folder='publicadmin/'.Style::reqstyle().'/js/';
$USERIMG_Folder='publicuser/'.Style::reqstyle().'/images/';
$ADMINIMG_Folder='publicadmin/'.Style::reqstyle().'/images/';
define('URL_USERCSS', $USERCSS_Folder);
define('URL_ADMINCSS', $ADMINCSS_Folder);
define('URL_USERJS', $USERJS_Folder);
define('URL_ADMINJS', $ADMINJS_Folder);
define('URL_USERIMG', $USERIMG_Folder);
define('URL_ADMINIMG', $ADMINIMG_Folder);
$UPEXTENTIONS='png,jpeg,jpg,bmp,gif,pdf,doc,docx,zip,rar,mp4,mp3,flv';
define('UPEXTENTIONS', $UPEXTENTIONS);
//Database Config
$servername='localhost';
$dbtype='mysql';
$dbname='imagewoman';
$dbuser='root';
$dbpass='';
define('SERVERNAME', $servername);
define('DBTYPE', $dbtype);
define('DBNAME', $dbname);
define('DBUSER', $dbuser);
define('DBPASS', $dbpass);
//select data from database
$mod=new Model;
$result=$mod->setinfo();
$row=$result->fetch();
//cache config
$cachetime=$row['cashvalue'];//sec
define('CACHETIME', $cachetime);
//image sharing config
$ALLOW_EXTENTIONS=$row['format'];
$IMAGE_WIDTH=$row['width_img'];
$IMAGE_HEIGHT=$row['height_img'];
$IMAGE_MAX_SIZE=$row['max_size'];
$IMAGE_MIN_SIZE=$row['min_size'];//MB
$IS_WATEMARK=$row['watemark'];
$SiteName=$row['sitename'];
define('SITE_NAME', $SiteName);
define('ALLOW_EXTENTIONS', $ALLOW_EXTENTIONS);
define('IMAGE_MIN_WIDTH', $IMAGE_WIDTH);
define('IMAGE_MIN_HEIGHT', $IMAGE_HEIGHT);
define('IMAGE_MAX_SIZE', $IMAGE_MAX_SIZE);
define('IMAGE_MIN_SIZE', $IMAGE_MIN_SIZE);
define('IS_WATEMARK', $IS_WATEMARK);
