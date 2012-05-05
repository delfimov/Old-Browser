<?php

/**
 * CheckBrowser
 *
 * PHP version 5
 *
 * @copyright 2012 Dmitry Elfimov
 * @license   http://www.elfimov.ru/nanobanano/license.txt MIT License
 * @link      http://elfimov.ru/checkbrowser
 * 
 */
 
/*
 * CheckBrowser class
 *
 * @package CheckBrowser
 * @author  Dmitry Elfimov <elfimov@gmail.com>
 *
 */
 
class CheckBrowser
{
    
    public static $modernVersion = array(
        'firefox'    => 6,
        'chrome'    => 12,
        'safari'    => 5,
        'opera'        => 10,
        'msie'        => 8
    );
    
    // do not show warning for mobile devices and robots
    public static $notOldOS = array(
        'symbian', 'android', 'ios', 'blackberry', 'j2me',
        'windows mobile', 'webos', 'palm', 'playbook',
        'playstation', 'wii', 'xbox', 'robot'
    );
    
    
    /**
     * Show warning.
     *
     * @param string  $out    message to return if browser is old. 
     * @param boolean $always always show warning message.
     *
     * @return string message or empty string
     */
    public static function warning($out='', $always=false) 
    {
        if ($always || (self::cookie() && self::isOld())) { 
            if ($out=='') {
                $out = '<div id="check_browser_warning">'
                        .'<div class="check_browser_message">'
                            .'Warning! Your browser is old.<br>'
                            .'It has known security flaws and you will not see all the features of some websites.<br>'
                            .'Please download and install one of the modern browsers:'
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

    /**
     * Check if cookie set. And set if is not set.
     *
     * @return true if cookie is not set, false if set.
     */
    public static function cookie() 
    {
        if (isset($_COOKIE['checkbrowser']) && $_COOKIE['checkbrowser']==1) {
            return false; // cookie is set, do nothing
        } else {
            setcookie('checkbrowser', 1, 0, '/'); // кука работает до закрытия браузера
            return true; // set cookie and show message
        }
    }


    /**
     * Check if browser is old.
     *
     * @return true or false.
     */
    public static function isOld() 
    {
        $browser = self::getBrowser();

        // do not show warning for unknown browsers 
        if ($browser['os']=='' || $browser['version']==0 || $browser['short']=='') { 
            return false;
        }

        return isset(self::$modernVersion[$browser['short']]) 
                && $browser['version'] < self::$modernVersion[$browser['short']]
                && !in_array($browser['os'], self::$notOldOS);
    }

    /**
     * Get info about browser ($_SERVER['HTTP_USER_AGENT']).
     *
     * @return array.
     */
    public static function getBrowser() 
    {
        $userAgent = empty($_SERVER['HTTP_USER_AGENT']) ? '' : $_SERVER['HTTP_USER_AGENT'];

        // detect OS
        if (preg_match('/windows mobile|windows phone|windows ce/i', $userAgent)) {
            $os = 'windows mobile';
        } else if (preg_match('/windows|win32|win64/i', $userAgent)) {
            $os = 'windows';
        } else if (preg_match('/macintosh|mac os x/i', $userAgent)) {
            $os = 'mac';
        } else if (stripos($userAgent, 'android')!==false) {
            $os = 'android';
        } else if (preg_match('/ipad|iphone|ipod/i', $userAgent)) {
            $os = 'ios';
        } else if (preg_match('/series 60|symbos|symbian/i', $userAgent)) {
            $os = 'symbian';
        } else if (stripos($userAgent, 'blackberry')!==false) {
            $os = 'blackberry';
        } else if (preg_match('/j2me|midp/i', $userAgent)) {
            $os = 'j2me';
        } else if (stripos($userAgent, 'xbox')!==false) {
            $os = 'xbox';
        } else if (stripos($userAgent, 'wii')!==false) {
            $os = 'wii';
        } else if (stripos($userAgent, 'playstation')!==false) {
            $os = 'playstation';
        } else if (stripos($userAgent, 'webos')!==false) {
            $os = 'webos';
        } else if (stripos($userAgent, 'palmos')!==false) {
            $os = 'palm';
        } else if (stripos($userAgent, 'playbook')!==false) {
            $os = 'playbook';
        } else if (preg_match('/robot|spider|bot|crawl|search|w3c_validator|jigsaw|search/i', $userAgent)) {
            $os = 'robot';
        } else if (stripos($userAgent, 'linux')!==false) {
            $os = 'linux';
        } else if (stripos($userAgent, 'freebsd')!==false) {
            $os = 'freebsd';
        } else {
            $os = '';
        }
       
        // detect browser name
        if (stripos($userAgent, 'msie')!==false && stripos($userAgent, 'opera')===false ) {
            $name = 'Internet Explorer';
            $short = 'msie';
        } else if (stripos($userAgent, 'firefox')!==false) {
            $name = 'Mozilla Firefox';
            $short = 'firefox';
        } else if (stripos($userAgent, 'chrome')!==false) {
            $name = 'Google Chrome';
            $short = 'chrome';
        } else if (stripos($userAgent, 'opera')!==false) {
            $name = 'Opera';
            $short = 'opera';
        } else if (stripos($userAgent, 'safari')!==false) {
            $name = 'Apple Safari';
            $short = 'safari';
        } else if (stripos($userAgent, 'netscape')!==false) {
            $name = 'Netscape';
            $short = 'netscape';
        } else {
            $name = '';
            $short = '';
        }

        // trying to find out version, we need to create regexp pattern
        if ($short=='msie') { 
            if (strpos($userAgent, 'Trident/4.0')!==false) { // MSIE in compatibility mode 
                $version = '8.0';
            } else if (strpos($userAgent, 'Trident/5.0')!==false) {
                $version = '9.0';
            }
        }
        if (!isset($version)) {
            $pattern = '#(?<browser>Version|' . $short . '|other)[/ ]+(?<version>[0-9.|a-zA-Z.]*)#i';
            if (!preg_match_all($pattern, $userAgent, $matches)) {
                // no matches. probably we should do something in this case.
            }

            // how much matches
            if (count($matches['browser']) > 1) {
                // if more then 1, we should check where is "Version" - before or after number
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
            'userAgent' => $userAgent,
            'short'     => $short,
            'name'      => $name,
            'version'   => $version,
            'os'        => $os,
        );
    }

}