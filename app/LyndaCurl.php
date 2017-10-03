<?php

namespace LyndaDL;

class LyndaCurl
{
	protected $ch;
	const USER_AGENT = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.12; rv:55.0) Gecko/20100101 Firefox/55.0';
	const COOKIE_FILE = 'storage/cookies.txt';

	function __construct()
	{
		$this->ch = curl_init();
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($this->ch, CURLOPT_USERAGENT, self::USER_AGENT);
		curl_setopt ($this->ch, CURLOPT_COOKIEJAR, self::COOKIE_FILE); 
		curl_setopt ($this->ch, CURLOPT_COOKIEFILE, self::COOKIE_FILE); 
	}

	public function retriveContent($url)
	{
		curl_setopt($this->ch, CURLOPT_URL, $url);
		return curl_exec($this->ch);
	}

	public function downloadVideo($videoLink, $name, $index, $referrer, $courseName)
	{
		$courseName = str_replace(':', ' -', $courseName->name);
		$name = str_replace([':', '/'], '-', $name);
		$folder = "download/{$courseName}";
		if(!is_dir($folder))
			mkdir($folder);

		$index = $index + 1;
		$fp = fopen("{$folder}/{$index}. {$name}.mp4", 'w+');
		curl_setopt($this->ch, CURLOPT_URL, $videoLink);
		curl_setopt($this->ch, CURLOPT_TIMEOUT, 1000);
		curl_setopt($this->ch, CURLOPT_FILE, $fp); 
		curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($this->ch, CURLOPT_REFERER, $referrer);
		curl_exec($this->ch);
		fclose($fp);
	}
}