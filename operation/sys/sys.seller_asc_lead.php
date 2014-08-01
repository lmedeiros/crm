<?php
    //new Field($type, $title, $name, $default_value, $query, $helper, $size, $required)
    $fields = array(
        new Field("combo", "Leads", "sys_mailing_leads_id[]", $_GET['lead_id'], "SELECT *, concat('(',sys_mailing_leads_id,') ',field1_value,' - ',field2_value,' - ', field3_value) as boxvalue FROM sys_mailing_lead WHERE sys_mailing_leads_id='" . $_GET['lead_id'] . "'", "Leads", 2, false, "sys_mailing_leads_id", "boxvalue", false),
        new Field("combo", "Sellers", "sys_seller_id", "", "SELECT sys_seller_id, fullname FROM sys_seller S INNER JOIN fwk_user U on U.fwk_user_id = S.fwk_user_id UNION SELECT '0' as sys_seller_id,'DEALLOCATE' as fullname", "Sellers", 10, true, "sys_seller_id", "fullname")
    );

    $back_operation_id = array('id='.$_GET['mailing_id'].'&user_id='.$_GET['seller_id']=>111);

    $form = new CreateForm(@$_GET['operation'], $back_operation_id, $fields);

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

