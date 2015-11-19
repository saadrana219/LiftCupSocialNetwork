<?php

if(!class_exists('Soashal')){
	class Soashal {
		
		function register($redirect) {
			global $jdb;


			$current = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];


			$referrer = $_SERVER['HTTP_REFERER'];


			if ( !empty ( $_POST ) ) {
                          
                          global $p;
                          require_once('put.php');

                          $p->postelastic();

                                if ( $referrer == $current ) {
				

					require_once('s_db.php');


					$table = 't_users';
					

					$fields = array('user_name', 'user_login', 'user_pass', 'user_email', 'user_registered', 'user_profession', 'user_phone');
					

					$values = $jdb->clean($_POST);


					$username = $_POST['name'];
					$userlogin = $_POST['username'];
					$userpass = $_POST['password'];
					$useremail = $_POST['email'];
					$userreg = $_POST['date'];
					$userprof = $_POST['profession'];
					$userphone = $_POST['phone'];


					$nonce = md5('registration-' . $userlogin . $userreg . NONCE_SALT);
					

					$userpass = $jdb->hash_password($userpass, $nonce);


					$values = array(
								'name' => $username,
								'username' => $userlogin,
								'password' => $userpass,
								'email' => $useremail,
								'date' => $userreg,
								'profession' => $userprof,
								'phone' => $userphone

							);
					
                                        $link = $jdb->connect();
                                        echo $link;
					$insert = $jdb->insert($link, $table, $fields, $values);
					
					if ( $insert == TRUE ) {
						$url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
						$aredirect = str_replace('register.php', $redirect, $url);
						
						header("Location: $redirect?reg=true");
						exit;
					}
				} else {
					die('Your form submission did not come from the correct page. Please check with the site administrator.');
				}
			}
		}
		
		function login($redirect) {
			global $jdb;
		
			if ( !empty ( $_POST ) ) {
				

				$values = $jdb->clean($_POST);


				$subname = $values['username'];
				$subpass = $values['password'];


				$table = 't_users';


				$sql = "SELECT * FROM $table WHERE user_login = '" . $subname . "'";
				$results = $jdb->select($sql);


				if (!$results) {
					die('Sorry, that username does not exist!');
				}


				$results = mysql_fetch_assoc( $results );
				

				$storeg = $results['user_registered'];


				$stopass = $results['user_pass'];


				$nonce = md5('registration-' . $subname . $storeg . NONCE_SALT);


				$subpass = $jdb->hash_password($subpass, $nonce);


				if ( $subpass == $stopass ) {
					

					$authnonce = md5('cookie-' . $subname . $storeg . AUTH_SALT);
					$authID = $jdb->hash_password($subpass, $authnonce);
					

					setcookie('soashallogauth[user]', $subname, 0, '', '', '', true);
					setcookie('soashallogauth[authID]', $authID, 0, '', '', '', true);
					

					$url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
					$redirect = str_replace('login.php', $redirect, $url);
					

					header("Location: $redirect");
					exit;	
				} else {
					return 'invalid';
				}
			} else {
				return 'empty';
			}
		}
		
		function logout() {

			$idout = setcookie('soashallogauth[authID]', '', -3600, '', '', '', true);
			$userout = setcookie('soashallogauth[user]', '', -3600, '', '', '', true);
			
			if ( $idout == true && $userout == true ) {
				return true;
			} else {
				return false;
			}
		}
		
		function checkLogin() {
			global $jdb;
			$cookie = $_COOKIE['soashallogauth'];

                        $results = false;
			$user = $cookie['user'];
			$authID = $cookie['authID'];
			

			if ( !empty ( $cookie ) ) {
				$table = 't_users';
				$sql = "SELECT * FROM $table WHERE user_login = '" . $user . "'";
				$results = $jdb->select($sql);
				if (!$results) {
					die('Sorry, that username does not exist!');
				}
				$results = mysql_fetch_assoc( $results );
				$storeg = $results['user_registered'];
				$stopass = $results['user_pass'];
				$authnonce = md5('cookie-' . $user . $storeg . AUTH_SALT);
				$stopass = $jdb->hash_password($stopass, $authnonce);
				
				if ( $stopass == $authID ) {
					$results = true;
				} else {
					$results = false;
				}
		        }else{
                              $url = "http" . ((!empty($_SERVER['HTTPS'])) ? "s" : "") . "://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
                    	      $redirect = str_replace('index.php', 'login.php', $url);
                              //echo $url;
                              //echo $redirect;
                              //header("Location: $redirect?msg=login");
                              header("Location: $redirect"."login.php");
                              exit;
                        }
                       return $results;
	}
}
  }
$j = new Soashal;
?>