<?php

require_once('./geo/geoplugin.class.php');
require_once('./PhpUserAgent-master/Source/UserAgentParser.php');

function detect_city($ip = null) {
        global $_SERVER;
		
		if ( is_null( $ip ) ) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
        $default = 'UNKNOWN';

        if (!is_string($ip) || strlen($ip) < 1 || $ip == '127.0.0.1' || $ip == 'localhost')
            $ip = '8.8.8.8';

        $curlopt_useragent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6 (.NET CLR 3.5.30729)';
        
        $url = 'http://ipinfodb.com/ip_locator.php?ip=' . urlencode($ip);
        $ch = curl_init();
        
        $curl_opt = array(
            CURLOPT_FOLLOWLOCATION  => 1,
            CURLOPT_HEADER      => 0,
            CURLOPT_RETURNTRANSFER  => 1,
            CURLOPT_USERAGENT   => $curlopt_useragent,
            CURLOPT_URL       => $url,
            CURLOPT_TIMEOUT         => 1,
            CURLOPT_REFERER         => 'http://' . $_SERVER['HTTP_HOST'],
        );
        
        curl_setopt_array($ch, $curl_opt);
        
        $content = curl_exec($ch);
        
        if (!is_null($curl_info)) {
            $curl_info = curl_getinfo($ch);
        }
        
        curl_close($ch);
        

        if ( preg_match('{<li>City : ([^<]*)</li>}i', $content, $regs) )  {
            $city = $regs[1];
        }
        if ( preg_match('{<li>Country : ([^<]*)</li>}i', $content, $regs) )  {
            $country = $regs[1];
        }

        if( $city!='' && $country!='' ){
          $location = $country . ', ' . $city;
          return $location;
        }else{
          return $default; 
        }
        
}

$geoplugin = new geoPlugin();
$geoplugin->locate();
$ua_info = parse_user_agent();
print_r(detect_city());
echo "Geolocation results for {$geoplugin->ip}: <br />\n".
	"City: {$geoplugin->city} <br />\n".
	"Region: {$geoplugin->region} <br />\n".
	"Country Name: {$geoplugin->countryName} <br />\n".
	"Latitude: {$geoplugin->latitude} <br />\n".
	"Longitude: {$geoplugin->longitude} <br />\n".
	"Platform: {$ua_info['platform']} <br />\n".
	"Browser: {$ua_info['browser']} <br />\n".
	"Version: {$ua_info['version']} <br />\n";


?>
