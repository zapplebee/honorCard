<?php
/* 
action.php

Contains classes and input handlers for interaction with the api once the user is logged in

*/



/*
../../required.php

Contains variables:

  $mySQLserver      / The string used to instantiate a PDO connection with the server
  $mySQLuser        / self explanitory
  $mySQLpass        / ditto
  $encryptionKey    / the encrytion key used to generate user tokens

*/
require('../../required.php');
