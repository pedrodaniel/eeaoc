<?php
class Varios
{
	public function amigar($url)
	{
		$url = str_replace("á","a",$url);
		$url = str_replace("é","e",$url);
		$url = str_replace("í","i",$url);
		$url = str_replace("ó","o",$url);
		$url = str_replace("ú","u",$url);
		$url = str_replace("ü","u",$url);
		$url = str_replace("Ñ","N",$url);
		$url = str_replace("ñ","n",$url);
		$url = str_replace(",","",$url);
		$url = str_replace(";","",$url);
		$url = str_replace(":","",$url);
		$url = str_replace("%","por-ciento",$url);
		$url = str_replace(".","",$url);
		$url = str_replace("@","",$url);
		$url = str_replace("?","",$url);
		$url = str_replace("¿","",$url);
		$url = str_replace("!","",$url);
		$url = str_replace("¡","",$url);
		$url = str_replace("'","",$url);
		$url = str_replace('"','',$url);
		$url = str_replace("(","",$url);
		$url = str_replace(")","",$url);
		$url = str_replace(" ","-",$url);
		
		return $url;
	}
}
?>