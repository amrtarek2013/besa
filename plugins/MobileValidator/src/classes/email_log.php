<?php
class email_log
{
    public static $sTableName = 'email_log';
    public  $id;
    public  $stock_number;
    public  $customer_name;
    public  $customer_email;
    public  $comment;
    public  $added_date;
    public  $user_id;
    public  $salesman;
    public  $tag2;

    var  $Errors;
    public static $sErrors;

    public function SetValues($_id , $_stock_number , $_customer_name , $_customer_email , $_comment , $_added_date , $_user_id , $_salesman , $_tag2)
    {	$this->stock_number=$_stock_number;
        $this->customer_name=$_customer_name;
        $this->customer_email=$_customer_email;
        $this->comment=$_comment;
        $this->added_date=$_added_date;
        $this->user_id=$_user_id;
        $this->salesman=$_salesman;
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
        $sql = 'SELECT * FROM `email_log` WHERE `id` = '.$_id;
        if(! ($result=$db->sql_query($sql)))
        {
            $this->Errors[]=$db->sql_error_msg($result);
            return false;
        }

        if($db->sql_numrows($result)<1)
        {
            $this->Errors[]=_lang('no_email_log_found');
            return false;
        }

        $row = $db->sql_fetchrow($result);
        $this->stock_number=$row['stock_number'];
        $this->customer_name=$row['customer_name'];
        $this->customer_email=$row['customer_email'];
        $this->comment=$row['comment'];
        $this->added_date=$row['added_date'];
        $this->user_id=$row['user_id'];
        $this->salesman=$row['salesman'];
        $this->tag2=$row['tag2'];
        return true;


    }

    public function Insert()
    {
        global $db;
        $sql = 'INSERT INTO `email_log` (`stock_number`, `customer_name`, `customer_email`, `comment`, `added_date`, `user_id`, `salesman`,  `tag2`) VALUES (\''.PreSql($this->stock_number).'\',  \''.PreSql($this->customer_name).'\',  \''.PreSql($this->customer_email).'\',  \''.PreSql($this->comment).'\',  \''.PreSql($this->added_date).'\',  \''.PreSql($this->user_id).'\',  \''.PreSql($this->salesman).'\',  \''.PreSql($this->tag2).'\')';
        if(!$db->sql_query($sql))
        {
            $this->Errors[]=$db->sql_error_msg($result);
            return false;
        }

        return $db->sql_nextid();
    }


    public function Add()
    {
        $op = 'Add';
        include '../forms/femail_log.php';
    }

    public function Delete()
    {
        global $db;

        $sql = 'DELETE FROM `email_log` WHERE `id`='.$this->id;
        if(!$db->sql_query($sql))
        {
            $this->Errors[]=$db->sql_error_msg($result);
            return false;
        }

        return true;

    }

    public function Edit($_op='Upsalesman')
    {
        $id=PreForm($this->id);
        $stock_number=PreForm($this->stock_number);
        $customer_name=PreForm($this->customer_name);
        $customer_email=PreForm($this->customer_email);
        $comment=PreForm($this->comment);
        $added_date=PreForm($this->added_date);
        $name = $_POST['name'];
        $mobile = $_POST['mobile'];
        $op=$_op;

        include '../forms/femail_log.php';

    }

