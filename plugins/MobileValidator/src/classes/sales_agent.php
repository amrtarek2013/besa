<?php
class sales_agent
{

    public  $id;
    public  $user_name;
    public  $email;
    public  $password;
    public  $name;
    public  $mobile;
    public  $yard_id;
    public  $tag1;

    var  $Errors;
    public static $sErrors;
   



    public function SetValues($_id , $_user_name , $_email , $_password , $_name , $_mobile , $_yard_id , $_tag1)
    {	$this->user_name=$_user_name;
        $this->email=$_email;
        $this->password=$_password;
        $this->name=$_name;
        $this->mobile=$_mobile;
        $this->yard_id=$_yard_id;
        $this->tag1=$_tag1;

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
        $sql = 'SELECT * FROM `sales_agent` WHERE `id` = '.$_id;
        if(! ($result=$db->sql_query($sql)))
        {
            $this->Errors[]=$db->sql_error_msg($result);
            return false;
        }

        if($db->sql_numrows($result)<1)
        {
            $this->Errors[]=_lang('no_sales_agent_found');
            return false;
        }

        $row = $db->sql_fetchrow($result);
        $this->user_name=$row['user_name'];
        $this->email=$row['email'];
        $this->password=$row['password'];
        $this->name=$row['name'];
        $this->mobile=$row['mobile'];
        
        $this->yard_id=$row['yard_id'];
        $this->tag1=$row['tag1'];
        return true;


    }

    public function Insert()
    {
        global $db;
        $sql = 'INSERT INTO `sales_agent` (`user_name`, `email`, `password`, `name`, `mobile`, `yard_id`,  `tag1`)
        		VALUES (\''.PreSql($this->user_name).'\',
        				\''.PreSql($this->email).'\',  
        				\''.PreSql($this->password).'\',  
        				\''.PreSql($this->name).'\',
        				\''.PreSql($this->mobile).'\',
        				\''.PreSql($this->yard_id).'\',
        				\''.PreSql($this->tag1).'\')';

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
        $yards = yard::getYards();
        include '../forms/fsales_agent.php';

    }

    public function Delete()
    {
        global $db;

        $sql = 'DELETE FROM `sales_agent` WHERE `id`='.$this->id;
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
        $user_name=PreForm($this->user_name);
        $email=PreForm($this->email);
        $password=PreForm($this->password);
        $name=PreForm($this->name);
        $mobile=PreForm($this->mobile);
        $yard_id=PreForm($this->yard_id);
        $tag1=PreForm($this->tag1);

        $op=$_op;
		$yards = yard::getYards();
        include '../forms/fsales_agent.php';

    }

    public function Update()
    {
        global $db;
        $sql = 'UPDATE `sales_agent` 
        		SET `user_name` = \''.PreSql($this->user_name).'\',
        			`email` = \''.PreSql($this->email).'\', 
        			`password` = \''.PreSql($this->password).'\', 
        			`name` = \''.PreSql($this->name).'\',
        			`mobile` = \''.PreSql($this->mobile).'\',
        			`yard_id` = \''.PreSql($this->yard_id).'\',
        			`tag1` = \''.PreSql($this->tag1).'\'
        		WHERE `id` = '.$this->id;

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
        $this->user_name=PostForm($_POST['user_name'],200);
        $this->email=PostForm($_POST['email']);
        if($_POST['password'])
        $this->password= md5(PostForm($_POST['password']));
        
        $this->name=PostForm($_POST['name']);
        $this->mobile=PostForm($_POST['mobile']);
        $this->yard_id=PostForm($_POST['yard_id']);
        $this->tag1=PostForm($_POST['tag1']);

    }
    public static function AdminListsales_agents()
    {
        global $db,$list_per_page;
        $per_page=$list_per_page;
        if(!isset($_GET['admin_page']) || $_GET['admin_page']<1)
        $_GET['admin_page']=1;
        $admin_page=$_GET['admin_page'];
        $sql = 'SELECT * FROM `sales_agent`  	ORDER BY `id` DESC LIMIT '.(($admin_page-1)*$per_page).','.($per_page+1).' ';
        $result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
        $no=$db->sql_numrows($result);

        $page_no=PageCount(GetUnlimitedCount($sql),$per_page);
        $List= '<p class="admin_title">'._lang('list_sales_agent').':</p>' ;
        $List.= '<table class="adminlist" width="400"><tr class="header"><td width="10%">ID</td><td width="60%">'._lang('name').'</td><td width="30%">'._lang('delete').'</td></tr> ';
        while(($row = $db->sql_fetchrow($result))&&$i<$per_page)
        {

            if($i%2.0>0) $class="odd";
            else $class="even";
            $i++;

            $List.= '<tr class="'.$class.'"><td width="10%">'.$row[id].'</td><td width="60%">'.
        "<a href=\"?id=$row[id]&op=Edit\">$row[user_name]</a></td>".
        "<td width=\"30%\"><a href=\"javascript:if (confirm('"._lang('sure_delete_sales_agent')."')) {document.location ='?id=$row[id]&op=Delete';}\">Delete</a></td></tr> ";
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
        $List.='<form class="Internal"  user_name="ProdForm" method="get"  action="" >
        <label for="job_id">&nbsp;&nbsp;<b>'._lang('enter_id').':</b></label>
        <input type="hidden" user_name="op" value="Edit" />
        <input type="text" user_name="id" />
        <input type="button" onClick="document.ProdForm.op.value=\'Edit\';document.ProdForm.submit();"  value="Edit" />
        <input onclick="if (confirm(\''._lang('sure_delete_prod').'\')) {document.ProdForm.op.value=\'Delete\';document.ProdForm.submit();} " value="Delete" type="button" />
    </form>
    <br/>';
        return $List;


    }
	
 
    public static function getUserName($salesAgentId){
        global $db;
    	$sql = 'SELECT `user_name`
                FROM `sales_agent`
                WHERE `id` = '.$salesAgentId;

        if(!$result = $db->sql_query($sql)){
            self::$sErrors[] = $db->sql_error_msg();
            return false;
        }
        $row = $db->sql_fetchrow($result);
        return $row[0];
    }
    
    public static function getEmail($salesAgentId){
        global $db;
    	$sql = 'SELECT `email`
                FROM `sales_agent`
                WHERE `id` = '.$salesAgentId;

        if(!$result = $db->sql_query($sql)){
            self::$sErrors[] = $db->sql_error_msg();
            return false;
        }
        $row = $db->sql_fetchrow($result);
        return $row[0];
    }
    
    public static function getName($salesAgentId){
        global $db;
    	$sql = 'SELECT `name`
                FROM `sales_agent`
                WHERE `id` = '.$salesAgentId;
        if(!$result = $db->sql_query($sql)){
            self::$sErrors[] = $db->sql_error_msg();
            return false;
        }
        $row = $db->sql_fetchrow($result);
        return $row[0];
    }  
    public static function getId($salesAgentName){
        global $db;
    	$sql = 'SELECT `id`
                FROM `sales_agent`
                WHERE `name` = '.$salesAgentName;
        if(!$result = $db->sql_query($sql)){
            self::$sErrors[] = $db->sql_error_msg();
            return false;
        }
        $row = $db->sql_fetchrow($result);
        return $row[0];
    }
}

?>