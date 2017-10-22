<?php

require_once('lib/app.config.php');

$now = date('Y-m-d H:i:s');
$user = new User("chaoserene", "asc3ndant", "lucelio.simas@gmail.com", $now);

$user->registerUser();
$registered = $user->isUserRegistered();

$smarty->assign('luc', $registered);
$smarty->assign('name', 'Luc');
$smarty->display('name.tpl');