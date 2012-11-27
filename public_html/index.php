<?php 
	session_start();
	ini_set('display_errors', 1); 
	require('includes/common.php');
?>
<html>
<head>
	<title>Free Wordpress Online Vulnerability Scanner</title>
	<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body onload="document.getElementById('url').focus()">
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

<div class="wrap" />
	<h1></h1>
	<?php if ( isset($_GET['error']) ) echo '<p class="error">' . $Error[$_GET['error']] . '</p>'; ?>
	<form action="scan.php" method="get">
		<fieldset>
			<legend>WordPress Vulnerability Scanner</legend>
			<div id="divTxt">
				<div>
					<label for="url">Website:</label>
					<input class="input" name="url" id="url" /> <a style="display:none" href="#" onClick="addFormField(); return false;">add</a>
				</div>
			</div>
			<div>
				<label for="email">Email:</label>
				<input class="input" name="email" id="email" />
			</div>
			<?php if( !isset($_SESSION['human']) ) { ?>
			<div>
				<label for"captcha"><img src="includes/captcha.php" alt="captcha image" /></label>
				<input class="input" type="text" name="captcha" maxlength="6">
			</div>
			<?php } ?>
			<div>
				<input type="submit" class="submit" name="submit" id="submit" value="Scan Site" />
			</div>
			<div class="privacy small">
				Use a 10 minute email, if you must.
			</div>
			<input type="hidden" id="id" value="2">

  		</fieldset>
	</form>
	<div class="small">Built by <a href="http://www.gregboggs.com">Greg Boggs</a>, <a href="http://www.gregboggs.com/blog">WordPress Security</a> blogger.</div>
</div>
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript">
function addFormField() {
	var id = document.getElementById("id").value;
	$("#divTxt").append("<div id='row" + id + "'><label for='txt" + id + "'>Site " + id + ":</label><input class='input' type='text' name='url[]' id='txt" + id + "'>&nbsp;<a href='#' onClick='removeFormField(\"#row" + id + "\"); return false;'>Del</a></div>");
	$('#row' + id).faderEffect();
	
	id = (id - 1) + 2;
	document.getElementById("id").value = id;
}

function removeFormField(id) {
	$(id).remove();
}

$.fn.faderEffect = function(options){
    options = jQuery.extend({
        count: 1, // how many times to fadein
        speed: 500, // spped of fadein
        callback: false // call when done
    }, options);

    return this.each(function(){

        // if we're done, do the callback
        if (0 == options.count) 
        {
                if ( $.isFunction(options.callback) ) options.callback.call(this);
                return;
        }

        // hide so we can fade in
        if ( $(this).is(':visible') ) $(this).hide();

        // fade in, and call again
        $(this).fadeIn(options.speed, function(){
                options.count = options.count - 1; // countdown
                $(this).faderEffect(options); 
        });
    });
}
</script>
</body>
</html>

