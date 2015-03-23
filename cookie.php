<?php 
	header("Content-type: text/html; charset=windows-1251");
	if ($login != 'admin'  && $login != @$_COOKIE["active1"] && $login != @$_COOKIE["active2"] && $login != @$_COOKIE["active3"] && $login != @$_COOKIE["active4"] && $login != @$_COOKIE["active5"]) {
	if (isset($_COOKIE["active1"])) {
		if (isset($_COOKIE["active2"])) {
			if (isset($_COOKIE["active3"])) {
					if (isset($_COOKIE["active4"])) {
						if (isset($_COOKIE["active5"])) {
							SetCookie("active5","",time()-604800);
							SetCookie("active5",$_COOKIE["active4"],time()+604800);
							SetCookie("active4","",time()-604800);
							SetCookie("active4",$_COOKIE["active3"],time()+604800);
							SetCookie("active3","",time()-604800);
							SetCookie("active3",$_COOKIE["active2"],time()+604800);
							SetCookie("active2","",time()-604800);
							SetCookie("active2",$_COOKIE["active1"],time()+604800);
							SetCookie("active1","",time()-604800);
							SetCookie("active1",$login,time()+604800);
						}
						else SetCookie("active5",$login,time()+604800);
					}
					else SetCookie("active4",$login,time()+604800);
				}
				else SetCookie("active3",$login,time()+604800);
			}
			else SetCookie("active2",$login,time()+604800);
		}
		else SetCookie("active1",$login,time()+604800);
	}
?>
					
							
						
							