<?php //signup.php
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


  $email = cardEncrypt($credentials['email']);

  
  

  $db = new PDO($mySQLserver, $mySQLuser, $mySQLpass);
  
  //print_r($credentials);
  
  $stmt = $db->prepare('INSERT INTO `users` (`username`,`password`,`email`,`token`) VALUES (:username, :password, :email, :token)');
  $stmt->bindParam(':username',$username);
  $stmt->bindParam(':password',$password);
  $stmt->bindParam(':email',$email);
  $stmt->bindParam(':token',$token);
  $stmt->execute();
  if($stmt->rowCount() === 0){
    
    $failed = array("failed"=>"That username exists");
    
    
    echo json_encode($failed);
  
  }
  else{
  
    $tokenArray = array("token"=>$token);
    echo json_encode($tokenArray);
  
  }
  
  



?>