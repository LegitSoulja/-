<?
/* global $si; */

foreach($si->SELECT([], "users") as $s){
  echo $s["id"];
}
