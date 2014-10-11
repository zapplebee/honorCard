<?php
/* 
action.php

Contains classes and input handlers for interaction with the api once the user is logged in

*/



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
require('../../required.php');

class inputProcessor{

  public $username;
  public $token;
  public $data;
  public $action;
  
  private $actions = array(
  
  "updateLists",
  "getLists",
  "updateWeeklyData",
  "getWeeklyData",
  
  
  );

  function __construct(){
    
    $raw = @json_decode(file_get_contents("php://input"),true);
    if(isset($raw['action']) && in_array($raw['action'],$this->actions)){
      $this->token = $raw['token'];
      $this->action = $raw['action'];
      $this->username = cardDecrypt($raw['token']);

      if (isset($raw['data'])){
        // hacky, but this quickly checks if the data that was posted is a single value or a json object;
        $this->data = @json_decode($raw['data'],true);
      
        if($this->data === NULL){
          $this->data = $raw['data'];
        }

      } else {
        unset($this->data);
      }
      
      
    }else{
  
      // this exit is called if the token is not set or the actions is not in the authorized list or the post data is malformed.
      exit();
  
    }
    
    
  
  }
  


}
