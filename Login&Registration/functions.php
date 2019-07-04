<?php

function SendThisMail($to, $subject,$message){

    // To send HTML mail, the Content-type header must be set
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';
    // Additional headers
    // $headers[] = 'From: Sender Name/ Title for Sendrr <email id of sender inside this angular brackets>';
    // $headers[] = 'Cc: email id';
    // $headers[] = 'Bcc: email id';

    if (mail($to, $subject, $message, implode("\r\n", $headers))){
        return true;
    }else{
        return false;
    }


}