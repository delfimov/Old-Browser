<?php

class checkBrowser {

	
	public static $modernVersion = array(
		'firefox'	=> 6,
		'chrome'	=> 12,
		'safari'	=> 5,
		'opera'		=> 10,
		'msie'		=> 8
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
		if ($browser['platform']=='' || $browser['version']==0 || $browser['short']=='') { 
			return false;
		}

		return isset(self::$modernVersion[$browser['short']]) && $browser['version']<self::$modernVersion[$browser['short']];
	}


	public static function getBrowser() {
	
		$u_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';

		// операционная система
		if (preg_match('/windows|win32|win64/i', $u_agent)) {
			$platform = 'windows';
		} else
		if (preg_match('/macintosh|mac os x/i', $u_agent)) {
			$platform = 'mac';
		} else
		if (preg_match('/linux/i', $u_agent)) {
			$platform = 'linux';
		} else {
			$platform = '';
		}
	   
		// название браузера 
		if (preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) {
			$bname = 'Internet Explorer';
			$ub = 'MSIE';
		} else
		if (preg_match('/Firefox/i',$u_agent)) {
			$bname = 'Mozilla Firefox';
			$ub = 'Firefox';
		} else
		if (preg_match('/Chrome/i',$u_agent)) {
			$bname = 'Google Chrome';
			$ub = 'Chrome';
		} else
		if (preg_match('/Opera/i',$u_agent)) {
			$bname = 'Opera';
			$ub = 'Opera';
		} else
		if (preg_match('/Safari/i',$u_agent)) {
			$bname = 'Apple Safari';
			$ub = 'Safari';
		} else
		if (preg_match('/Netscape/i',$u_agent)) {
			$bname = 'Netscape';
			$ub = 'Netscape';
		} else {
			$bname = '';
			$ub = '';
		}

		// пытаемся узнать номер версии, создаем паттерн для регэкспа, ищем и находим
		if ($ub=='MSIE') { // MSIE в режиме совместимости попытается нас обмануть 
			if (strpos($u_agent, 'Trident/4.0')!==false) {
				$version = '8.0';
			} else 
			if (strpos($u_agent, 'Trident/5.0')!==false) {
				$version = '9.0';
			}
			// как будет обманывать IE 10 предсказать невозможно
		}
		if (!isset($version)) {
			$pattern = '#(?<browser>Version|' . $ub . '|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
			if (!preg_match_all($pattern, $u_agent, $matches)) {
				// нет совпадений. возможно, стоит как-то обрабатывать этот случай, а пока просто продолжаем
			}

			// проверяем сколько совпадений с паттерном
			if (count($matches['browser']) > 1) {
				//если совпадений больше 1, проверяем где стоит слово Version - до или после номера
				if (strripos($u_agent, 'Version') < strripos($u_agent, $ub)) {
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
		// проверяем есть ли у нас номер версии
		if (!isset($version) || $version=='') {
			$version = '?';
			$version_int = 0;
		} else {
			$version_int = (int)$version;
		}
		
		$version = (!isset($version) || $version=='') ? 0 : (int)$version;

		return array(
			'user_agent'	=> $u_agent,
			'short'			=> strtolower($ub),
			'name'			=> $bname,
			'version'		=> $version,
			'platform'		=> $platform,
		);
	}

}