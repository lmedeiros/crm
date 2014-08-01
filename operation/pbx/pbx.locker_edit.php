<?php

$back_operation_id = 75;

function load_values() {
    if (isset($_GET['id']) && $_GET['id'] != "") {
        $query = "SELECT * FROM pbx_locker WHERE pbx_locker_id = {$_GET['id']}";
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
        new Field("text", "Descrição", "description", $record['description'], "", "Descrição da Senha", 30, true),
        new Field("hidden", "Senha", "pbx_locker_id", $record['pbx_locker_id'], "", "Senha para liberar a chamada", 6, true)
    );

    $form = new CreateForm(@$_GET['operation'], $back_operation_id, $fields);
}

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_pbx_locker_update");
} else {
    $form->show_form();
}
?>
