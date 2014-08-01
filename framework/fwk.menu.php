<?php
    class Menu {
        function __construct(){
            //$this->write_menu_title();
           
           
            echo "<div style='width: 20px; height: 50px; float: left;'></div>\n"; 
            echo "<ul class='dropdown'>\n";
                $this->write_menu_item(1,false);
                echo "\n\t<ul class='sub_menu'>\n";
                     $this->write_submenu_item(5,false);
                     $this->write_submenu_item(6,false);
                     $this->write_submenu_item(7,false);
                     $this->write_submenu_item(13,false);
                     $this->write_submenu_item(14,false);
                     $this->write_submenu_item(19,false);
                echo "\t</ul>\n</li>\n";
                
                $this->write_menu_item(107,false);
                echo "\n\t<ul class='sub_menu'>\n";
		     $this->write_submenu_item(107,false);
                     $this->write_submenu_item(102,false);
	     	echo "\t</ul>\n</li>\n";
                
                $this->write_menu_item(101,false);
                echo "\n\t<ul class='sub_menu'>\n";
                     $this->write_submenu_item(101,false);
                     $this->write_submenu_item(100,false);
		echo "\t</ul>\n</li>\n";

                $this->write_menu_item(109,false);
                echo "\n\t<ul class='sub_menu'>\n";
                     $this->write_submenu_item(109,false);
                echo "\t</ul>\n</li>\n";

	    echo "</ul>\n";
        }

        private function write_menu_title() {
           echo "<div class='menu_title'><span class='menu_title'>".system_name."</span></div>";
        }

        private function write_menu_item($fwk_operation_id, $is_link) {
            $operation = $this->load_operation_menu_item($fwk_operation_id);
            if($operation) {
                echo "\t\t<li>";
                echo "<a style='font-size: 14px;' href='?operation=" .$operation['fwk_operation_id'] . "'>";
                echo ($operation['name']);
                echo "</a>";
              
            }
        }
        
        private function write_submenu_item($fwk_operation_id, $is_link) {
            $operation = $this->load_operation_menu_item($fwk_operation_id);
            if($operation) {
                echo "\t\t<li>";
                echo "<a href='?operation=" .$operation['fwk_operation_id'] . "'>";
                echo "<img src='framework/fwk.image_load.php?id={$fwk_operation_id}' style='margin-top: 1px; width: 12px; height: 12px; margin-right: 8px;' /> ";
                echo ($operation['name']);
                echo "</a>";
                echo "</li>\n";
            }
        }

        private function load_operation_menu_item($fwk_operation_id) {
            $operation = $GLOBALS['controller']->load_operation($fwk_operation_id);

            if(isset($operation) && $operation!="FORBIDDEN" && $operation!="NOT_FOUND") {
                return $operation;
            } else {
                return false;
            }
        }
    }

?>
