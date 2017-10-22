<?php

require('/var/www/html/projetos/app/template/Smarty.class.php');
require_once('config.php');
require_once('user.class.php');
require_once('database.class.php');

$smarty = new Smarty();

$smarty->setTemplateDir('/var/www/html/projetos/app/template/smarty/templates');
$smarty->setCompileDir('/var/www/html/projetos/app/template/smarty/templates_c');
$smarty->setCacheDir('/var/www/html/projetos/app/template/smarty/cache');
$smarty->setConfigDir('/var/www/html/projetos/app/template/smarty/configs');