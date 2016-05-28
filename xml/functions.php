<?php
	function coder($string)
	{
		if(get_magic_quotes_gpc()){
			$string=stripslashes($string);
		}
		return $string;
	}
	function classer($info){
		if(strpos($info, '[!')!==FALSE && strpos($info, ']')!==FALSE){
			$array= explode("[", $info);
			$final=array();
			foreach ($array as $key) {
				if($key!="" && $key!= null && !empty($key)){
					$type=explode("!", $key);
					$rules=substr($type[2], 0, -1);
					$rules=explode(",", $rules);
					foreach ($rules as $keye) {
						$keye=explode("=", $keye);
						$final[$type[1]][$keye[0]]= $keye[1];
					}
				}
			}
			return $final;
		}else{
			return strpos($info, '[!');
		}
	}
	function generateRandomString() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 12; $i++) {
        $randomString .= $characters[rand(0, 11)];
    }
    return $randomString;
}
?>