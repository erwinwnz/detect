<?php

require_once('./PhpUserAgent-master/Source/UserAgentParser.php');

function getClientIPInfo($ip = null) {
	global $_SERVER;
		
		if ( is_null( $ip ) ) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
    $json_data = file_get_contents('http://api.ipstack.com/'.$ip.'?access_key=953be5d8b0c63084682f78dc49d9abcf&format=1');
    $data = json_decode($json_data, true);
    return $data;
}

$query = @unserialize (file_get_contents('http://ip-api.com/php/'));
if ($query && $query['status'] == 'success') {
echo 'Hey user from ' . $query['country'] . ', ' . $query['city'] . '!';
}
foreach ($query as $data) {
    echo $data . "<br>";
}
$geoplugin = getClientIPInfo();
$ua_info = parse_user_agent();

echo "Geolocation results for {$_SERVER['REMOTE_ADDR']}: <br />\n".
	"City: {$geoplugin->city} <br />\n".
	"Country Name: {$geoplugin->country_name} <br />\n".
	"Platform: {$ua_info['platform']} <br />\n".
	"Browser: {$ua_info['browser']} <br />\n".
	"Version: {$ua_info['version']} <br />\n";


?>
