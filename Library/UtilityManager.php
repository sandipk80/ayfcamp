<?php
class UtilityManager {
 
  public static function validatePresanceOf($GET_OR_POST, $fieldName, $fieldReadableName, &$error) {
    
    if (!isset($GET_OR_POST[$fieldName]) || trim($GET_OR_POST[$fieldName]) == '') {
      $error[] = sprintf("%s should not be blank.", $fieldReadableName); 
    }
  }
  
  public static function validatePasswordConfirm($GET_OR_POST, $fieldName, $confirmField, $fieldReadableName, &$error) {
    
    if (!isset($GET_OR_POST[$fieldName]) || !isset($GET_OR_POST[$confirmField]) || 
    $GET_OR_POST[$fieldName] != $GET_OR_POST[$confirmField]) {
      $error[] = sprintf("%s must matched with confirm %s.", $fieldReadableName, $fieldReadableName); 
    }
  }
  
  public static function validateUserNameRegex($GET_OR_POST, $fieldName, $fieldReadableName, &$error) {
      if (!preg_match("/[a-zA-Z0-9_]{3,16}/", $GET_OR_POST[$fieldName])) {
          $error[] = sprintf("%s only accepts alphabets, number and _.", $fieldReadableName); 
          $error[] = sprintf("%s length should be between 3 to 16 character without space", $fieldReadableName); 
      }      
  }
  
  public static function validateEmail($GET_OR_POST, $fieldName, $fieldReadableName, &$error) {
    if (!filter_var($GET_OR_POST[$fieldName], FILTER_VALIDATE_EMAIL)) {
        $error[] = sprintf("%s is not valid.", $fieldReadableName); 
    }
  }
  
  
  public static function checkAdminLogin() {
    if (isset($_SESSION['guser']) && $_SESSION['guser'] != '' && isset($_SESSION['gadmin']) && $_SESSION['gadmin'] == 1) {
       return true;
    }
    self::redirect(ADMIN_SITE_URL . 'login.php');    
  }
  
  public static function getUserSessionID() {
    return @(int)$_SESSION['userid'];
  }
  
  public static function encrypt_password($str) {
	return md5($str);
  }

  public static function generateErrorMessage(array $errors) {
    if (count($errors) == 0) {
      return '';
    }
    //$output = array('<h2>Following errors stops page execution:</h2>');
    $output[] = '<ul>';
    foreach ($errors as $error) {
      $output[] = '<li>' . $error . '</li>';
    }
    $output[] = '</ul>';
    return '<div id="error" style="color:red;">' . implode("", $output) . '</div>';    
  }
  
   public static function initObjectWithData($object,  $GET_OR_POST) {	    
        foreach($GET_OR_POST as $key => $value) {
          if (property_exists($object, $key)) {
            $object->$key = $value;              
          }
        }
    }
    
   public static function safe($contents) {
     return $contents;
   }

    public static function validateFilesPresanceOf($files, $fieldName, $fieldReadableName, &$error) {  		
			$extension = "Jpg, Jpeg, Png, Gif";
			##------CHECK IMAGE TYPE-------##         
            if(isset($files['type']) && $files['type']!=='') {
                $getType = explode("/",$files['type']);
                if($getType[0]!=='image') {                   
					$error[] = sprintf("%s is not valid.", $fieldReadableName); 
                }
           }
           ##------CHECK IMAGE SIZE-------##
            if ($files['size'] > 2007152) {               
				$error[] =sprintf("%s should be less than(2MB).", $fieldReadableName);
            }

            ##-----Check image extension---------##
			if (!UtilityManager::validateImageFormat($files['name'])) {
				$error[] =sprintf("%s type not valid.", $fieldReadableName);
			}
  }


   public static function validateImageFormat($imageName){
        $arrExt = array('.jpg','.JPG','.jpeg','.JPEG','.png',',.PNG','.gif','.GIF');
        $ext = substr($imageName, strpos($imageName,'.'), strlen($imageName)-1);
        if(!in_array($ext, $arrExt)) {
                return false;
        }
        else {
                return true;
        }
    }

