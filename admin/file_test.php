<?php


$test_fp  =   fopen('file_test.txt','w+');

function  test_dump($tst){

  global $test_fp ;

  fwrite($test_fp,$tst."\n");

  echo "after commit before push<br>";
  echo "change identified<br>";
  echo "master";

  return ;

}