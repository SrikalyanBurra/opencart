<?php


$test_fp  =   fopen('file_test.txt','w+');

function  test_dump($tst){

  global $test_fp ;

  fwrite($test_fp,$tst."\n");

  return ;

}