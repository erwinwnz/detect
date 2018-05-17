<?php

require_once('geoplugin.class/geoplugin.class.php');
require_once('PhpUserAgent-master/Source/UserAgentParser.php');

$geoplugin = new geoPlugin();
$geoplugin->locate();
$ua_info = parse_user_agent();
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
