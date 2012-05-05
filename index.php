<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Old Browser Check &amp; Warning</title>
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- Le styles -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/check_browser.css" rel="stylesheet">
	<style type="text/css">
		body {
			padding-top: 0px;
		}
		#warning_desc {
			text-align:center;
			color:#666;
			background:#ffc;
			padding:15px 0;
			border-bottom:3px solid #ccc;
		}
	</style>

</head>

<body>

<?php
include('lib/CheckBrowser.php');
echo CheckBrowser::warning(null, true);
?>
<div id="warning_desc"><?=(CheckBrowser::isOld())?'Message above is a demonstration of the standart message. You actually should update your browser.':'Don\'t worry, the message above is just demonstration. Your browser is ok.'?></div>

    <div class="container">

      <div class="hero-unit">
        <h1>CheckBrowser</h1>
        <p>Static PHP class is an opportunity to inform your visitors unobtrusively to switch to a newer browser.</p>
        <p><a href="https://github.com/Groozly/CheckBrowser" class="btn primary large">CheckBrowser on GitHub &raquo;</a></p>
      </div>

      <div class="row">
	  
		<div class="span-one-third">
			<h2>Which browsers is outdated?</h2>
			<p>Information about latest browsers versions is availiable at <a href="http://fresh-browsers.com">Fresh Browsers</a>.</p>
		</div>
		
        <div class="span-one-third">
			<h2>Why is it important?</h2>
			<p>A lot of internet users are using old browsers - most of them for no reason.</p>
            <p>Latest browsers protect you better against numerous threats such as viruses, trojans, phishing and other.</p>
            <p>Every new browser generation improves speed.</p>
            <p>Modern websites will be shown correctly and with all contemporary features.</p>
            <p>With new features, extensions and better customisability, you will have a more comfortable web experience.</p>
       </div>
	   
        <div class="span-one-third">
          <h2>Example</h2>
			<pre class="prettyprint">
&lt;?php

include('lib/CheckBrowser.php');

echo CheckBrowser::warning();

$message = 'Your browser is old.&lt;br /&gt;Download and install modern browser:&lt;br /&gt;&lt;a id=&quot;cb_firefox&quot; href=&quot;http://www.mozilla.com/firefox&quot;&gt;Firefox&lt;/a&gt;&lt;a id=&quot;cb_chrome&quot; href=&quot;http://www.google.com/chrome&quot;&gt;Chrome&lt;/a&gt;';

echo CheckBrowser::warning($message);

print_r(CheckBrowser::getBrowser());
			</pre>
        </div>
      </div>

      <footer>
        <p>&copy; <a href="mailto:dmitry@elfimov.ru">Dmitry Elfimov</a> 2011&mdash;<?=date('Y')?></p>
      </footer>

    </div>

  </body>
</html>
