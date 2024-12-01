<?php

	function acentos($txt){
		return (!preg_match('!!u', $txt))? utf8_encode($txt) : $txt;
	}


	// function para validar fechas con formato yyy-mm-dd y que sean valores reales
	function isDate($txtDate)
	{
		$currVal = $txtDate;
		if($currVal == '')
			return false;

		$rxDatePattern = '/^(\d{4})(-)(\d{2})(-)(\d{2})$/';
		$dtArray = preg_match($rxDatePattern, $currVal);

		if($dtArray == null)
			return false;

		$dtArray = explode("-", $txtDate);

		$dtMonth	= $dtArray[1];
		$dtDay		= $dtArray[2];
		$dtYear		= $dtArray[0];

		if($dtMonth < 1 || $dtMonth > 12){
			return false;
		}
		else if ($dtDay < 1 || $dtDay> 31){
			return false;
		}
		else if (($dtMonth==4 || $dtMonth==6 || $dtMonth==9 || $dtMonth==11) && $dtDay ==31){
			return false;
		}
		else if ($dtMonth == 2){
			$isleap = ($dtYear % 4 == 0 && ($dtYear % 100 != 0 || $dtYear % 400 == 0));
			if($dtDay > 29 || ($dtDay ==29 && !$isleap)){
				return false;
			}
		}
		return true;
	}

	function utf8ize($d) {
		if (is_array($d)) {
			foreach ($d as $k => $v) {
				$d[$k] = utf8ize($v);
			}
		} else if (is_string ($d)) {
			return utf8_encode($d);
		}
		return $d;
	}
?>