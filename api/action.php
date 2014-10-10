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
