<?php 
//$mysql_datetime = date( 'Y-m-d H:i:s' );


// Save the user to the database if the email is unique.
function save_user($email) {
	$mysql_date = date( 'Y-m-d' );

	$sql = 'INSERT INTO users (reg_date, email) ' .
			"VALUES ('$mysql_date', '$email') " .
			'ON DUPLICATE KEY UPDATE scans_today = scans_today+1, total_scans=total_scans+1';

	$result = mysql_query($sql);
	if (!$result) throw new Exception("Save user failed: " . mysql_error());
}

function save_scan($email, $url, $cms, $version, $path, $plugins, $score) {
	
	if ($user_id = get_id($email) ) {
	
		$referred = '';
		$ip = $_SERVER['REMOTE_ADDR'];
		$browser = $_SERVER['HTTP_USER_AGENT'];
		
		$sql = 'INSERT INTO scans(user_id, url, cms, version, cms_path, plugins_count, score, ip, browser) '
			 . "VALUES ($user_id, '$url', '$cms', '$version', '$path', '$plugins', $score, '$ip', '$browser') ";

		$result = mysql_query($sql);
		if (!$result) throw new Exception("Save scan failed: " . mysql_error());
	}
}

function get_id($email) {
	$sql = "SELECT user_id "
		 . "FROM users "
		 . "WHERE email = '$email' "
		 . "LIMIT 1";

	$id = mysql_result(mysql_query($sql),0);
	if (!$id) throw new Exception("Failed to Find an ID " . mysql_error());
	
	return $id;
}

function get_scans_today($email) {
	$sql = "SELECT scans_today "
		 . "FROM users "
		 . "WHERE email = '$email' "
		 . 'LIMIT 1';
		 
	$scans = mysql_result(mysql_query($sql),0);
	if (!$scans) {
		$scans = 0;
	}
	
	return $scans;
}
?>
