<?php
/**
 * Created by PhpStorm.
 * User: EA
 * Date: 10/6/2018
 * Time: 8:41 AM
 * This is a cleaner port of my 5 years old  mobile browser redirection script for projectnaija.com.
 * Please give some kind of credit if you are using this work in any of your projects. Thanks!!
 * @param bool $forceDesktop
 */

function detectNeedForRedirect($forceDesktop=false) {

    $currentClient = 'undefined'; //this the default final return for the function, I treat this response as desktop detected
    $mobile_browser = 0; //default value for mobile browser

    if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|BB10)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
        $mobile_browser++;
    }

    if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE'])))) {
        $mobile_browser++;
    }

    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
    $mobile_agents = array(
        'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
        'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
        'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
        'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
        'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
        'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
        'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
        'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
        'wapr','webc','winw','winw','xda ','xda-');

    if (in_array($mobile_ua,$mobile_agents)) {
        $mobile_browser++;
    }

    if (strpos(strtolower($_SERVER['ALL_HTTP']),'OperaMini') > 0) {
        $mobile_browser++;
    }

    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'windows') > 0) {
        $mobile_browser = 0;
    }

    if ($mobile_browser > 0) {
        if ($forceDesktop){
            $currentClient = 'desktop';
        }
        else {
            $currentClient = "mobile";
        }
    }
    return $currentClient;
}

//Example
echo detectNeedForRedirect(true); //force desktop view on mobile
echo "<br/>";
echo detectNeedForRedirect(); //the normal way of doing things

// a more practical usecase
$siteVersion = detectNeedForRedirect();
if ($siteVersion == 'mobile') {
	// redirect to /m or m. or whereever your mobile page is :)
} else {
	// redirect to desktop site
}
