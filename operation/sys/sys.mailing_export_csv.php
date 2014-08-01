<?php 
header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=mailing_" . $_GET['id'] . "_" . date("y-m-d",time()) . ".csv");
header("Pragma: no-cache");
header("Expires: 0");

require("../../framework/fwk.config.php");
require("../../framework/fwk.database.php");
require("../../framework/fwk.function.php");

$titles = $GLOBALS['db']->selectRow("SELECT * FROM sys_mailing WHERE sys_mailing_id='" . $_GET['id'] . "'");

$array = $GLOBALS['db']->selectAll("SELECT '".$titles['field1_name']."','".$titles['field2_name']."','".$titles['field3_name']."','".$titles['field4_name']."','".$titles['field5_name']."','".$titles['field6_name']."','".$titles['field7_name']."','".$titles['field8_name']."','updated','loaded_on','mailing_id','seller_id','update_info','update_seller_id','update_date' UNION 
SELECT 
    L.field1_value as field1,
    L.field2_value as field2,
    L.field3_value as field3,
    L.field4_value as field4,
    L.field5_value as field5,
    L.field6_value as field6,
    L.field7_value as field7,
    L.field8_value as field8,
    L.is_worked AS updated,
    L.date_insert as loaded_on,
    L.sys_mailing_id as mailing_id,
    L.sys_seller_id as seller_id,
    U.description as update_info,
    U.sys_seller_id as update_seller_id,
    U.date_insert as update_date
    FROM 
        sys_mailing_lead L 
    LEFT JOIN 
        sys_lead_update U 
    ON 
        U.sys_mailing_lead_id = L.sys_mailing_leads_id 
WHERE
    L.sys_mailing_id = ".$_GET['id']);

outputCSV($array);

function outputCSV($data) {
    $outstream = fopen("php://output", "w");
    function __outputCSV(&$vals, $key, $filehandler) {
	ini_set('auto_detect_line_endings', 1);
     fputcsv($filehandler, $vals); // add parameters if you want
    }
    array_walk($data, "__outputCSV", $outstream);
    fclose($outstream);
}

?>
