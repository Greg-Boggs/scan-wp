<?php
// Make the URL valid if http is missing, and check to make sure the result is a URL before requesting it
function wash_url($url) {

	//check to see if the address has http:// add it if not.
	$url = (substr(ltrim($url), 0, 7) != 'http://' ? 'http://' : '') . $url;
	
	if ( is_url($url) ) {
		return $url;
	}
}

function is_url($url) {

	return preg_match(URL_MATCH, $url);
}

// Grab the URL
// http://www.php-mysql-tutorial.com/wikis/php-tutorial/reading-a-remote-file-using-php.aspx
function get_page($url) {

	if ( function_exists('curl_init') ) {
	
		$curl_connection = curl_init(); 
		curl_setopt($curl_connection, CURLOPT_URL, $url); 
		curl_setopt($curl_connection, CURLOPT_HEADER, false); 
		curl_setopt($curl_connection, CURLOPT_TIMEOUT, 30); 
		curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl_connection, CURLOPT_USERAGENT, AGENT); 
		$content = curl_exec($curl_connection); 
		curl_close($curl_connection); 
		
		return $content;
	} else {
		die ('Woah, you need to install CURL on this server.<br />');
	}
}

function post_page($url, $user, $pass) {

	//create array of data to be posted
	$post_data['log'] = $user;
	$post_data['pwd'] = $pass;
	
	//traverse array and prepare data for posting (key1=value1)
	foreach ( $post_data as $key => $value) {
    	$post_items[] = $key . '=' . $value;
	}
	
	//create the final string to be posted using implode()
	$post_string = implode ('&', $post_items);

	//create cURL connection
	$curl_connection = curl_init($url);
	
	//set options
	curl_setopt($curl_connection, CURLOPT_HEADER, false); 
	curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($curl_connection, CURLOPT_USERAGENT, AGENT);
	curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);

	//set data to be posted
	curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_string);

	//perform our request
	$result = curl_exec($curl_connection);

	//close the connection
	curl_close($curl_connection);
	
	return $result;
}

// Check for known obvious hacks to see if the site is already hacked.
function detect_hack($content) {
	
	if ( preg_match_all('|<iframe|', $content, $matches) ) {	
		
		$output = IFRAME_WARN;
		return $output;
	}
}

function guess_wp($content) {
	
	$pos = strpos($content, HEADER);
	if($pos !== false) {
	
		return true;
	}

	return false;
}

function detect_version($content, $path='') {
	
	$version = '';
	
	if ( preg_match(GEN_MATCH, $content, $matches) ) {
		$gen = true;
		$version = $matches['1'];
	} else if ($path != '') {
		$content = get_page($path . '/readme.html');
		if ( preg_match(VERS_MATCH, $content, $matches) ) { 
			$version = $matches[1];
		}
	}
	$ver_num = trim( str_replace('.', '', $version) );

	if ( ctype_digit($ver_num) ) {
		return $version;
	}
}	
	
function detect_path($content) {
	
	$path = '';

	// Must check content src before content path, because total cache href + src causes a bad match.
	if ( preg_match(INC_PATH, $content, $matches) ) {
		$path = $matches[1];
	} else if ( preg_match(CONTENT_SRC, $content, $matches) ) {
		$path = $matches[1];
	} else if ( preg_match(CONTENT_PATH, $content, $matches) ) {
		$path = $matches[1];
	} else if ( preg_match(SRC_PATH, $content, $matches) ) {
		$path = $matches[1];
	} else if ( preg_match(PINGBACK, $content, $matches) ) {
		$path = $matches[1];
	}
	return $path;
}

// Detect plugin versions from HTML Comments in the content.
function plugins_comments ($content) {
	
	if ( preg_match('|<!-- All in One SEO Pack (.*) by Michael Torbert|i', $content, $matches) ) {
		$plugins[]['name'] = 'All in One SEO';
		$plugins[]['version'] = $matches['1'];
	}
	if ( preg_match('|<!-- Google Analytics Tracking by Google Analyticator (.*) http://ronaldheft.com|i', $content, $matches) ) {
		$plugins[]['name'] = 'Google Analytics';
		$plugins[]['version'] = $matches['1'];
	}
	return $plugins;
}

// Detect plugin versions from readme text files
function plugins_readme ($path) {

	return $plugins;
}

function check_login($url) {

	// test first for admin user, requires a password not blank
	$user = 'admin';
	$pass = 'password';
	$login = array('admin'=> '', 'harvest' => '');
	
	$content = post_page($url . '/wp-login.php', $user, $pass);
	
	$pos = strpos($content, INVALID_USER);
	if($pos !== false) {
		$login['admin'] = false;
		$login['harvest'] = true;
	}
	
	$pos = strpos($content, INVALID_PASS);
	if($pos !== false) {
		$login['admin'] = false;
		$login['harvest'] = true;
	}
	
	return $login;
}
?>
