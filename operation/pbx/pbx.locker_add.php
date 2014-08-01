<?php

//new Field($type, $title, $name, $default_value, $query, $helper, $size, $required)
$fields = array(
    new Field("text", "Descrição", "description", "", "", "Descrição da Senha", 30, true),
    new Field("text", "Senha", "pbx_locker_id", "", "", "Senha para liberar a chamada", 6, true)
);

$form = new CreateForm(@$_GET['operation'], 75, $fields);

//debug($_POST);

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_pbx_locker_insert");
} else {
    $form->show_form();
}

?>