	/**
	 * Function for crop image
	 *
	 * @param $upfile, file name
	 * @param $dstfile, destination path
	 * @param $max_width, image width
	 * @param $max_height, image height
	 *
	 */

	public static function createThumb($upfile, $dstfile, $max_width, $max_height) {
           $size = getimagesize($upfile);
           $width = $size[0];
           $height = $size[1];

           $x_ratio = $max_width / $width;
           $y_ratio = $max_height / $height;
           if( ($width <= $max_width) && ($height <= $max_height)) {
                   $tn_width = $width;
                   $tn_height = $height;
           } elseif (($x_ratio * $height) < $max_height) {
                   $tn_height = ceil($x_ratio * $height);
                   $tn_width = $max_width;
           } else {
                   $tn_width = ceil($y_ratio * $width);
                   $tn_height = $max_height;
           }

           if($size['mime'] == "image/jpeg"){
                   $src = ImageCreateFromJpeg($upfile);
                   $dst = ImageCreateTrueColor($tn_width, $tn_height);
                   imagecopyresampled($dst, $src, 0, 0, 0, 0, $tn_width, $tn_height,$width, $height);
                   imageinterlace( $dst, true);
                   ImageJpeg($dst, $dstfile, 100);
           } else if ($size['mime'] == "image/png"){
                   $src = ImageCreateFrompng($upfile);
                   $dst = ImageCreateTrueColor($tn_width, $tn_height);
                   imagecopyresampled($dst, $src, 0, 0, 0, 0, $tn_width, $tn_height,$width, $height);
                   Imagepng($dst, $dstfile);
           } else {
                   $src = ImageCreateFromGif($upfile);
                   $dst = ImageCreateTrueColor($tn_width, $tn_height);
                   imagecopyresampled($dst, $src, 0, 0, 0, 0, $tn_width, $tn_height,$width, $height);
                   imagegif($dst, $dstfile);
           }
    }	

   

	public static function getAddressFromLatLong($address) {
		$path = "http://maps.google.com/maps/geo?q=".urlencode($address)."&output=csv&oe=utf8&sensor=false&key=".GOOGLEMAP_KEY;
		$handle = fopen($path, "r");
		$data = fgetcsv($handle, 1000, ",");
		return $data;
	}
	
	public static function getMonthName($index) {
		$months = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
		return @$months[$index  - 1];	
	}

	

	/**
	 * convert date format to given format. This is general function while formatDateYMDToMYD and formatDateYmdToMdy are for specific formats
	 * @param $string: date
	 * @return $string: output will be given format
	**/
	public static function formatDate($str,$format=''){
		
		$strArray = explode("-", $str);

		if($strArray[0] !== 0) {
			$timeStamp = strtotime($str);
			$format = $format!=''?$format:'Y-m-d';
			$date = date($format,$timeStamp);
			return $date;
		} else {
			return $str;
		}

	}
      

  public static function checkValidUrlPageNumber($recordCount,$recordPerPage,$currentPage){
	  $regExp="/[\@\&\#\?\%\*\'\+\=\@\-\^\{\}\!\;\,\(\)\:]/";
	 $currentPage=preg_replace($regExp,"",$currentPage);	
	//$totalpage=ceil($recordCount/$recordPerPage);
		if($currentPage>$recordCount){
					$currentPage=1;
		}
		if(is_numeric($currentPage) && $currentPage>0){
			
			$currentPage=$currentPage;

			}else{
			
			$currentPage= 1;
			}
			return $currentPage;
	}	
	
	
	/**
	*
	* Generate URL given in sorting by link
	*
	* @param $orderByField: is a field name in table by which sorting is required
	* @param $isAdmin: true/false if true url will be created for admin
	* @param $otherParametersArray: Other parameters array which are required in sorting by link
	*
	*/

