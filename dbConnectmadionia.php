<?php
 define('HOST','localhost');
 define('USER','root');
 define('PASS','2531588');
 define('DB','GCWW_db');
 
 $con = mysqli_connect(HOST,USER,PASS,DB) or die('Unable to Connect');