<?php
     class Get {
             function getelastic() {

                     $search_host = 'localhost';
                     $search_port = '9200';
                     $index = '_search';
                     
                     $baseUri = 'http://'.$search_host.':'.$search_port.'/'.$index;
                     $ci = curl_init();
                     curl_setopt($ci, CURLOPT_URL, $baseUri);
                     curl_setopt($ci, CURLOPT_PORT, $search_port);
                     curl_setopt($ci, CURLOPT_TIMEOUT, 200);
                     curl_setopt($ci, CURLOPT_RETURNTRANSFER, 1);
                     curl_setopt($ci, CURLOPT_FORBID_REUSE, 0);
                     curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'GET');
                     $response = curl_exec($ci);
                     $x = (string)$response;
                     #echo gettype($x);
                     $y = json_decode($x,true);
                     $ourhits = print_r($y["hits"]["hits"]);
                     foreach ($ourhits as $x){
                             print_r($x);
                     }
                     #echo var_dump($y);
                     #print_r( $y['name']);


             }
     }

     $g = new Get;

     $g->getelastic();
?>