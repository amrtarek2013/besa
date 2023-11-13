<?php
namespace MobileValidator\classes;


class blocked_number {

    public $id;
    public $blocked_number;
    public $tag1;
    var $Errors;

    public function SetValues($_id, $_blocked_number, $_tag1) {

        $this->blocked_number = $_blocked_number;
        $this->tag1 = $_tag1;
    }

    public function SelectFromDB($_id) {
        global $db;
        if (!ereg("^([0-9]+)$", $_id)) {
            $this->Errors[] = _lang(invalid_id);
            return false;
        }
        $this->id = $_id;
        $sql = 'SELECT * FROM `blocked_number` WHERE `id` = ' . $_id;
        if (!($result = $db->sql_query($sql))) {
            $this->Errors[] = $db->sql_error_msg($result);
            return false;
        }

        if ($db->sql_numrows($result) < 1) {
            $this->Errors[] = _lang(no_blocked_number_found);
            return false;
        }

        $row = $db->sql_fetchrow($result);
        $this->blocked_number = $row['blocked_number'];
        $this->tag1 = $row['tag1'];
        return true;
    }

    public function Insert() {
        global $db;
        $sql = 'INSERT INTO `blocked_number` (`blocked_number`,  `tag1`) VALUES (\'' . PreSql($this->blocked_number) . '\',  \'' . PreSql($this->tag1) . '\')';
        if (!$db->sql_query($sql)) {
            $this->Errors[] = $db->sql_error_msg($result);
            return false;
        }

        return $db->sql_nextid();
    }

    public function Add() {
        $op = 'Add';
        include 'forms/fblocked_number.php';
    }

    public function Delete() {
        global $db;

        $sql = 'DELETE FROM `blocked_number` WHERE `id`=' . $this->id;
        if (!$db->sql_query($sql)) {
            $this->Errors[] = $db->sql_error_msg($result);
            return false;
        }

        return true;
    }

    public function Edit($_op = 'Update') {
        $id = PreForm($this->id);
        $blocked_number = PreForm($this->blocked_number);
        $tag1 = PreForm($this->tag1);

        $op = $_op;

        include 'forms/fblocked_number.php';
    }

    public function Update() {
        global $db;
        $sql = 'UPDATE `blocked_number` SET `blocked_number` = \'' . PreSql($this->blocked_number) . '\', `tag1` = \'' . PreSql($this->tag1) . '\' WHERE `id` = ' . $this->id;

        if (!$db->sql_query($sql)) {
            $this->Errors[] = $db->sql_error_msg($result);
            return false;
        }

        return true;
    }

    public function FromForm() {
        $this->id = PostForm($_POST['id']);
        $this->blocked_number = PostForm($_POST['blocked_number']);
        $this->tag1 = PostForm($_POST['tag1']);
    }

    public static function AdminListblocked_numbers() {
        global $db, $list_per_page;
        $per_page = $list_per_page;
        if (!isset($_GET['admin_page']) || $_GET['admin_page'] < 1)
            $_GET['admin_page'] = 1;
        $admin_page = $_GET['admin_page'];
        $sql = 'SELECT * FROM `blocked_number`  	ORDER BY `id` DESC LIMIT ' . (($admin_page - 1) * $per_page) . ',' . ($per_page + 1) . ' ';
        $result = $db->sql_query($sql) or die($sql . "<br/>" . $db->sql_error_msg($result));
        $no = $db->sql_numrows($result);

        $page_no = PageCount(GetUnlimitedCount($sql), $per_page);
        $List = '<p class="admin_title">' . _lang(list_blocked_number) . ':</p>';
        $List.= '<table class="adminlist" width="400"><tr class="header"><td width="60%">' . _lang(blocked_number) . '</td><td width="30%">' . _lang(delete) . '</td></tr> ';
        while (($row = $db->sql_fetchrow($result)) && $i < $per_page) {

            if ($i % 2.0 > 0)
                $class = "odd";
            else
                $class = "even";
            $i++;

            $List.= '<tr class="' . $class . '"><td width="60%">' .
                    "<a href=\"?id=$row[id]&op=Edit\">$row[blocked_number]</a></td>" .
                    "<td width=\"30%\"><a href=\"javascript:if (confirm('" . _lang(sure_delete_blocked_number) . "')) {document.location ='?id=$row[id]&op=Delete';}\">Delete</a></td></tr> ";
        }
        $List.= '</table>';
        $List.="<div class=\"admin_list_control\">";
        if ($admin_page > 1)
            $List.= "&laquo; <a href=\"?admin_page=" . ($admin_page - 1) . "\" >" . _lang(list_previous_page) . " $per_page </a>&nbsp;&nbsp; ";

        if ($page_no > 2) {
            $List.='<select onchange="document.location=\'?admin_page=\'+this.value;">';
            for ($i = 1; $i <= $page_no; $i++) {
                $sel = "";
                if ($admin_page == $i)
                    $sel = "selected";
                $List.='<option value="' . $i . '" ' . $sel . '>' . $i . '</option>';
            }
            $List.='</select>';
        }

        if ($no > $per_page)
            $List.= "&nbsp;<a href=\"?admin_page=" . ($admin_page + 1) . "\" > " . _lang(list_next_page) . " $per_page</a> &raquo;";

        $List.="</div><br/>";

        return $List;
    }

    public static function GetBlockedWhereSql($mobile_field_name = "tel") {
        $where.="( (
		character_length($mobile_field_name)=10 
		OR (character_length($mobile_field_name)=11 AND substring($mobile_field_name from 1 for 3)='614')
		OR (character_length($mobile_field_name)=12 AND substring($mobile_field_name from 1 for 4)='0614')		) 
		AND	substring($mobile_field_name from '........$') NOT IN  (SELECT blocked_number FROM blocked_number) ) ";
        return $where;
    }

    public static function GetBlockedNumbers() {
        global $db;
        return $db->get_array('blocked_number', 'blocked_number');
    }

    public static function IsBlocked($number) {

        global $db;


        if (strlen($number) == 11 && substr($number, 0, 3) == "614")
            $number = "04" . substr($number, -8);

        if (strlen($number) == 12 && substr($number, 0, 4) == "0614")
            $number = "04" . substr($number, -8);

        if (strlen($number) != 10 && strlen($number) != 11) {
            return true;
        }

        if (substr($number, 0, 2) != "04") {
            return true;
        }



        $sql = 'SELECT * FROM `blocked_number` WHERE `blocked_number` = \'' . substr($number, -8) . '\'';
         if (!($result = $db->sql_query($sql))) {
//            PrintErrors(array($db->sql_error_msg($result)));
            return false;
        }
        if ($db->sql_fetchrow($result))
            return true;
        return false;
    }

}

?>