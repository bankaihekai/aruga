<?php

    $connect = new mysqli($host='localhost',$user='root',$pass='',$db='aruga');

    if($connect->connect_error){
        die("Connection Error! ".$connect->connect_error);
    }
    else{
        //do nothing
        // echo "Connection is Good";
    }
