<?php 
session_start();

if ( empty($_GET['url'])  ) {
	header('Location: /?error=url');
}
if ( empty($_GET['email']) ) {
	header('Location: /?error=email');
}


/** Validate captcha */
if ( !$_SESSION['human'] && (empty($_REQUEST['captcha']) 
	|| empty($_SESSION['captcha']) 
    || trim(strtolower($_REQUEST['captcha'])) != $_SESSION['captcha']) ) {
		header('Location: /?error=captcha');

} else { 
	$_SESSION['human'] = true;
}
require('includes/common.php');
require('includes/db.php');
require('includes/dao.php');
require('includes/functions.php');
	
$found_wp = false;
$found_vers = false;
$is_secure = false;
$guess_made = false;

$login_check = array ('admin' => '', 'harvest' => '');
$target = $_GET['url'];
$email = $_GET['email'];
	
try {
	save_user($email);
} catch (Exception $e) {
	echo 'Caught exception: ',  $e->getMessage(), "\n";
}

$url = wash_url($target);

if ($url) {
	$content = get_page($url);
	if (empty($content) ) {
		header('Location: /?error=content');
	}
	
	$file = 'logs/' . time() . '.log';
	file_put_contents($file, $content);
	
	$hack_details = detect_hack($content);
	$path = detect_path($content);
	
	$version = detect_version($content, $path);

	if ($version != '') {
		$found_wp = true;
		$found_vers = true;
		$is_secure = version_compare($version, LATEST);
	} 
	
	if (!$found_wp && guess_wp($content)) {		
		$guess_made = true;
	}
	
	if ($path) {
		$found_wp = true;
		$login_check = check_login($path);
	}
 ?>
<html>
<head>
	<title>WordPress Scan Results</title>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-28646142-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<div class="wrap">
<a href="/">New Scan</a> | <a href="/scan.php?url=<?php echo $_GET['url'] ?>&email=<?php echo $_GET['email']?>">Rescan</a>
	<fieldset class="results">
<?php
	echo "<legend>Scan Results for $url</legend>\n";
	// Output results
	echo '<ol>';
	if ($found_vers) {
		echo VERS_IS . "$version </li>\n";
		
		// funky test syntax from version_compare function
		if ($is_secure == -1) {
			echo OLD_VERS;
		} else {
			echo CURR_VERS;
		}
	} else {
		echo VERS_HIDDEN;
	} 
		
	if ($hack_details) {

		// echo without li so that it can output multiple <li> for matches
		echo $hack_details;
	} 
		
	if($path) {
		echo VERS_FOUND . " $path.</li>\n";
	} else { 
		echo PATH_HIDDEN;
		if($guess_made) {
			echo GUESS_WARN;
			echo GUESS_HIDDEN; 
		}
	}
	
	if ($login_check['harvest']) {
		echo HARVEST_WARN;
	} else {
		echo HARVEST_PRAISE;
	}
	
	if ($login_check['admin']) {
		echo ADMIN_WARN;
	} else if ($login_check['harvest']) {
		echo ADMIN_PRAISE;
	}
	
	echo "</ol>\n";

	save_scan($email, $url, 'WordPress', $version, $path, '', 0);
} else {
	header('Location: '. SERVER_URL . '?error=content');
}
?>
	</fieldset>
	You've run <?php echo get_scans_today($email); ?> scans today.
</div>
</body>
</html>
