<?php
function basic_cURL($url, $useragent = 0, $cookie = 0, $data = 0, $httpheader = array(), $proxy = 0, $userpwd = 0, $is_socks5 = 0){
    $url = $url;
    $ch  = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    if ($useragent)
    	curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    if ($proxy)
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
    if ($userpwd)
        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $userpwd);
    if ($is_socks5)
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
    if ($httpheader)
        curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    if ($cookie)
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    if ($data):
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    endif;
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch);
    if (!$httpcode)
        return false;
    else {
        $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        $body   = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        curl_close($ch);
        return array(
            $header,
            $body
        );
    }
}

function curl_mashape($url, $apikey){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    $headers   = array();
    $headers[] = "X-Mashape-Key: ".$apikey;
    $headers[] = "Accept: application/json";
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    
    return $result;
}

function ip(){
     $ipaddress = '';
     if (getenv('HTTP_CLIENT_IP'))
         $ipaddress = getenv('HTTP_CLIENT_IP');
     else if(getenv('HTTP_X_FORWARDED_FOR'))
         $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
     else if(getenv('HTTP_X_FORWARDED'))
         $ipaddress = getenv('HTTP_X_FORWARDED');
     else if(getenv('HTTP_FORWARDED_FOR'))
         $ipaddress = getenv('HTTP_FORWARDED_FOR');
     else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
     else if(getenv('REMOTE_ADDR'))
         $ipaddress = getenv('REMOTE_ADDR');
     else
         $ipaddress = 'UNKNOWN';

     return $ipaddress; 
}

function rupiah($numbers){
	$hasil_rupiah = "Rp " . number_format($numbers,2,',','.');
	return $hasil_rupiah;
 
}

function rand_str($type, $length){
	$characters = array();
    $characters['numbers']			= '0123456789';
    $characters['capital']			= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters['small']			= 'abcdefghijklmnopqrstuvwxyz';
    $characters['capital_numbers']	= '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters['small_numbers']		= '0123456789abcdefghijklmnopqrstuvwxyz';
    $characters['all']				= '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength				= strlen($characters[$type]);
    $randomString					= '';

    for ($i = 0; $i < $length; $i++){
    	$randomString .= $characters[$type][rand(0, $charactersLength - 1)];
    }

    return $randomString;
}

function random_month() {
	$month = mt_rand(1,12);
	if($month == '1'){
		$month = '01';
	} else if($month == '2'){
		$month = '02';
	} else if($month == '3'){
		$month = '03';
	} else if($month == '4'){
		$month = '04';
	} else if($month == '5'){
		$month = '05';
	} else if($month == '6'){
		$month = '06';
	} else if($month == '7'){
		$month = '07';
	} else if($month == '8'){
		$month = '08';
	} else if($month == '9'){
		$month = '09';
	} 

	return $month;
}

function random_year() {
	$year = mt_rand(1,5);
	$now  = date('y');
	if($year == '1'){
		$year = $now+1;
	} else if($year == '2'){
		$year = $now+2;
	} else if($year == '3'){
		$year = $now+3;
	} else if($year == '4'){
		$year = $now+4;
	} else if($year == '5'){
		$year = $now+5;
	} else {
		$year = '';
	}

	return $year;
}

function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
 
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function getUserAgent(){
	$userAgentArray[] = "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:57.0) Gecko/20100101 Firefox/57.0";
	$userAgentArray[] = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36 Edg/114.0.1823.37";
	$userAgentArray[] = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36";
	$userAgentArray[] = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36 OPR/99.0.0.0";
	
	$getArrayKey = array_rand($userAgentArray);
	return $userAgentArray[$getArrayKey];
 
}


function axemail($apikey, $receiver_email, $sender_name, $sender_email, $subject, $body, $html){
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => "https://nthanfp.me/api/post/sendMail/",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "apikey=".$apikey."&receiver_email=".$receiver_email."&sender_name=".$sender_name."&sender_email=".$sender_email."&subject=".$subject."&body=".$body."&is_html=".$html."",
		CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache",
			"content-type: application/x-www-form-urlencoded"
		),
	));
	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	if ($err) {
		return "cURL Error #:" . $err;
	} else {
		return $response;
	}
}

function get_gravatar($email, $s = 80, $d = 'mp', $r = 'g', $img = false, $atts = array()) {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

function saveData($saveFile, $data){
    $x = $data . "\n";
    $y = fopen($saveFile, 'a');
    fwrite($y, $x);
    fclose($y);
}
function saveCookie($saveFile, $data){
    $x = $data;
    $y = fopen($saveFile, 'w');
    fwrite($y, $x);
    fclose($y);
}
?>