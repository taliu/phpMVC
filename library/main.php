<?php
header("Content-Type: text/html; charset=utf-8");
require_once $_SERVER['DOCUMENT_ROOT']."/library/Autoloader.class.php";
include_once $_SERVER['DOCUMENT_ROOT'].'/RouteConfig.php';
PageEngine::render();
    
 