<?
/* global $si; */

foreach($si->SELECT([], "users") as $s){
  echo $a[0]["id"];
}
