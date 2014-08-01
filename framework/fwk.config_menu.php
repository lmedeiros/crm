<?php
    class ConfigMenu {
        function __construct(){
            if(isset($_SESSION[SESSION_KEY]) && $_SESSION[SESSION_KEY] != "") {
                $user = $this->load_user($_SESSION[SESSION_KEY]);
                if($user) {
                    $this->write_config_menu($user['login']);
                } else {
                    return false;
                }
            }
        }

        private function write_config_menu($fullname) {
           $name = explode(" ", $fullname);
           echo "<p style='color:red; margin: 2px 3px 0px 3px; font-size: 14px;'>" . ucfirst($name[0]) . "</p>";
	   echo "<p style='margin: 0px 3px 2px 3px; font-size: 11px;'> <a href='framework/fwk.exit.php'>[Logout]</a></p>";
        }


        private function load_user($fwk_user_id) {
            $user = $GLOBALS['db']->selectAll("SELECT DISTINCT * FROM fwk_user WHERE fwk_user_id={$fwk_user_id}");
       
            if(isset($user[0])) {
                return $user[0];
            }
            return false;
        }
    }

?>