	public static function getOrderByUrl($orderByField, $otherParametersArray = Array()) {
		//$scripName = utilityManager::getScriptNameFromURI($_SERVER['SCRIPT_NAME']);
		$scripName = $_SERVER['SCRIPT_NAME'];
		
		//	Current Page Name
		if (utilityManager::isEmpty($orderByField)) {
			$orderByUrl = utilityManager::buildTargetURL($scripName, $otherParametersArray);
			return $orderByUrl;
		}

		$otherParametersArray['sortBy'] = $orderByField;
		$orderByUrl = utilityManager::buildTargetURL($scripName, $otherParametersArray);
		return $orderByUrl;
	}
	public static function isEmpty($value) {
		if (isset($value) && (trim($value) == "")) {
			return true;
		}
		else {
			return false;
		}
	}

		/**
	 * Function to Create a Target URL.
	 * @param $pageName, PageName
	 * @param $parametersArray, Name and Value of the Parameters that Appended in the URL.
	 * @param $isAdmin, True if Page in Admin Module Otherwise False
	 * @return $targetURL, Target Page URL.
	 */

	public static function buildTargetURL($pageName='', $parametersArray = '', $folderName='') {
        global $languageDisplayInfo;
        $queryArr = Array();	
        $protocol = "";
        $query='';
        $parameters = '';
        $host = SITE_URL;

        $pagePath = $pageName;

        if($pageName!=''){
          $urlArr = parse_url($pageName);
          //pr($urlArr);
          if(is_array($urlArr) && count($urlArr)>0) {
            $pagePath = $urlArr['path'];
            if(isset($urlArr['query']) && trim($urlArr['query'])!=='') {
              $query = $urlArr['query'];
            }
            parse_str($query,$queryArr);//parse query string to comvert all the variables to array
          }
        }

        $parametersCount = count($parametersArray);
        if(isset($parametersArray) && is_array($parametersArray)&& $parametersCount > 0) {

          foreach($parametersArray as $key => $value) {
            if($value!=='') {
              if($parameters == ""){
              $parameters .='?';
              $parameters .= $key . "=".trim($value);
              }else {
                $parameters .='&amp;';
                $parameters .= $key . "=".trim($value);
              }	
            }

          }
        }

        if(isset($queryArr) && is_array($queryArr)&& count($queryArr) > 0) {
          foreach($queryArr as $key => $value) {
            if($value!=='') {
              $parameters .= '&amp;';
              $parameters .= $key . "=".trim($value);
            }
          }
		}
		
		if($pagePath==''){			
			$pathUrl =  SITE_URL."/".$_SERVER['PHP_SELF'];
		}elseif($folderName!='' && $pagePath!=''){
			$pathUrl = SITE_URL."/".$folderName."/".$pagePath;
		}else{
			$pathUrl =	$pagePath;
		}
		$targetURL = $pathUrl . $parameters;		
		return $targetURL;
	}
	
	public static function status_image($status){
		if ($status == "1") {
			$strstatusIcon = '<img src="'.IMG_PATH.'/active_icon.png" width="21" height="21" border="0" alt="'.ADM_ACTIVE.'" title="'.ADM_ACTIVE.'" />';		
		}
		else if ($status == "2") {
			$strstatusIcon = '<img src="'.IMG_PATH.'/pending_icon.png" width="21" height="21" border="0" alt="'.ADM_DELETE.'" title="'.ADM_DELETE.'" />';
		}
		else if ($status == "0") {
			$strstatusIcon = '<img src="'.IMG_PATH.'/deactivate_icon.png" width="21" height="21" border="0" alt="'.ADM_INACTIVE.'" title="'.ADM_INACTIVE.'" />';
		}
		return $strstatusIcon;
	}

