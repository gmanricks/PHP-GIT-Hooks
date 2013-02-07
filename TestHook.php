
<?php

require("PHook.php");

$ph = new PHook;

$ph->say("Getting a ")->red("Cup")->plain(" of Coffee")->thenRun(function(){
	echo " - Brewing Some Joe - ";
})->andFinallySay("Thats Some Good Coffee");

$ph->say("")->clear("Running ")->red("Impossible")->clear(" Function ... ")->thenRun(function(){ return false; })->thenSay("It Worked")->unlessFails("The Function Failed")->white(" What a Surprise")->plain(" !!")->apply();

?>

