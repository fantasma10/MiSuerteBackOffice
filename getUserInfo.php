<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
        <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" >    
        <title>TEST</title>
    </head>
    <body>
		<?php
			$user_agent     =   $_SERVER['HTTP_USER_AGENT'];
			
			function getOS() { 
			
				global $user_agent;
			
				$os_platform    =   "Sistema Operativo desconocido";
			
				$os_array       =   array(
										'/windows nt 6.3/i'     =>  'Windows 8.1',
										'/windows nt 6.2/i'     =>  'Windows 8',
										'/windows nt 6.1/i'     =>  'Windows 7',
										'/windows nt 6.0/i'     =>  'Windows Vista',
										'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
										'/windows nt 5.1/i'     =>  'Windows XP',
										'/windows xp/i'         =>  'Windows XP',
										'/windows nt 5.0/i'     =>  'Windows 2000',
										'/windows me/i'         =>  'Windows ME',
										'/win98/i'              =>  'Windows 98',
										'/win95/i'              =>  'Windows 95',
										'/win16/i'              =>  'Windows 3.11',
										'/macintosh|mac os x/i' =>  'Mac OS X',
										'/mac_powerpc/i'        =>  'Mac OS 9',
										'/linux/i'              =>  'Linux',
										'/ubuntu/i'             =>  'Ubuntu',
										'/iphone/i'             =>  'iPhone',
										'/ipod/i'               =>  'iPod',
										'/ipad/i'               =>  'iPad',
										'/android/i'            =>  'Android',
										'/blackberry/i'         =>  'BlackBerry',
										'/webos/i'              =>  'Mobile'
									);
			
				foreach ($os_array as $regex => $value) { 
			
					if (preg_match($regex, $user_agent)) {
						$os_platform    =   $value;
					}
			
				}   
			
				return $os_platform;
			
			}
			
			$user_os        =   getOS();
			$device_details =   "<strong>Sistema Operativo: </strong>".$user_os."";
			
			print_r($device_details);
            
			require_once('BrowserDetection.php');
			include('inc/functions.inc.php');
            
            $browser = new BrowserDetection();
            $userBrowserName = $browser->getBrowser();
            $userBrowserVer = $browser->getVersion();
            $userPlatform = $browser->getPlatform();
            $userIECompatibilityView = $browser->getIECompatibilityView();
            $isMobile = $browser->isMobile();
			
            if ($userBrowserName == BrowserDetection::BROWSER_FIREFOX && $browser->compareVersions($userBrowserVer, '5.0.1') !== 1) {
                echo 'Est&aacute;s utilizando FireFox version 5.0.1 or mayor. ';
            }
			echo "<br />";
            echo '<strong>Navegador:</strong> ', $userBrowserName, ' ', $userBrowserVer, '';
            echo "<br />";
            echo "<strong>Plataforma:</strong> ".$userPlatform;
            echo "<br />";
            echo "<strong>&iquest;Es movil?:</strong> ";
            if ( $isMobile ) {
                echo "Yes";
            } else {
                echo "No";
            }
			echo "<br />";
			echo "<strong>Direcci&oacute;n IP:</strong> ".getIP();
			echo "<br />";
			echo "<strong>Host:</strong> ".gethostbyaddr(getIP());
		?>
    </body>
</html>