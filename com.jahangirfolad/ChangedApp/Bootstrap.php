<?php

session_start();
require_once "Config/Config.php";
require_once "Helper/Helpers.php";

function my__autoload($classes)
{
    require_once "Library/" . $classes . ".php";
}
spl_autoload_register("my__autoload");