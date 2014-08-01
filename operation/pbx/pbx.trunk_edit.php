<?php
error_reporting(-1);
error_reporting(E_ALL);

    $back_operation_id = 41;

    function load_values() {
        if (isset($_GET['id']) && $_GET['id'] != "") {
            $query = "SELECT * FROM pbx_peer_sip WHERE id = {$_GET['id']}";
            $record = $GLOBALS['db']->selectAll($query);
            if(isset($record[0])) {
                return $record[0];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    $record = load_values();
    if(!$record){
        Header("Location: ?operation={$back_operation_id}");
    } else {
    $fields = array(
    //new Field("text", "Name", "name", $record['name'], "", "Trunk name, reffered on pbx dialplan", 30, true),
    new Field("text", "User", "user", $record['defaultuser'], "", "VoIP Account Trunk Username", 40, true),
    new Field("text", "Server Address", "host", $record['host'], "", "VoIP Account Server Name/Address", 40, true),
    new Field("password", "VoIP Trunk Password", "secret", $record['secret'], "", "VoIP Account password", 30, false),
    new Field("combo", "Transport Type", "transport", $record['transport'], "SELECT * FROM aux_sip_transport", "Encrypt Signaling", 3, true, "type", "type", true),
    new Field("combo", "Use SRTP?", "encryption", $record['encryption'], "SELECT * FROM aux_bool", "Encrypt audio", 2, true, "name", "name", true),
    new Field("text", "Network Port", "port", $record['port'], "", "Set network port", 5, true),
    new Field("hidden", "", "id", $record['id'], "", "", 0, true),
    new Field("hidden", "", "old", $record['name'], "", "",0, true)
    );

        $form = new CreateForm(@$_GET['operation'], $back_operation_id, $fields);
    }

    if (isset($_POST['submit']) && $_POST['submit'] != "") {
        $form->submit("sp_pbx_trunk_update");
    	 create_reg($_POST['user'], $_POST['secret'], $_POST['host']);
    } else {
        $form->show_form();
    }
    function create_reg($user, $password, $server) {
	    system("rm -rf /etc/asterisk/sip.registrations/".$_POST['old'].".conf");
	    $regfile = "/etc/asterisk/sip.registrations/".$_POST['old'].".conf";
	    $filehandler = fopen($regfile, 'w') or die("error creating reg file");
	    $regline = "register=>".$user.":".$password."@".$server;
	    fwrite($filehandler, $regline) or die("error writing reg file");	
	    fclose($filehandler);
    }

?>
