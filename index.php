<?php 
//生产环境使用时请注释掉下面两行，抑制报错！！！
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
require_once("global.php");
SlightPHP::setAppDir(ROOT_APP);
SlightPHP::setSplitFlag("-_.");
SlightPHP::setDebug(true);
SlightPHP::setDefaultZone('php');
SlightPHP::setDefaultPage('login');
//SlightPHP::run();
if(SlightPHP::run()===false){
	header('HTTP/1.1 404 Not Found');
	header('Status: 404 Not Found');
    header("Location: html/404.html");
//	include 'html/index.php';
}else{
    exit;
}
?>