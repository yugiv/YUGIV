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
	function password($password){
		$password= sha1($password);
		$salt='d0be2dc421be4fcd0172e5afceea3970e2f3d940';
		$new='';
		$d=0;
		for($i=0;$i < strlen($password); $i++) {
		    $new .= $password[$d].$salt[$i];
			$d++;
		}
		return $new;
	}
	function bignumberkiller($number) {
			$pcount=$number;
			if($pcount>=1000000000000){
				$pcount=(substr(substr(($pcount/1000000000000), 0, 4), -1)==".")?substr(($pcount/1000000000000), 0, 3):substr(($pcount/1000000000000), 0, 4);
				$pcount .='T';
			}else if($pcount>=1000000000){
				$pcount=(substr(substr(($pcount/1000000000), 0, 4), -1)==".")?substr(($pcount/1000000000), 0, 3):substr(($pcount/1000000000), 0, 4);
				$pcount .='B';
		    }else if($pcount>=1000000){
		    	$pcount=(substr(substr(($pcount/1000000), 0, 4), -1)==".")?substr(($pcount/1000000), 0, 3):substr(($pcount/1000000), 0, 4);
		    	$pcount .='M';
		    }else if($pcount>=1000){
		    	$pcount=(substr(substr(($pcount/1000), 0, 4), -1)==".")?substr(($pcount/1000), 0, 3):substr(($pcount/1000), 0, 4);
		    	$pcount .='K';
			}
			return $pcount;
		}
?>