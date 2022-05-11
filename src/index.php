<?php
/*------------------------------------------------------------*/
require_once("clonesConfig.php");
require_once(M_DIR."/mfiles.php");
require_once("clonesFiles.php");
require_once("Clones.class.php");
/*------------------------------------------------------------*/
$startTime = microtime(true);
/*------------------------------------------------------------*/
global $Mview;
global $Mmodel;
$Mview = new Mview;
$Mmodel = new Mmodel;
$Mview->holdOutput();
/*------------------------------------------------------------*/
$clonesLogin = new ClonesLogin;
if ( isset($_REQUEST['logOut']) ) {
	$clones = new Clones;
	$clonesLogin->logOut();
	$clones->showLoginScreen();
	$Mview->flushOutput();
	exit;
}
if ( ! $clonesLogin->enterSession() ) {
	$clones = new Clones;
	$clones->showLoginScreen();
	$Mview->flushOutput();
	exit;
}
$clones = new Clones;
$clones->setStartTime($startTime);
$clones->control();
$Mview->flushOutput();
/*------------------------------------------------------------*/
/*------------------------------------------------------------*/
