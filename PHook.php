<?php

Class PHook{
	
	//**---------- Messages ----------**//

	private $message;
	private $success_text;
	private $failure_text;

	//**---------- Colors ----------**//

	private $message_color;
	private $success_color;
	private $failure_color;

	//**---------- Function ----------**//

	private $task;

	//**---------- Helpers ----------**//

	private $started_error;

	private $trigger_keyword;


	public function __construct($mColor = "33", $sColor = "36", $fColor = "31"){
		$this->message_color = "[" . $mColor . "m";
		$this->success_color = "[" . $sColor . "m";
		$this->failure_color = "[" . $fColor . "m";
		$this->message = "";
		$this->success_text = "";
		$this->failure_text = "";
		$this->started_error = false;
		$this->trigger_keyword = false;
	}

	//**---------- Functions for Messages ----------**//

	public function say($text){
		if(isset($this->task)){
			if($this->started_error){
				$this->failure_text .= $text;
			} else {
				$this->success_text .= $text;
			}
		} else {
			$this->message .= $text;
		}
		return $this;
	}

	public function andFinallySay($text){
		$this->success_text = $text;
		$this->apply();
	}

	public function thenSay($text){
		return $this->say($text);
	}

	public function unlessFails($text){
		$this->started_error = true;
		return $this->say($text);
	}

	public function withoutACommand(){
		if($this->trigger_keyword === false || $this->hasTrigger()){
			echo $this->message_color . $this->message . "[0m\n";
		}	
		$this->resetSelf();
	}

	//**---------- All The Color Variations ----------**//

	public function clear($text){ return $this->say("[0m" . $text); }
	public function black($text){ return $this->say("[30m" . $text); }
	public function red($text){ return $this->say("[31m" . $text); }
	public function green($text){ return $this->say("[32m" . $text); }
	public function yellow($text){ return $this->say("[33m" . $text); }
	public function blue($text){ return $this->say("[34m" . $text); }
	public function magenta($text){ return $this->say("[35m" . $text); }
	public function cyan($text){ return $this->say("[36m" . $text); }
	public function white($text){ return $this->say("[37m" . $text); }
	public function plain($text){ 
		$col = "[0m";
		if(isset($this->task)){
			$col = ($this->started_error) ? $this->failure_color : $this->success_color;
		}
		else{
			$col = $this->message_color;
		}
		return $this->say($col . $text); 
	}

	//**---------- Run Functions ----------**//

	public function thenRun($func){
		$this->task = $func;
		return $this;
	}

	public function apply(){
		if($this->trigger_keyword === false || $this->hasTrigger()){
			echo $this->message_color . $this->message . "[0m";

			$res = call_user_func($this->task);

			if($res === false && $this->failure_text !== ""){
				echo $this->failure_color . $this->failure_text . "[0m\n";
			} else {
				echo $this->success_color . $this->success_text . "[0m\n";
			}

			$this->resetSelf();

			return $res;
		}

		$this->resetSelf();

		return false;
	}

	//**---------- Trigger Functions ----------**//

	public function onTrigger($tKey){
		$this->trigger_keyword = $tKey;
		return $this;
	}

	public function hasTrigger(){
		if($this->trigger_keyword !== false){
			$msg = exec("git log -n 1 --format=format:%s%b");
			return (strpos($msg, $this->trigger_keyword) !== false) ? true : false;
		}
		return false;
	}

	//**---------- Reset Function ----------**//

	private function resetSelf(){
			unset($this->task);
			$this->message = "";
			$this->success_text = "";
			$this->failure_text = "";
			$this->started_error = false;
			$this->trigger_keyword = false;
	}

} 

?>