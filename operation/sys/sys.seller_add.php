<?php
$back_operation_id = 102;

//new Field($type, $title, $name, $default_value, $query, $helper, $size, $required)
$fields = array(
    new Field("combo", "System User", "fwk_user_id", "", "SELECT * FROM fwk_user WHERE fwk_user_id NOT IN (SELECT fwk_user_id FROM sys_seller)", "System user to act as a seller", 7, true, "fwk_user_id", "fullname", false),
);

$form = new CreateForm(@$_GET['operation'], $back_operation_id, $fields);

//debug($_POST);

if (isset($_POST['submit']) && $_POST['submit'] != "") {
    $form->submit("sp_sys_seller_add");
} else {
    $form->show_form();
}

?>