    public function Update()
    {
        global $db;
        $sql = 'UPDATE `email_log`
                SET `stock_number` = \''.PreSql($this->stock_number).'\',
                    `customer_name` = \''.PreSql($this->customer_name).'\',
                    `customer_email` = \''.PreSql($this->customer_email).'\',
                    `comment` = \''.PreSql($this->comment).'\',
                    `added_date` = \''.PreSql($this->added_date).'\',
                    `user_id` = \''.PreSql($this->user_id).'\',
                    `tag2` = \''.PreSql($this->tag2).'\' 
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
        $this->stock_number=PostForm($_POST['stock_number']);
        $this->customer_name=PostForm($_POST['customer_name']);
        $this->customer_email=PostForm($_POST['customer_email']);
        $this->comment=PostForm($_POST['comment']);
        $this->added_date = date('Y-m-d H:i:s');
        $this->user_id=$_SESSION['sales_agent_id'];
        $this->salesman = PostForm($_POST['salesman']);
        $this->tag2 = PostForm($_POST['tag2']);
    }
    public static function AdminListemail_logs()
    {
        global $db,$list_per_page;
        $per_page=$list_per_page;
        if(!isset($_GET['admin_page']) || $_GET['admin_page']<1)
        $_GET['admin_page']=1;
        $admin_page=$_GET['admin_page'];
        $sql = 'SELECT * FROM `email_log`  	ORDER BY `id` DESC LIMIT '.(($admin_page-1)*$per_page).','.($per_page+1).' ';
        $result = $db->sql_query($sql) or die($sql."<br/>".$db->sql_error_msg($result)) ;
        $no=$db->sql_numrows($result);

        $page_no=PageCount(GetUnlimitedCount($sql),$per_page);
        $List= '<p class="admin_title">'._lang('list_email_log').':</p>' ;
        $List.= '<table class="adminlist" width="400"><tr class="header"><td width="10%">ID</td><td width="60%">'._lang('stock_number').'</td><td width="30%">'._lang('delete').'</td></tr> ';
        while(($row = $db->sql_fetchrow($result))&&$i<$per_page)
        {

            if($i%2.0>0) $class="odd";
            else $class="even";
            $i++;

            $List.= '<tr class="'.$class.'"><td width="10%">'.$row[id].'</td><td width="60%">'.
        "<a href=\"?id=$row[id]&op=Edit\">$row[stock_number]</a></td>".
        "<td width=\"30%\"><a href=\"javascript:if (confirm('"._lang('sure_delete_email_log')."')) {document.location ='?id=$row[id]&op=Delete';}\">Delete</a></td></tr> ";
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
        <label for="job_id">&nbsp;&nbsp;<b>'._lang('enter_id').':</b></label>
        <input type="hidden" name="op" value="Edit" />
        <input type="text" name="id" />
        <input type="button" onClick="document.ProdForm.op.value=\'Edit\';document.ProdForm.submit();"  value="Edit" />
        <input onclick="if (confirm(\''._lang('sure_delete_prod').'\')) {document.ProdForm.op.value=\'Delete\';document.ProdForm.submit();} " value="Delete" type="button" />
    </form>
    <br/>';
        return $List;
    }

    public static function getSQL($stockNumber = 0, $salesman = '', $yardId = 0, $fromDate = false, $toDate = false, $pageNo = 0, $rowsPerPage = 99999){

       return 'SELECT `email_log`.`id`, `email_log`.`stock_number`, `email_log`.`added_date`, `email_log`.`salesman`, `yard`.`name` AS yard_name
               FROM `email_log`, `sales_agent`, `yard`
               WHERE
                `email_log`.`user_id` = `sales_agent`.`id`
               AND
                `sales_agent`.`yard_id` = `yard`.`id`
               '.(($stockNumber)? 'AND `email_log`.`stock_number` lIKE \'%'.trim($stockNumber).'%\'' : '').'
               '.(($yardId)? 'AND `sales_agent`.`yard_id` = \''.$yardId.'\'' : '').'
               '.(($salesman)? 'AND `email_log`.`salesman` = \''.$salesman.'\'' : '').'
               '.(($fromDate)? 'AND `email_log`.`added_date` >= \''.$fromDate.'\'' : '').'
               '.(($toDate)? 'AND `email_log`.`added_date` <= \''.$toDate.'\'' : '').'
                ORDER BY `added_date` DESC
                LIMIT '.(($pageNo - 1) * $rowsPerPage).', '.($rowsPerPage);

    }

    public static function getAll($pageNo = 0, $rowsPerPage = 99999){
        global $db;
        $sql = self::getSQL(0, '', 0, false, false, $pageNo, $rowsPerPage);
        
        // die(print_r($_SESSION));
        // die($sql);

        if(!($result = $db->sql_query($sql))){
            self::$sErrors[] = $db->sql_error_msg($result);
            return false;
        }
        return $db->sql_fetchrowset($result);
    }

    public function getCount($stockNumber = 0, $salesman = '', $yardId = 0, $fromDate = false, $toDate = false){
        global $db;
        $sql = 'SELECT COUNT(*)
                FROM `email_log`, `sales_agent`, `yard`
                WHERE
                   `email_log`.`user_id` = `sales_agent`.`id`
                AND
                   `sales_agent`.`yard_id` = `yard`.`id`
               '.(($stockNumber)? 'AND `email_log`.`stock_number` lIKE \'%'.trim($stockNumber).'%\'' : '').'
               '.(($yardId)? 'AND `sales_agent`.`yard_id` = \''.$yardId.'\'' : '').'
               '.(($salesman)? 'AND `email_log`.`salesman` = \''.$salesman.'\'' : '').'
               '.(($fromDate)? 'AND `email_log`.`added_date` >= \''.$fromDate.'\'' : '').'
               '.(($toDate)? 'AND `email_log`.`added_date` <= \''.$toDate.'\'' : '');

        //die(print_r($_SESSION));
        //die($sql);

        if(!($result = $db->sql_query($sql))){
            self::$sErrors[] = $db->sql_error_msg($result);
            return false;
        }
        $row = $db->sql_fetchrow($result);
        return $row[0];
    }
    
    public function search($stockNumber = 0, $salesman = '', $yardId = 0, $fromDate = false, $toDate = false, $pageNo = 0, $rowsPerPage = 10000){
        global $db;
        $sql = self::getSQL($stockNumber, $salesman, $yardId, $fromDate, $toDate, $pageNo, $rowsPerPage);

        //die(print_r($_SESSION));
        //die($sql);

        if(!($result = $db->sql_query($sql))){
            self::$sErrors[] = $db->sql_error_msg($result);
            return false;
        }
        return $db->sql_fetchrowset($result);
    }

    public static function listEmailLogs(){
        global $predir, $page, $itemsPerPage, $email_logs, $op, $stockNo, $salesman, $salesmanId, $yardId, $fromDate, $toDate;

        $yards = yard::getYards();

        $totalEmailLogs = ($op == 'search')? self::getCount($stockNo, $salesman, $yardId, $fromDate, $toDate)
                                           : self::getCount();

        $resultsNo = $totalEmailLogs / $itemsPerPage;

        $pagesNo = floor($resultsNo);

        $pagesNo = ($pagesNo < $resultsNo)? $pagesNo + 1 : $pagesNo;

        $previousPage = ($page <= 1)? 1 : $page - 1;
        $nextPage = ($page + 1 > $pagesNo)? $page : $page + 1;

        $op = 'search';
        $query = self::getSQL($stockNo, $salesman, $yardId, $fromDate, $toDate, $page, $itemsPerPage);
        $query = str_replace("`","",$query  );
        $query = str_replace("rand(","random(",$query  );
        $query = str_replace("RAND(","RANDOM(",$query  );
        $query = str_replace('\\\'',"#$##$#",$query );
        $query = str_replace('\'\'',"NULL",$query );
        $query = str_replace('#$##$#','\\\'',$query );
        $query = preg_replace("/LIMIT ([0-9]+),([ 0-9]+)/", "", $query);
        $query = PreForm($query);

        # Check if it the first time entering the page, don't add search parameters to the link:
        $firstTime = (empty($_POST['op']) && empty($_GET['op']));

        # Prepare parameters passed with link:
        $opParameter = (!empty($op))? '&op='.preparePassedValue($op) : '';
        $stockNoParameter = (!empty($stockNo))? '&stock_no='.preparePassedValue($stockNo) : '';
        $salesmanIdParameter = (!empty($salesmanId))? '&salesman='.preparePassedValue($salesmanId) : '';
        $fromDateParameter = (!empty($fromDate))? '&from_date='.preparePassedValue($fromDate) : '';
        $toDateParameter = (!empty($toDate))? '&to_date='.preparePassedValue($toDate) : '';
        $yardIdParameter = (!empty($yardId))? '&yard_id='.preparePassedValue($yardId) : '';

        include '../forms/femail_log_search.php';
        include '../templates/email_log_search.tpl.html';
    }
    
    public static function ExportToCSV()
    {   global $query;
        header('Location:exporttocsv.php?sql='.urlencode($query).';&delimited=comma');

    }

    function sendEmail($to=false)
    {
        global $db, $site;

        $script_url =  $site["url"].'/';

        $customerName = $this->customer_name;
        $comment = $this->comment;

        $sales_agent1= new sales_agent();
        $sales_agent1->SelectFromDB($_SESSION['sales_agent_id']);

        $yard1 = new yard();
        $yard1->SelectFromDB($sales_agent1->yard_id);

        $salesPersonName =  $_POST['salesman'];
        $salesmanMobile = $_POST['mobile'];
        $yardName = $yard1->name;
        $yardAddress = $yard1->address;
        $yardPhoneNumber = $yard1->phone;

        $sql = 'SELECT DISTINCT *
                 FROM `afs_stock2`
                 WHERE `stock_no` IN (\''.str_replace(',','\',\'',$this->stock_number).'\')';
        if(!$result = $db->sql_query($sql)){
            $this->Errors [] = $db->sql_error_msg($result);
            return false;
        }
        $cars = $db->sql_fetchrowset($result);

        ob_start();
        include '../templates/email_log.tpl.html';
        $message = ob_get_contents();
        ob_end_clean();



        if(email::SendEmail($to?$to:$this->customer_email, 1, array('message' => $message)
            )
        )

        return true ;

        else
        {
            $this->Errors[]=_lang('cant_send_email');
            return false;

        }
    }
}

?>