<?php
global $_SERVER;
require_once('./geo/geoplugin.class.php');
require_once('./PhpUserAgent-master/Source/UserAgentParser.php');

function getClientIPInfo($ip = $_SERVER['REMOTE_ADDR']) {
    $json_data = file_get_contents('http://ipinfo.io/'.$ip.'/json');
    $data = json_decode($json_data, true);
    return $data;
}
$geoplugin = new geoPlugin();
$geoplugin->locate();
$ua_info = parse_user_agent();
print_r(getClientIPInfo());
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
