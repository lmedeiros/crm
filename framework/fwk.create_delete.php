<?php

class CreateDelete {

    private $back_operation_id;
    private $record_id;
    private $back_operation_param;
    private $user_id;
    private $param;

    function __construct($back_operation_id, $record_id, $param=false) {
        if(is_array($back_operation_id)) {
                $this->back_operation_id = current($back_operation_id);
		$this->back_operation_param = key($back_operation_id);
        } else {
                $this->back_operation_id = $back_operation_id;
        }
	$this->param = $param;
        $this->record_id = $record_id;
        $this->user_id = $_SESSION[session_key];
    }

    public function delete($procedure, $log = true) {
        if($this->param==false) {
            $sql = "CALL {$procedure} ({$this->record_id})";
        } else {
            $sql = "CALL {$procedure} ({$this->record_id}, '{$this->param}')";
        }
        $command = $GLOBALS['db']->command($sql);

        if (@is_numeric($command)) {
            $success = 1;
            if ($log == true) {
                $GLOBALS['db']->command("INSERT INTO fwk_log SET fwk_operation_id='" . $_GET["operation"] . "', fwk_user_id={$this->user_id}, log='" . addslashes($sql) . "', is_success={$success}, type='delete'");
            }
            echo '<script type="text/javascript">';
	    if($this->back_operation_param=='') {
	    	echo 'window.location = "?operation=' . $this->back_operation_id . '"';
            } else {
		echo 'window.location = "?operation=' . $this->back_operation_id . '&' . $this->back_operation_param . '"';	
	    }
	    echo '</script>';
            return;
        } else {
            $success = 0;
            @message(error, "Error, not manage to delete the record: " . @$command->getMessage());
            if ($log == true) {
                $GLOBALS['db']->command("INSERT INTO fwk_log SET fwk_operation_id='" . $_GET["operation"] . "', fwk_user_id={$this->user_id}, log='" . addslashes($sql) . "', is_success={$success}, type='delete'");
            }
            return;
        }
    }

}

?>
