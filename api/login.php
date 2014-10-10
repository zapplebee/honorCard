<?php //login.php
  require('../../required.php');
  
    /*
    ../../required.php

    Contains variables and functions:

      $mySQLserver                     / The string used to instantiate a PDO connection with the server
      $mySQLuser                       / self explanitory
      $mySQLpass                       / ditto
      function hashPassword($input)    / salts and hashes the password
      function cardEncrypt($value)     / creates and encrypted token
      function cardDecrypt($value)     / decrypts token

    */
  
  $credentials = json_decode(file_get_contents("php://input"),true);
  $username = $credentials['username'];
  $password = hashPassword($credentials['password']);
  $token = cardEncrypt($credentials['username']);

  $db = new PDO($mySQLserver, $mySQLuser, $mySQLpass);
  
  $stmt = $db->prepare('UPDATE `users` SET `token` = :token WHERE `username` = :username AND `password` = :password');
  $stmt->bindParam(':token', $token);
  $stmt->bindParam(':username', $username);
  $stmt->bindParam(':password', $password);
  $stmt->execute();
  if($stmt->rowcount() === 1){
  
    echo json_encode(array("token" => $token));
  
  }




?>