	//generate random password for id
	public static function generateUniqueKey($length=12, $strength=0) {
		$vowels = '123456789';
		$consonants = 'bdghjmnpqrstvz';
		if ($strength & 1) {
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		if ($strength & 2) {
			$vowels .= "AEUY";
		}
		if ($strength & 4) {
			$consonants .= '23456789';
		}
		if ($strength & 8) {
			$consonants .= '@#$%';
		}
	 
		$uniqueKey = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$uniqueKey .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$uniqueKey .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $uniqueKey;
	}

	//generate random password for id
	public static function generateUniqueSecurityCode($length=12, $strength=0) {
		$vowels = '123456789';
		$consonants = 'bdghjmnpqrstvz';
		if ($strength & 1) {
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		if ($strength & 2) {
			$vowels .= "AEUY";
		}
		if ($strength & 4) {
			$consonants .= 'ADLASDKSADSOD';
		}

		$uniqueKey = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$uniqueKey .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$uniqueKey .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $uniqueKey;
	}
	/**
	 * Detaermines whether the value is empty or not
	 *
	 * @param $value
	 * @return  bool true or false
	 */

	public static function notEmpty($value) {
		if (isset($value) && (trim($value)!== "")) {
			return true;
		}
		else {
			return false;
		}
	}
	
	public static function makeQueryString($parametersArray){
		$parameters="";
		$parametersCount = count($parametersArray);
		if(isset($parametersArray) && is_array($parametersArray)&& $parametersCount > 0) {

			foreach($parametersArray as $key => $value) {
				if($value !='' && $key!='page'){
					if($parameters == ""){
						//$parameters .='?';
						$parameters .= $key . "=" . $value;
					}else {
						$parameters .='&';
						$parameters .= $key . "=" . $value;
					}
				}
			}
		}
		return $parameters;
	}
	
	public static function timeSelect($name,$mode,$selected) {						
		 if($mode) {
		$mode = 24;
		 } else {
		$mode = 60;
		 }
							
		 echo '<select name="'.$name.'"  class="type1 required">';
		 echo '<option value="-1">--</option>';
							
		 for ($i=0;$i<$mode;$i++) {
		  if($i <=9) {
		$i = "0".$i;
		  }
								
		  if($i == $selected) {
		echo '<option selected="selected" value="'.$i.'" >'.$i.'</option>';				
		  } else {
		echo '<option value="'.$i.'" >'.$i.'</option>';
		  }
		 }
		 echo '</select>';
	}
	
		
	public static function encrypt($sData, $sKey='mysecretkey'){ 
		$sResult = ''; 
		for($i=0;$i<strlen($sData);$i++){ 
			$sChar    = substr($sData, $i, 1); 
			$sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1); 
			$sChar    = chr(ord($sChar) + ord($sKeyChar)); 
			$sResult .= $sChar; 
		} 
		return UtilityManager::encode_base64($sResult); 
	} 

	public static function decrypt($sData, $sKey='mysecretkey'){ 
		$sResult = ''; 
		$sData   = UtilityManager::decode_base64($sData); 
		for($i=0;$i<strlen($sData);$i++){ 
			$sChar    = substr($sData, $i, 1); 
			$sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1); 
			$sChar    = chr(ord($sChar) - ord($sKeyChar)); 
			$sResult .= $sChar; 
		} 
		return $sResult; 
	} 


	public static function encode_base64($sData){ 
		$sBase64 = base64_encode($sData); 
		return strtr($sBase64, '+/', '-_'); 
	} 

