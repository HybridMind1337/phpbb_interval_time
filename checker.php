<?php   
	define('IN_PHPBB', true); 
	$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : '../../../'; 
	$phpEx = substr(strrchr(__FILE__, '.'), 1); 
	include($phpbb_root_path . 'common.' . $phpEx); 
	include("$phpbb_root_path/includes/functions_user.php"); //важно, за да работи скрипта по-долу! (вътре са нужните функции)
	$user->session_begin();
	$auth->acl($user->data);
	$user->setup('viewtopic');
	$request->enable_super_globals();
	
	include "../../../config.php";
	$link = mysqli_connect("$dbhost","$dbuser","$dbpasswd","$dbname") or die("Error " . mysqli_error($link)); //кънекция към db (mysqli)
	mysqli_query($link,"SET NAMES utf8"); //dont change
	
	$get = mysqli_query($link,"SELECT config_value FROM phpbb_config WHERE config_name='flood_interval'") or die(mysqli_error($link));
	$row = mysqli_fetch_assoc($get);
	@mysqli_free_result($get);
	
	$flood_interval = $row['config_value'];
	$user_id = (int)$_POST['user_id'];
	
	$proverka = mysqli_query($link,"SELECT user_lastpost_time FROM phpbb_users WHERE user_id='$user_id' AND user_lastpost_time+'$flood_interval'>UNIX_TIMESTAMP()") or die(mysqli_error($link)); 
	$row2 = mysqli_fetch_assoc($proverka);
	if(mysqli_num_rows($proverka) > 0) {
		
		$timer = ($row2['user_lastpost_time']+$flood_interval) - time();
		
		echo json_encode(array('my_countdown'=>"$timer"));
	}
	@mysqli_free_result($proverka);
?>