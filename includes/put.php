<?php

class Put {

      function postelastic() {

               $search_host = 'localhost';
               $search_port = '9200';
               $index = 'user_stor';
               $doc_type = 'user_base';


      if ( !empty ( $_POST ) ) {
                               
                               global $jdb;

                               require_once('s_db.php');

                               $postData = $jdb->clean($_POST);

                               $username = $_POST['name'];
                               $userlogin = $_POST['username'];
                               $useremail = $_POST['email'];
                               $userprof = $_POST['profession'];
                               $userphone = $_POST['phone'];

                               $postData = array(
                                                 'name' => $username,
			                         'username' => $userlogin,
			                         'email' => $useremail,
			                         'profession' => $userprof,
			                         'phone' => $userphone
                                                 );
                               $postData = json_encode($postData);

                               $baseUri = 'http://'.$search_host.':'.$search_port.'/'.$index.'/'.$doc_type;
                               
                               //.'/'.$doc_id;

                               $ci = curl_init();
                               curl_setopt($ci, CURLOPT_URL, $baseUri);
                               curl_setopt($ci, CURLOPT_PORT, $search_port);
                               curl_setopt($ci, CURLOPT_TIMEOUT, 200);
                               curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);
                               curl_setopt($ci, CURLOPT_FORBID_REUSE, 0);
                               curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'POST');
                               curl_setopt($ci, CURLOPT_POSTFIELDS, $postData);
                               $response = curl_exec($ci);
                               }

                           }
         }
$p = new Put;
?>