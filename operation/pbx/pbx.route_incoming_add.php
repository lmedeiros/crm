<?php

//new Field($type, $title, $name, $default_value, $query, $helper, $size, $required)
$fields = array(
    new Field("text", "Descrição", "name", "", "", "Trunk name, reffered on pbx dialplan", 30, true),
    new Field("text", "Número", "exten", "", "", "VoIP Account Trunk Username", 40, true),
    new Field("combo", "Conta", "pbx_account_id", "", "SELECT * FROM pbx_account", "Conta para Direcionar", 1, true, "pbx_account_id", "pbx_account_id", false),
    new Field("combo", "Tronco", "pbx_peer_sip_id", "", "SELECT * FROM pbx_peer_sip WHERE host !='dynamic' order by name", "Tronco de entrada", 10, true, "name", "name", false)
);

$form = new CreateForm(@$_GET['operation'], 86, $fields);

//debug($_POST);

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_pbx_route_incoming_insert");
    create_reg($_POST['pbx_peer_sip_id'], $_POST['pbx_account_id'], $_POST['exten']);
} else {
    $form->show_form();
}

function create_reg($trunk, $user, $number) {
	$regfile = "/etc/asterisk/sip.registrations/".$trunk.".conf";
        $filehandler = fopen($regfile, 'a') or die("error creating reg file");
        $regline = "/".$user;
	fwrite($filehandler, $regline) or die("error writing reg file");
	fclose($filehandler);
}

?>
