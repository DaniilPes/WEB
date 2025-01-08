<?php
$heslo = 'b';
$hesloHash = password_hash($heslo,PASSWORD_DEFAULT);
$result = password_verify($heslo,$hesloHash);
echo $result;

?>
