<?php
	define('LATEST', '3.4.1');
	define('SERVER_URL', '/');
	define('DEBUG', true);
	define('AGENT', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0');
	
	//Error Messages (not stored in a constant, because you can't assign an array to constant and seralizing is annoying.
	$Error = array(
				'content' => 'Woah, I didn\'t find a website at that address.',
				'url' => 'Please enter a WordPress website to scan.',
				'email' => 'Please enter an email. Use a <a href="http://10minutemail.com/10MinuteMail/index.html" target="_blank">temp email</a> if you must.',
				'captcha' => 'Captcha is incorrect. Try again.',
				);
				
	// Scold the user
	define('OLD_VERS', '<li class="chaotic">Your WordPress is missing critical security updates and is wide open to hackers!<br />' .
					     'You should upgrade to ' . LATEST . ' immediately.</li>');
	define('HACK_WARN', '<li class="chaotic">We\'ve discovered a possible hack attempt on your website!</li>');
	define('IFRAME_WARN', '<li>Your site contains an iframe. This could be bad, or just advertising.</li>');
	define('ADMIN_WARN', '<li class="chaotic">You are using Admin for the user of your website.</li>');
	define('HARVEST_WARN', '<li class="neutral">Your admin login allows account names to be harvested.</li>');
	
	// Warn the user
	define('GEN_WARN', '<li class="neutral">HTML from WordPress has been detected.</li>');
	define('VERS_FOUND', '<li class="neutral">Your WordPress files were discovered at ');
	define('VERS_IS', '<li class=\"neutral\">Your version: ');
	
	// Praise the user
	define('CURR_VERS', '<li class="lawful">Wonderful. Your WordPress files are up to date!</li>');
	define('VERS_HIDDEN', '<li class="lawful">I can\'t find your version number. Excellent!</li>');
	define('PATH_HIDDEN', '<li class="lawful">Nice! I couldn\'t find your WordPress files.</li>');
	define('ADMIN_HIDDEN', '<li class="lawful">Nice, I could not find your admin screen!</li>');
	define('GUESS_HIDDEN', '<li class="lawful">If you are running WordPress, I\'m impressed because I can\'t find a WordPress install!</li>');
	define('ADMIN_PRAISE', '<li class="lawful">Smart move not using admin for your user.</li>');
	define('HARVEST_PRAISE', '<li class="lawful">Impressive! I can\'t harvest user names from your site.</li>');
	
	//Generic patterns
	define('URL_MATCH', '|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i');
	
	//WordPress patterns
	define('GEN_MATCH', '|<meta name="generator" content="WordPress(.*)" />|i');
	define('VERS_MATCH', '|Version (.*)|');
	define('INC_PATH', '|href="(.*)/wp-includes/|');
	define('CONTENT_SRC',  '|src="(.*)/wp-content/|');
	define('CONTENT_PATH', '|href="(.*)/wp-content/|');	
	define('SRC_PATH', "|src='(.*)/wp-includes/|");
	define('PINGBACK', '|<link rel="pingback" href="(.*)/xmlrpc.php|');
	
	define('HEADER', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' 
				 . '<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">'
				 . '<head profile="http://gmpg.org/xfn/11">'
				 . '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />');
				 
 	define('INVALID_USER', 'Invalid username.');
 	define('INVALID_PASS', 'The password you entered for the ');
?>
