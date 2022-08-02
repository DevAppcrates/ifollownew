<?php

return array(

    'driver' => 'smtp',
    'host' => 'mail.ifollow.com',
    'port' => 587,
    'from' => array(
        'address' => 'alert@ifollow.com',
        'name' => 'iFollow-Contact Center'
    ),
    'encryption' => 'tls',
    'username' => 'alert@ifollow.com',
    'password' =>'Abcd!234',
    'sendmail' => '/usr/sbin/sendmail -bs',
    'pretend' => false,


);
