<?php

require("PHook.php");

use Codestaq\PHook;

 //Create an instance with the Defaults
 $ph = new PHook\PHook;

 //Simplest Hook
 $ph->say("Running Hook ...")
 	->thenRun(function(){ echo " - Do Something Here - "; })
 	->andFinallySay("Done");

 //Standard 3-Step Proccess with Colors ( Message -> Function -> Confirmation )
 $ph->say("Getting a ")->red("Cup")->plain(" of Coffee")
	->thenRun(function(){ echo " - Brewing Some Joe - ";})
	->andFinallySay("Thats Some Good Coffee");

 //Standard 4-Step Process with Colors ( Default 3 Steps + Error Message )
 $ph->say("")->clear("Running ")->red("Impossible")->clear(" Function ... ")
 	->thenRun(function(){ return false; })
 	->thenSay("It Worked")
 	->unlessFails("The Function Failed")->white(" What a Surprise")->plain(" !!")
 	->apply();

 //Hooks that only Runs on a specific Trigger Word (Trigger Hooks work with all the above formats aswell)
 $ph->onTrigger("Commit")
 	->say("The Commit Message Has The Word '")->cyan("Commit")->plain("'")
 	->withoutACommand();

 $ph->onTrigger("Second")
 	->say("The Commit Has The Word '")->cyan("Second")->plain("'")
 	->withoutACommand();

 //Just Output no Function run (Like Above)
 $ph->say("\nAll Done ")->cyan("Tests")->withoutACommand();

?>