	public static function decode_base64($sData){ 
		$sBase64 = strtr($sData, '-_', '+/'); 
		return base64_decode($sBase64); 
	} 
	
	
	/* DOWNLOAD PDF*/
	public static function downloadFile( $fullName,$doc_id='' ){ 
	  // Must be fresh start 
	  if( headers_sent() ) 
		die('Headers Sent'); 

	  // Required for some browsers 
	  if(ini_get('zlib.output_compression')) 
		ini_set('zlib.output_compression', 'Off'); 
		$fullPath= STORAGE_PATH."messages/" . $fullName;
	  // File Exists? 
	  if( file_exists($fullPath) ){ 
		
		// Parse Info / Get Extension 
		$fsize = filesize($fullPath); 
		$path_parts = pathinfo($fullPath); 
		$ext = strtolower($path_parts["extension"]); 
		
		// Determine Content Type 
		switch ($ext) { 
		  case "pdf": $ctype="application/pdf"; break; 
		  case "exe": $ctype="application/octet-stream"; break; 
		  case "zip": $ctype="application/zip"; break; 
		  case "doc": $ctype="application/msword"; break; 
		  case "xls": $ctype="application/vnd.ms-excel"; break; 
		  case "ppt": $ctype="application/vnd.ms-powerpoint"; break; 
		  case "gif": $ctype="image/gif"; break; 
		  case "png": $ctype="image/png"; break; 
		  case "jpeg": 
		  case "jpg": $ctype="image/jpg"; break; 
		  default: $ctype="application/force-download"; 
		} 

		header("Pragma: public"); // required 
		header("Expires: 0"); 
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
		header("Cache-Control: private",false); // required for certain browsers 
		header("Content-Type: $ctype"); 
		header("Content-Disposition: attachment; filename=\"".basename($fullPath)."\";" ); 
		header("Content-Transfer-Encoding: binary"); 
		header("Content-Length: ".$fsize); 
		ob_clean(); 
		flush(); 
		readfile( $fullPath ); 

	  } else 
		die('File Not Found'); 

	} 
	
	function checkValidDate($str) {
		$d = explode("/",$str);
		if(is_array($d) && count($d)==3) {
			if(!checkdate($d[1], $d[0], $d[2])) {
				return false;
			}
		}
		else {
			return false;
		}
		return true;
	}
	
	public static function array_random($arr, $num = 1) {
		shuffle($arr);
		
		$r = array();
		for ($i = 0; $i < $num; $i++) {
			$r[] = $arr[$i];
		}
		return $num == 1 ? $r[0] : $r;
	}
	
	//set real dates for start and end, otherwise *nix the strtotime() lines.
	//$return 'days' will return days/hours/minutes/seconds.
	//$return 'hours' will return hours/minutes/seconds.
	//$return 'minutes' will return minutes/seconds.
	//$return 'seconds' will return seconds.
	public static function timeDifference($start,$end,$return='days') {
		//change times to Unix timestamp.
		$start = strtotime($start);
		$end = strtotime($end);
			if($start > $end) {
				//return 'Please make sure the start date is less than the end date.';
			}
		//subtract dates
		$difference = $end - $start;
		$time = array();
		//calculate time difference.
		switch($return) {
			case 'days':
				 $days = floor($difference/86400);
					$difference = $difference % 86400;
					if(trim($days)!=='0') {
						$time= $days;
						break;
					}
			case 'hours':
				$hours = floor($difference/3600);
					$difference = $difference % 3600;
					if(trim($hours)!=='0') {
						$time= $hours . ' Hours';
						break;
					}
			case 'minutes':
				$minutes = floor($difference/60);
					$difference = $difference % 60;
					if(trim($minutes)!=='0') {
						$time= $minutes . ' Minutes';
						break;
					}
			case 'seconds':
				$seconds = $difference;
				if(trim($seconds)!=='0') {
					$time[]= $seconds . ' Seconds';					
				}
		}		
		return $time; 		
	}
	
