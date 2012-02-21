<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Old Browser Check & Warning</title>
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
include('lib/checkBrowser.php');
echo checkBrowser::warning(null, true);
?>
<div id="warning_desc"><?=(checkBrowser::isOld())?'Демонстрация вывода стандартного сообщения. А вам, кстати, действительно пора обновить браузер.':'Не пугайтесь, сообщение выше вас не касается. Это демонстрация вывода стандартного сообщения.'?></div>

    <div class="container">

      <div class="hero-unit">
        <h1>checkBrowser</h1>
        <p>Статический PHP класс, позволяет проверять версию браузера и&nbsp;показывать сообщение с&nbsp;предложением обновить браузер.</p>
        <p><a href="https://github.com/Groozly/CheckBrowser" class="btn primary large">checkBrowser на GitHub &raquo;</a></p>
      </div>

      <div class="row">
	  
		<div class="span-one-third">
			<h2>Какой браузер устарел?</h2>
			<p>Информацию об актуальных версиях браузеров можно взять на сайте <a href="http://www.elfimov.ru/browsers">Fresh Browsers</a>.</p>
		</div>
		
        <div class="span-one-third">
			<h2>Зачем это нужно</h2>
			<p>Бла-бла-бла про эксплорер, старые браузеры, и&nbsp;новые технологии.</p>

			<h2>Javascript version</h2>
			<p><s>Существует также <a href="">checkBrowser для JS</a></s> Скоро будет JS версия. </p>
			<p>PHP версия проверяет версию браузера на сервере и не добавляет дополнительный код, если пользователь использует современный бразуер. </p>
			<p>JS-версия загружается браузером пользователя вне зависимости от версии, но показывает предупреждение только пользователям старых браузеров.</p>
       </div>
	   
        <div class="span-one-third">
          <h2>Пример использования</h2>
			<pre class="prettyprint">
&lt;?php

include('lib/checkBrowser.php');

echo checkBrowser::warning();

$message = 'У вас очень старый браузер.&lt;br /&gt;Скачайте и установите современный:&lt;br /&gt;&lt;a id=&quot;cb_firefox&quot; href=&quot;http://www.mozilla.com/firefox&quot;&gt;Firefox&lt;/a&gt;&lt;a id=&quot;cb_chrome&quot; href=&quot;http://www.google.com/chrome&quot;&gt;Chrome&lt;/a&gt;';

echo checkBrowser::warning($message);

print_r(checkBrowser::getBrowser());
			</pre>
        </div>
      </div>

      <footer>
        <p>&copy; <a href="mailto:dmitry@elfimov.ru">Dmitry Elfimov</a> 2011&mdash;<?=date('Y')?></p>
      </footer>

    </div>

  </body>
</html>
