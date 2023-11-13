<?php
class yard
{

    public  $id;
    public  $code;
    public  $name;
    public  $address;
    public  $phone;
    public  $tag1;
    public  $tag2;

    var  $Errors;
    public static $sErrors;
    
    public function SetValues($_id , $_code , $_name , $_address , $_phone , $_tag1 , $_tag2)
    {	$this->code=$_code;
        $this->name=$_name;
        $this->address=$_address;
        $this->phone=$_phone;
        $this->tag1=$_tag1;
        $this->tag2=$_tag2;

    }


    public function SelectFromDB($_id)
    {
        global $db;
        if (!ereg("^([0-9]+)$",$_id))
        {
            $this->Errors[]=_lang('invalid_id');
            return false;
        }
        $this->id=$_id;
        $sql = 'SELECT * FROM `yard` WHERE `id` = '.$_id;
        if(! ($result=$db->sql_query($sql)))
        {
            $this->Errors[]=$db->sql_error_msg($result);
            return false;
        }

        if($db->sql_numrows($result)<1)
        {
            $this->Errors[]=_lang('no_yard_found');
            return false;
        }

        $row = $db->sql_fetchrow($result);
        $this->code=$row['code'];
        $this->name=$row['name'];
        $this->address=$row['address'];
        $this->phone=$row['phone'];
        $this->tag1=$row['tag1'];
        $this->tag2=$row['tag2'];
        return true;


    }

    public function Insert()
    {
        global $db;
        $sql = 'INSERT INTO `yard` (`code`, `name`, `address`, `phone`, `tag1`,  `tag2`) VALUES (\''.PreSql($this->code).'\',  \''.PreSql($this->name).'\',  \''.PreSql($this->address).'\',  \''.PreSql($this->phone).'\',  \''.PreSql($this->tag1).'\',  \''.PreSql($this->tag2).'\')';
        if(!$db->sql_query($sql))
        {
            $this->Errors[]=$db->sql_error_msg($result);
            return false;
        }

        return $db->sql_nextid();
    }


    public function Add()
    {
        $op='Add';
        include '../forms/fyard.php';

    }

    public function Delete()
    {
        global $db;

        $sql = 'DELETE FROM `yard` WHERE `id`='.$this->id;
        if(!$db->sql_query($sql))
        {
            $this->Errors[]=$db->sql_error_msg($result);
            return false;
        }

        return true;

    }

    public function Edit($_op='Update')
    {
        $id=PreForm($this->id);
        $code=PreForm($this->code);
        $name=PreForm($this->name);
        $address=PreForm($this->address);
        $phone=PreForm($this->phone);
        $tag1=PreForm($this->tag1);
        $tag2=PreForm($this->tag2);

        $op=$_op;

        include '../forms/fyard.php';

    }

    public function Update()
    {
        global $db;
        $sql = 'UPDATE `yard` SET `code` = \''.PreSql($this->code).'\', `name` = \''.PreSql($this->name).'\', `address` = \''.PreSql($this->address).'\', `phone` = \''.PreSql($this->phone).'\', `tag1` = \''.PreSql($this->tag1).'\', `tag2` = \''.PreSql($this->tag2).'\' WHERE `id` = '.$this->id;

        if(!$db->sql_query($sql))
        {
            $this->Errors[]=$db->sql_error_msg($result);
            return false;
        }

        return true;

    }

    public function FromForm()
    {
        $this->id=PostForm($_POST['id']);
        $this->code=PostForm($_POST['code'],20);
        $this->name=PostForm($_POST['name'],50);
        $this->address=PostForm($_POST['address'],200);
        $this->phone=PostForm($_POST['phone'],20);
        $this->tag1=PostForm($_POST['tag1']);
        $this->tag2=PostForm($_POST['tag2']);

    }
    public static function AdminListyards()
    {
        global $db,$list_per_page;
        $per_page=$list_per_page;
        if(!isset($_GET['admin_page']) || $_GET['admin_page']<1)
        $_GET['admin_page']=1;
        $admin_page=$_GET['admin_page'];
        $sql = 'SELECT * FROM `yard`  	ORDER BY `id` DESC LIMIT '.(($admin_page-1)*$per_page).','.($per_page+1).' ';
        $result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
        $no=$db->sql_numrows($result);

        $page_no=PageCount(GetUnlimitedCount($sql),$per_page);
        $List= '<p class="admin_title">'._lang('list_yard').':</p>' ;
        $List.= '<table class="adminlist" width="400"><tr class="header"><td width="10%">ID</td><td width="60%">'._lang('name').'</td><td width="30%">'._lang('delete').'</td></tr> ';
        while(($row = $db->sql_fetchrow($result))&&$i<$per_page)
        {

            if($i%2.0>0) $class="odd";
            else $class="even";
            $i++;

            $List.= '<tr class="'.$class.'"><td width="10%">'.$row[id].'</td><td width="60%">'.
        "<a href=\"?id=$row[id]&op=Edit\">$row[name]</a></td>".
        "<td width=\"30%\"><a href=\"javascript:if (confirm('"._lang('sure_delete_yard')."')) {document.location ='?id=$row[id]&op=Delete';}\">Delete</a></td></tr> ";
        }
        $List.= '</table>';
        $List.="<div class=\"admin_list_control\">";
        if($admin_page>1)
        $List.= "&laquo; <a href=\"?admin_page=".($admin_page-1)."\" >"._lang('list_previous_page')." $per_page </a>&nbsp;&nbsp; ";

        if($page_no>2)
        {
            $List.='<select onchange="document.location=\'?admin_page=\'+this.value;">';
            for($i=1;$i<=$page_no;$i++)
            {
                $sel="";
                if($admin_page==$i) $sel="selected";
                $List.='<option value="'.$i.'" '.$sel.'>'.$i.'</option>';
            }
            $List.='</select>';
        }

        if($no>$per_page )
        $List.= "&nbsp;<a href=\"?admin_page=".($admin_page+1)."\" > "._lang('list_next_page')." $per_page</a> &raquo;";

        $List.="</div><br/>";
        $List.='<form class="Internal"  name="ProdForm" method="get"  action="" >
        <label for="job_id">&nbsp;&nbsp;<b>'._lang('enter_yard_id').':</b></label>
        <input type="hidden" name="op" value="Edit" />
        <input type="text" name="id" />
        <input type="button" onClick="document.ProdForm.op.value=\'Edit\';document.ProdForm.submit();"  value="Edit" />
        <input onclick="if (confirm(\''._lang('sure_delete_yard').'\')) {document.ProdForm.op.value=\'Delete\';document.ProdForm.submit();} " value="Delete" type="button" />
    </form>
    <br/>';
        return $List;


    }
    public static function getYards(){
    	 global $db;
    	$sql = 'SELECT *
                FROM `yard`
                ';
        if(!$result = $db->sql_query($sql)){
            self::$sErrors[] = $db->sql_error_msg();
            return false;
        }
        return $db->sql_fetchrowset($result);
    }
     public static function getYardPhone($salesAgentId){
        global $db;
    	$sql = 'SELECT `mobile`
                FROM `yard`
                WHERE `id` = '.$salesAgentId;
        if(!$result = $db->sql_query($sql)){
            self::$sErrors[] = $db->sql_error_msg();
            return false;
        }
        $row = $db->sql_fetchrow($result);
        return $row[0];
    }

}

?>