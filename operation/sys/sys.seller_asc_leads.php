<?php
    //new Field($type, $title, $name, $default_value, $query, $helper, $size, $required)
    $fields = array(
        new Field("combo", "Leads", "sys_mailing_leads_id[]", "", "SELECT *, concat('(',sys_mailing_leads_id,') ',field1_value,' - ',field2_value,' - ', field3_value) as boxvalue FROM sys_mailing_lead WHERE sys_seller_id = 0 AND sys_mailing_id='" . $_GET['id'] . "'", "Leads", 20, true, "sys_mailing_leads_id", "boxvalue", true),
        new Field("combo", "Sellers", "sys_seller_id", "", "SELECT sys_seller_id, fullname FROM sys_seller S INNER JOIN fwk_user U on U.fwk_user_id = S.fwk_user_id", "Sellers", 10, true, "sys_seller_id", "fullname")
    );

    $form = new CreateForm(@$_GET['operation'], 101, $fields);

    //debug($_POST);

    if(isset($_POST['submit']) && $_POST['submit']!="") {
        foreach($_POST['sys_mailing_leads_id'] as $fwk_operation_id) {
            if($fwk_operation_id!='') {
                $_POST['sys_mailing_leads_id'] = $fwk_operation_id;
                $form->submit("sp_mailing_lead_asc_seller");
            }
        }
    } else {
        $form->show_form();
    }

?>

