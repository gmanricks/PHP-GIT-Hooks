<?php
/**
* PHook
*
* @category CLI_Helper
* @package  PHook
* @author   Gabriel Manricks <gmanricks@icloud.com>
* @license  http://gmanricks.mit-license.org/ MIT License
* @link     https://github.com/gmanricks/PHP-GIT-Hooks
*/

namespace Codestaq;

class PHook
{

    /**---------- Messages ----------**/

    private $_message;
    private $_success_text;
    private $_failure_text;

    /**---------- Colors ----------**/

    private $_message_color;
    private $_success_color;
    private $_failure_color;

    /**---------- Function ----------**/

    private $_task;

    /**---------- Helpers ----------**/

    private $_started_error;
    private $_trigger_keyword;

    public function __construct($mColor = "33", $sColor = "36", $fColor = "31")
    {
        $this->_message_color = "[" . $mColor . "m";
        $this->_success_color = "[" . $sColor . "m";
        $this->_failure_color = "[" . $fColor . "m";
        $this->_message = "";
        $this->_success_text = "";
        $this->_failure_text = "";
        $this->_started_error = false;
        $this->_trigger_keyword = false;
    }

    //**---------- Functions for Messages ----------**//

    public function say($text)
    {
        if (isset($this->_task)) {
            if ($this->_started_error) {
                $this->_failure_text .= $text;
            } else {
                $this->_success_text .= $text;
            }
        } else {
            $this->_message .= $text;
        }

        return $this;
    }

    public function andFinallySay($text)
    {
        $this->_success_text .= $text;
        $this->apply();
    }

    public function thenSay($text)
    {
        return $this->say($text);
    }

    public function unlessFails($text)
    {
        $this->_started_error = true;

        return $this->say($text);
    }

    public function withoutACommand()
    {
        if ($this->_trigger_keyword === false || $this->hasTrigger()) {
            echo $this->_message_color . $this->_message . "[0m\n";
        }
        $this->resetSelf();
    }

    //**---------- All The Color Variations ----------**//

    public function clear($text)
    {
        return $this->say("[0m" . $text);
    }

    public function black($text)
    {
        return $this->say("[30m" . $text);
    }

    public function red($text)
    {
        return $this->say("[31m" . $text);
    }

    public function green($text)
    {
        return $this->say("[32m" . $text);
    }

    public function yellow($text)
    {
        return $this->say("[33m" . $text);
    }

    public function blue($text)
    {
        return $this->say("[34m" . $text);
    }

    public function magenta($text)
    {
        return $this->say("[35m" . $text);
    }

    public function cyan($text)
    {
        return $this->say("[36m" . $text);
    }

    public function white($text)
    {
        return $this->say("[37m" . $text);
    }

    public function plain($text)
    {
        $col = "[0m";
        if (isset($this->_task)) {
            $col = ($this->_started_error) ? $this->_failure_color : $this->_success_color;
        } else {
            $col = $this->_message_color;
        }

        return $this->say($col . $text);
    }

    //**---------- Run Functions ----------**//

    public function thenRun($func)
    {
        $this->_task = $func;

        return $this;
    }

    public function apply()
    {
        if ($this->_trigger_keyword === false || $this->hasTrigger()) {
            echo $this->_message_color . $this->_message . "[0m";

            $res = call_user_func($this->_task);

            if ($res === false && $this->_failure_text !== "") {
                echo $this->_failure_color . $this->_failure_text . "[0m\n";
            } else {
                echo $this->_success_color . $this->_success_text . "[0m\n";
            }

            $this->resetSelf();

            return $res;
        }

        $this->resetSelf();

        return false;
    }

    //**---------- Trigger Functions ----------**//

    public function onTrigger($tKey)
    {
        $this->_trigger_keyword = $tKey;

        return $this;
    }

    private function hasTrigger()
    {
        if ($this->_trigger_keyword !== false) {
            $msg = exec("git log -n 1 --format=format:%s%b");

            return (strpos($msg, $this->_trigger_keyword) !== false) ? true : false;
        }

        return false;
    }

    //**---------- Reset Function ----------**//

    private function resetSelf()
    {
            unset($this->_task);
            $this->_message = "";
            $this->_success_text = "";
            $this->_failure_text = "";
            $this->_started_error = false;
            $this->_trigger_keyword = false;
    }
}
