<?php

class checkBrowser {

	
	public static $modernVersion = array(
		'firefox'	=> 6,
		'chrome'	=> 12,
		'safari'	=> 5,
		'opera'		=> 10,
		'msie'		=> 8
	);
	
	// не выводить предупреждение для пользователей этих ОС
	public static $notOldOS = array(
		'symbian', 'android', 'ios', 'blackberry', 'j2me',
		'windows mobile', 'webos', 'palm', 'playbook',
		'playstation', 'wii', 'xbox', 'robot'
	);
	
	public static function warning($out='', $always=false) {
		
		if ($always || (self::cookie() && self::isOld())) { 
		
			if ($out=='') {
				$out = '<div id="check_browser_warning">'
							.'<div class="check_browser_message">'
								.'Вы используете устаревший браузер.<br /> Для того, чтобы использовать все возможности сайта, загрузите и установите один из современных браузеров: '
							.'</div>'
							.'<div class="check_browser_browsers">'
								.'<a href="http://www.mozilla.com/firefox" id="check_browser_firefox" class="check_browser_link">Firefox</a>'
								.'<a href="http://www.google.com/chrome" id="check_browser_chrome" class="check_browser_link">Chrome</a>'
								.'<a href="http://www.apple.com/safari/download/" id="check_browser_safari" class="check_browser_link">Safari</a>'
								.'<a href="http://www.opera.com/browser/download/" id="check_browser_opera" class="check_browser_link">Opera</a>'
								.'<a href="http://www.microsoft.com/ie" id="check_browser_ie" class="check_browser_link">Internet Explorer</a>'
							.'</div>'
						.'</div>';
			}
			
		}
		return $out;
	}


	public static function cookie() {
		if (isset($_COOKIE['checkbrowser']) && $_COOKIE['checkbrowser']==1) {
			return false; // куку устанавливать не надо, т.к. уже есть
		} else {
			setcookie('checkbrowser', 1, 0); // кука работает до закрытия браузера
			return true; // установили куку, показываем сообщение
		}
	}



	public static function isOld() {
	
		$browser = self::getBrowser();

		// для неизвестных браузеров не показываем предупреждение, т.к. это может быть мобильное устройство, тв-приставка и что угодно
		if ($browser['os']=='' || $browser['version']==0 || $browser['short']=='') { 
			return false;
		}

		return isset(self::$modernVersion[$browser['short']]) 
				&& $browser['version'] < self::$modernVersion[$browser['short']]
				&& !in_array($browser['os'], self::$notOldOS);
	}


	public static function getBrowser() {
	
		$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';

		// операционная система
		if (preg_match('/windows mobile|windows phone|windows ce/i', $userAgent)) {
			$os = 'windows mobile';
		} else
		if (preg_match('/windows|win32|win64/i', $userAgent)) {
			$os = 'windows';
		} else
		if (preg_match('/macintosh|mac os x/i', $userAgent)) {
			$os = 'mac';
		} else
		if (stripos($userAgent, 'android')!==false) {
			$os = 'android';
		} else
		if (preg_match('/ipad|iphone|ipod/i', $userAgent)) {
			$os = 'ios';
		} else
		if (preg_match('/series 60|symbos|symbian/i', $userAgent)) {
			$os = 'symbian';
		} else
		if (stripos($userAgent, 'blackberry')!==false) {
			$os = 'blackberry';
		} else
		if (preg_match('/j2me|midp/i', $userAgent)) {
			$os = 'j2me';
		} else
		if (stripos($userAgent, 'xbox')!==false) {
			$os = 'xbox';
		} else
		if (stripos($userAgent, 'wii')!==false) {
			$os = 'wii';
		} else
		if (stripos($userAgent, 'playstation')!==false) {
			$os = 'playstation';
		} else
		if (stripos($userAgent, 'webos')!==false) {
			$os = 'webos';
		} else
		if (stripos($userAgent, 'palmos')!==false) {
			$os = 'palm';
		} else
		if (stripos($userAgent, 'playbook')!==false) {
			$os = 'playbook';
		} else
		if (preg_match('/robot|spider|bot|crawl|search|w3c_validator|jigsaw|search/i', $userAgent)) {
			$os = 'robot';
		} else
		if (stripos($userAgent, 'linux')!==false) {
			$os = 'linux';
		} else
		if (stripos($userAgent, 'freebsd')!==false) {
			$os = 'freebsd';
		} else {
			$os = '';
		}
	   
		// название браузера 
		if (stripos($userAgent, 'msie')!==false && stripos($userAgent, 'opera')===false ) {
			$name = 'Internet Explorer';
			$short = 'msie';
		} else
		if (stripos($userAgent, 'firefox')!==false) {
			$name = 'Mozilla Firefox';
			$short = 'firefox';
		} else
		if (stripos($userAgent, 'chrome')!==false) {
			$name = 'Google Chrome';
			$short = 'chrome';
		} else
		if (stripos($userAgent, 'opera')!==false) {
			$name = 'Opera';
			$short = 'opera';
		} else
		if (stripos($userAgent, 'safari')!==false) {
			$name = 'Apple Safari';
			$short = 'safari';
		} else
		if (stripos($userAgent, 'netscape')!==false) {
			$name = 'Netscape';
			$short = 'netscape';
		} else {
			$name = '';
			$short = '';
		}

		// пытаемся узнать номер версии, создаем паттерн для регэкспа, ищем и находим
		if ($short=='MSIE') { // MSIE в режиме совместимости попытается нас обмануть 
			if (strpos($userAgent, 'Trident/4.0')!==false) {
				$version = '8.0';
			} else 
			if (strpos($userAgent, 'Trident/5.0')!==false) {
				$version = '9.0';
			}
			// как будет обманывать IE 10 предсказать невозможно
		}
		if (!isset($version)) {
			$pattern = '#(?<browser>Version|' . $short . '|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#i';
			if (!preg_match_all($pattern, $userAgent, $matches)) {
				// нет совпадений. возможно, стоит как-то обрабатывать этот случай, а пока просто продолжаем
			}

			// проверяем сколько совпадений с паттерном
			if (count($matches['browser']) > 1) {
				//если совпадений больше 1, проверяем где стоит слово Version - до или после номера
				if (strripos($userAgent, 'Version') < strripos($userAgent, $short)) {
					$version = $matches['version'][0];
				} else {
					$version = $matches['version'][1];
				}
			} else {
				if (isset($matches['version'][0])) {
					$version = $matches['version'][0];
				} else {
					$version = 0;
				}
			}
		}
		
		$version = (!isset($version) || $version=='') ? 0 : (int) $version;

		return array(
			'userAgent'		=> $userAgent,
			'short'			=> $short,
			'name'			=> $name,
			'version'		=> $version,
			'os'			=> $os,
		);
	}

}