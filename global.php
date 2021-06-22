<?php
define("ROOT",				dirname(__FILE__));
define("ROOT_APP",			ROOT."/app");
define("ROOT_CONFIG",		ROOT."/config");
define("ROOT_SLIGHTPHP",	ROOT."/vendor/hetao29/slightphp/");
define("ROOT_PLIGUNS",		ROOT_SLIGHTPHP."/plugins");
require_once(ROOT_SLIGHTPHP."/SlightPHP.php");
function autoload($class){
	if($class[0]=="S"){
		$file = ROOT_PLIGUNS."/$class.php";
	}else{
		$file = SlightPHP::$appDir."/".str_replace("_","/",$class).".page.php";
	}
	if(file_exists($file)) return require_once($file);
}
spl_autoload_register('autoload');