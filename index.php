<?php 
	require_once('lib/rb.php');
	
	date_default_timezone_set('Europe/Rome');
	
	R::setup('mysql:host=127.0.0.1;dbname=crisafulli','crisafulli', 'pwd');
	R::freeze(TRUE);
	
	$pg=(empty($_REQUEST['p'])) ? 'home' : $_REQUEST['p'];
	$pg='pgs/'.$pg.'.php';
	
?>
<!doctype html>
<html lang="it">
  <head>
    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css"/>
    <title>Manutenzione pc</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  </head>
  <body>
	<div id="all" class="all">
		<? if (file_exists($pg)) include_once($pg); ?>
	</div>
  </body>
  <script src="lib/js/jquery/jquery-3.1.1.min.js"></script>
  <script src="css/bootstrap/js/bootstrap.min.js"></script>
</html>
