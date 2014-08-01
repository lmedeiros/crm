<?php 

new CreateHome(@$_GET['operation'], array(0),101); ?>

<div style="float:left;" width="900px;">
        <table class='form'>
		<form enctype="multipart/form-data" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
           		<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
            		<tr>
				<td>Description</td>
				<td><input type="text" name='description' id="description" /></td>
			</tr>
            		<tr>
				<td>CSV File</td>
				<td><input name="userfile[]" type="file"/></td>
			</tr>
		        <tr>
				<td class="submit"><input class='submit' type='submit' value="Upload" /></td>
				<td class="submit"><input class="cancel" type='button' onclick='history.go(-1)' value='Cancel' /></td>
			</tr>
        	</form>
	</table>
</div>

<?php
ini_set('auto_detect_line_endings', 1);
// check if a file was submitted
if (isset($_FILES['userfile']) && isset($_POST['description']) && $_POST['description']!='' && $_FILES['userfile']!='' && isset($_POST['MAX_FILE_SIZE']))  {
    try {
        upload();
        // give praise and thanks to the php gods
        echo '<p>OK, mailing has been uploaded.</p>';
        //Header("Location: ?operation=101");
    } catch (Exception $e) {
        echo $e->getMessage();
        echo 'Sorry, could not upload file';
    }
} else {
    //echo 'Sorry, could not upload file';
}

function upload() {

    $tmpname = $_FILES['userfile']['tmp_name'][0];

    if (is_uploaded_file($tmpname)) {

        //$csvfile = file_get_contents($tmpname);
        $size = filesize($tmpname);
	$array_csv = array();
	$titles = array();
	$fields_sql = '';
	$titles_sql = '';
	$row = 1;
	if (($handle = fopen($tmpname, "r")) !== FALSE) {
    		while (($data = fgetcsv($handle, 1000, ",", '"')) !== FALSE) {
        		$num = count($data);
			if($row==1) {
                        	for ($c=0; $c < $num; $c++) {
                                	$titles[$row][] = str_replace('"','',$data[$c]);
                        	} 
			} else {			
      				for ($c=0; $c < $num; $c++) {
					$array_csv[$row][] = $data[$c];
				}
			}
	    		$row++;	
		}
    		fclose($handle);
	}

	foreach($titles as $title) {
                for($i=0 ; $i < count($title) ; $i++) {
                        $titles_sql = $titles_sql . " field" . ($i+1) . "_name='{$title[$i]}', ";
                }
        }

	$GLOBALS['db']->command("INSERT INTO 
					sys_mailing 
					SET 
						description='" . $_POST['description'] . "', 
						filename='" . basename($_FILES['userfile']['name'][0]) . "', 
						total_records='" . ($row-1) . "', "
						 . substr($titles_sql, 0, -2));
	
	$mailing_id =  $GLOBALS['db']->selectRow("SELECT LAST_INSERT_ID() AS ID");
	
	foreach($array_csv as $row) {
		for($i=0 ; $i < count($row) ; $i++) {
			$fields_sql = $fields_sql . " field" . ($i+1) . "_value='{$row[$i]}', ";
		}
		$GLOBALS['db']->command("INSERT INTO sys_mailing_lead SET sys_mailing_id='" . $mailing_id['ID'] . "', " . substr($fields_sql, 0, -2));
		$fields_sql = "";
	}	
    }
}
