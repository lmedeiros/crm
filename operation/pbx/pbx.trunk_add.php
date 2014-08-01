<?php

//new Field($type, $title, $name, $default_value, $query, $helper, $size, $required)
$fields = array(
    new Field("text", "Name", "name", "", "", "Trunk name, reffered on pbx dialplan", 30, true),
    new Field("text", "User", "user", "", "", "VoIP Account Trunk Username", 40, true),
    new Field("text", "Server Address", "host", "", "", "VoIP Account Server Name/Address", 40, true),
    new Field("password", "VoIP Trunk Password", "secret", "", "", "VoIP Account password", 30, true),
    new Field("combo", "Transport Type", "transport", "", "SELECT * FROM aux_sip_transport", "Encrypt Signaling", 3, true, "type", "type", true),
    new Field("combo", "Use SRTP?", "encryption", "", "SELECT * FROM aux_bool", "Encrypt audio", 2, true, "name", "name", true),
    new Field("text", "Network Port", "port", "5060", "", "Set network port", 5, true),
);

$form = new CreateForm(@$_GET['operation'], 41, $fields);

//debug($_POST);

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_pbx_trunk_insert");
    create_reg($_POST['user'], $_POST['secret'], $_POST['host']);
} else {
    $form->show_form();
}

function create_reg($user, $password, $server) {
	system("rm -rf /etc/asterisk/sip.registrations/". $_POST['name'] .".conf");
	$regfile = "/etc/asterisk/sip.registrations/". $_POST['name'] .".conf";
        $filehandler = fopen($regfile, 'w') or die("error creating reg file");
        $regline = "register=>".$user.":".$password."@".$server;
	fwrite($filehandler, $regline) or die("error writing reg file");
	fclose($filehandler);
}

?>