	public static function getRealIpAddr() {
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
		  $ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
		  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
		  $ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	
	function createTimeDropDown($name,$selected='') {

		$optionarray=array(''=>'--Select Time--','12:00am'=>'12:00am','12:30am'=>'12:30am','1:00am'=>'1:00am','1:30am'=>'1:30am','2:00am'=>'2:00am','2:30am'=>'2:30am','3:00am'=>'3:00am','3:30am'=>'3:30am','4:00am'=>'4:00am','4:30am'=>'4:30am','5:00am'=>'5:00am','5:30am'=>'5:30am','6:00am'=>'6:00am','6:30am'=>'6:30am','7:00am'=>'7:00am','7:30am'=>'7:30am','8:00am'=>'8:00am','8:30am'=>'8:30am','9:00am'=>'9:00am','9:30am'=>'9:30am','10:00am'=>'10:00am','10:30am'=>'10:30am','11:00am'=>'11:00am','11:30am'=>'11:30am','12:00pm'=>'12:00pm','12:30pm'=>'12:30pm','1:00pm'=>'1:00pm','1:30pm'=>'1:30pm','2:00pm'=>'2:00pm','2:30pm'=>'2:30pm','3:00pm'=>'3:00pm','3:30pm'=>'3:30pm','4:00pm'=>'4:00pm','4:30pm'=>'4:30pm','5:00pm'=>'5:00pm','5:30pm'=>'5:30pm','6:00pm'=>'6:00pm','6:30pm'=>'6:30pm','7:00pm'=>'7:00pm','7:30pm'=>'7:30pm','8:00pm'=>'8:00pm','8:30pm'=>'8:30pm','9:00pm'=>'9:00pm','9:30pm'=>'9:30pm','10:00pm'=>'10:00pm','10:30pm'=>'10:30pm','11:00pm'=>'11:00pm','11:30pm'=>'11:30pm');

		$str ='<select name="'.$name.'" id="'.$name.'" class="field size3">';

		foreach($optionarray as $key=>$val) {

			$selectedOpt="";

			if($selected!=='' && $selected==$key) {

				$selectedOpt = "selected";

			}

			$str .='<option value="'.$key.'" '.$selectedOpt.'>'.$val.'</option>';

		}

		$str.='</select>';		

		return $str;

	}
	
	
	public static function getTimeDiff($dtime,$atime) {
		$nextDay=$dtime>$atime?1:0;
		$dep=explode(':',$dtime);
		$arr=explode(':',$atime);
		$timeArray =array();

		$diff=abs(mktime($dep[0],$dep[1],0,date('n'),date('j'),date('y'))-mktime($arr[0],$arr[1],0,date('n'),date('j')+$nextDay,date('y')));

		//Hour

		$hours=floor($diff/(60*60));

		//Minute 

		$mins=floor(($diff-($hours*60*60))/(60));

		//Second

		$secs=floor(($diff-(($hours*60*60)+($mins*60))));

		if(strlen($hours)<2)
		{
			$hours="0".$hours;
		}

		if(strlen($mins)<2)
		{
			$mins="0".$mins;
		}

		if(strlen($secs)<2)
		{
			$secs="0".$secs;
		}
		
		$timeArray['hours'] = $hours;
		$timeArray['mins'] = $mins;
		$timeArray['secs'] = $secs;
		//return $hours.':'.$mins.':'.$secs;
		return $timeArray;

	}
	
	public static function Slug($string) {
		return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
	}

	//generate random name for image
	public static function generateImageName($length=12, $strength=0) {
		$vowels = 'aeiou';
		$consonants = 'bdghjmnpqrstvz';
		$consonants .= '1234567890';
		$consonants .= 'aloenfjych';
		$vowels .= "iouae";
		$consonants .= '23456789';
	 
		$result = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$result .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$result .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $result;
	}

	//generate random name for image
	public static function generateFileName($length=12, $strength=0) {
		$vowels = 'aeiou';
		$consonants = 'bdghjmnpqrstvz';
		$consonants .= '1234567890';
		$consonants .= 'aloenfjych';
		$vowels .= "iouae";
		$consonants .= '23456789';
	 
		$result = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$result .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$result .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $result;
	}

	//find out the relative time
	public static function get_time_difference($created_time)
 	{
 		$script_tz = date_default_timezone_get();
        date_default_timezone_set($script_tz); //Change as per your default time
        $str = strtotime($created_time);
        $today = strtotime(date('Y-m-d H:i:s'));

        // It returns the time difference in Seconds...
        $time_differnce = $today-$str;

        // To Calculate the time difference in Years...
        $years = 60*60*24*365;

        // To Calculate the time difference in Months...
        $months = 60*60*24*30;

        // To Calculate the time difference in Days...
        $days = 60*60*24;

        // To Calculate the time difference in Hours...
        $hours = 60*60;

        // To Calculate the time difference in Minutes...
        $minutes = 60;

        if(intval($time_differnce/$years) > 1)
        {
            return intval($time_differnce/$years)." years ago";
        }else if(intval($time_differnce/$years) > 0)
        {
            return intval($time_differnce/$years)." year ago";
        }else if(intval($time_differnce/$months) > 1)
        {
            return intval($time_differnce/$months)." months ago";
        }else if(intval(($time_differnce/$months)) > 0)
        {
            return intval(($time_differnce/$months))." month ago";
        }else if(intval(($time_differnce/$days)) > 1)
        {
            return intval(($time_differnce/$days))." days ago";
        }else if (intval(($time_differnce/$days)) > 0) 
        {
            return intval(($time_differnce/$days))." day ago";
        }else if (intval(($time_differnce/$hours)) > 1) 
        {
            return intval(($time_differnce/$hours))." hours ago";
        }else if (intval(($time_differnce/$hours)) > 0) 
        {
            return intval(($time_differnce/$hours))." hour ago";
        }else if (intval(($time_differnce/$minutes)) > 1) 
        {
            return intval(($time_differnce/$minutes))." minutes ago";
        }else if (intval(($time_differnce/$minutes)) > 0) 
        {
            return intval(($time_differnce/$minutes))." minute ago";
        }else if (intval(($time_differnce)) > 1) 
        {
            return intval(($time_differnce))." seconds ago";
        }else
        {
            return "few seconds ago";
        }
  	}

  	/* DOWNLOAD Ticket files */
	public static function downloadTicketFile($fullName){ 
		// Must be fresh start 
	  	if( headers_sent() ) 
			die('Headers Sent'); 

	  	// Required for some browsers 
	  	if(ini_get('zlib.output_compression')) 
			ini_set('zlib.output_compression', 'Off');

		$fullPath= STORAGE_PATH."tickets/" . $fullName;
	  	// File Exists? 
	  	if( file_exists($fullPath) ){ 
			// Parse Info / Get Extension 
			$fsize = filesize($fullPath); 
			$path_parts = pathinfo($fullPath); 
			$ext = strtolower($path_parts["extension"]); 
			
			// Determine Content Type 
			switch ($ext) { 
				case "pdf": $ctype="application/pdf"; break; 
				case "exe": $ctype="application/octet-stream"; break; 
				case "zip": $ctype="application/zip"; break; 
				case "doc": $ctype="application/msword"; break; 
				case "xls": $ctype="application/vnd.ms-excel"; break; 
				case "ppt": $ctype="application/vnd.ms-powerpoint"; break; 
				case "gif": $ctype="image/gif"; break; 
				case "png": $ctype="image/png"; break; 
				case "jpeg": 
				case "jpg": $ctype="image/jpg"; break; 
				default: $ctype="application/force-download"; 
			} 

			header("Pragma: public"); // required 
			header("Expires: 0"); 
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
			header("Cache-Control: private",false); // required for certain browsers 
			header("Content-Type: $ctype"); 
			header("Content-Disposition: attachment; filename=\"".basename($fullPath)."\";" ); 
			header("Content-Transfer-Encoding: binary"); 
			header("Content-Length: ".$fsize); 
			ob_clean(); 
			flush(); 
			readfile( $fullPath ); 
	  	} else {
			die('File Not Found'); 
	  	}
	}

	/**
	 * Send SMS
 	*/
	public static function send_sms($phone, $message) {
		$to = str_replace("-","",$phone);
		$baseurl ="https://rest.nexmo.com/sms/json?api_key=1b441cdd&api_secret=ef7d59f91c87f7df&from=19712457818";     
		$url = $baseurl."&to=".$to."&text=".urlencode($message);
		$ret = file($url);
	}

	public static function get_remote_data($url, $post_paramtrs=false)    {
   		$c = curl_init();
   		curl_setopt($c, CURLOPT_URL, $url);
   		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
   		if($post_paramtrs){
   			curl_setopt($c, CURLOPT_POST,TRUE);
   			curl_setopt($c, CURLOPT_POSTFIELDS, "var1=bla&".$post_paramtrs );
   		}
   		curl_setopt($c, CURLOPT_SSL_VERIFYHOST,false);
   		curl_setopt($c, CURLOPT_SSL_VERIFYPEER,false);
   		curl_setopt($c, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:33.0) Gecko/20100101 Firefox/33.0");
   		curl_setopt($c, CURLOPT_COOKIE, 'CookieName1=Value;');
   		curl_setopt($c, CURLOPT_MAXREDIRS, 10);
   		$follow_allowed= ( ini_get('open_basedir') || ini_get('safe_mode')) ? false:true;
   		if ($follow_allowed){
   			curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
   		}
   		curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 9);
   		curl_setopt($c, CURLOPT_REFERER, $url);
   		curl_setopt($c, CURLOPT_TIMEOUT, 60);
   		curl_setopt($c, CURLOPT_AUTOREFERER, true);
        curl_setopt($c, CURLOPT_ENCODING, 'gzip,deflate');
        $data=curl_exec($c);
        $status=curl_getinfo($c);
        curl_close($c);
        preg_match('/(http(|s)):\/\/(.*?)\/(.*\/|)/si',  $status['url'],$link);
        $data=preg_replace('/(src|href|action)=(\'|\")((?!(http|https|javascript:|\/\/|\/)).*?)(\'|\")/si','$1=$2'.$link[0].'$3$4$5', $data);
        $data=preg_replace('/(src|href|action)=(\'|\")((?!(http|https|javascript:|\/\/)).*?)(\'|\")/si','$1=$2'.$link[1].'://'.$link[3].'$3$4$5', $data);
        if($status['http_code']==200) {
        	return $data;
        } elseif($status['http_code']==301 || $status['http_code']==302) {
        	if (!$follow_allowed){
        		if(empty($redirURL)){
        			if(!empty($status['redirect_url'])){
        				$redirURL=$status['redirect_url'];
        			}
        		}
        		if(empty($redirURL)){
        			preg_match('/(Location:|URI:)(.*?)(\r|\n)/si', $data, $m);
        			if (!empty($m[2])){
        				$redirURL=$m[2];
        			}
        		}
        		if(empty($redirURL)){
        			preg_match('/href\=\"(.*?)\"(.*?)here\<\/a\>/si',$data,$m);
        			if (!empty($m[1])){
        				$redirURL=$m[1];
        			}
        		}
        		if(!empty($redirURL)){
        			$t=debug_backtrace();
        			return call_user_func( $t[0]["function"], trim($redirURL), $post_paramtrs);
        		}
        	}
        }
        return "ERRORCODE22 with $url!!<br/>Last status codes<b/>:".json_encode($status)."<br/><br/>Last data got<br/>:$data";
    }

    //generate random password for id
	public static function generatePasswordForId($length=9, $strength=0) {
		$vowels = '12345';
		//$consonants = 'bdghjmnpqrstvz';
		$consonants = '123456789';
		if ($strength & 1) {
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		if ($strength & 2) {
			$vowels .= "AEUY";
		}
		if ($strength & 4) {
			$consonants .= '23456789';
		}
		if ($strength & 8) {
			$consonants .= '@#$%';
		}
	 
		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $password;
	}
  	
}
?>
