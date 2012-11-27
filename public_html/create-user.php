<?php

CRYPT_BLOWFISH or die ('No Blowfish found.');

$link = mysql_connect('localhost', 'wpscanner', 'aUvmxcxvTUPtW8Kw') 
		or die('Not connected : ' . mysql_error());
mysql_select_db('wpscanner', $link) 
		or die ('Not selected : ' . mysql_error());

$password = mysql_real_escape_string($_GET['password']);
$email = mysql_real_escape_string($_GET['email']);

//This string tells crypt to use blowfish for 5 rounds.
$Blowfish_Pre = '$2a$05$';
$Blowfish_End = '$';

// Blowfish accepts these characters for salts.
$Allowed_Chars = 
'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
$Chars_Len = 63;

// 18 would be secure as well.
$Salt_Length = 21;

$salt = "";

for($i=0; $i<$Salt_Length; $i++)
{
    $salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
}
$bcrypt_salt = $Blowfish_Pre . $salt . $Blowfish_End;

$hashed_password = crypt($password, $bcrypt_salt);

$sql = 'UPDATE users '
	 . "SET salt='$salt', password='$hashed_password' "
	 . "WHERE email='$email'";

$mysql_date = date( 'Y-m-d' );

$sql = 'INSERT INTO users (reg_date, email, salt, password) ' .
		"VALUES ('$mysql_date', '$email', '$salt', '$password')";
			
mysql_query($sql) or die( mysql_error() );

$sql = "SELECT salt, password FROM users WHERE email='$email'";
$result = mysql_query($sql) or die( mysql_error() );
$row = mysql_fetch_assoc($result);

$hashed_pass = crypt($password, $Blowfish_Pre . $row['salt'] . $Blowfish_End);

if ($hashed_pass == $row['password']) {
   echo "Password verified!";
}

?>


