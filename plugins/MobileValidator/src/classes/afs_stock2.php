<?php
class afs_stock2
{

	public  $stock_no;
	public  $yard;
	public  $rego;
	public  $vin;
	public  $nvic;
	public  $make;
	public  $model;
	public  $apl;
	public  $body;
	public  $engine;
	public  $transmission;
	public  $colour;
	public  $rrp;
	public  $year;
	public  $special;
	public  $km;

	var  $Errors;


	public function SetValues($_stock_no , $_yard , $_rego , $_vin , $_nvic , $_make , $_model , $_apl , $_body , $_engine , $_transmission , $_colour , $_rrp , $_year , $_special , $_km)
	{	$this->yard=$_yard;
	$this->rego=$_rego;
	$this->vin=$_vin;
	$this->nvic=$_nvic;
	$this->make=$_make;
	$this->model=$_model;
	$this->apl=$_apl;
	$this->body=$_body;
	$this->engine=$_engine;
	$this->transmission=$_transmission;
	$this->colour=$_colour;
	$this->rrp=$_rrp;
	$this->year=$_year;
	$this->special=$_special;
	$this->km=$_km;

	}


	public function SelectFromDB($_stock_no,&$_row)
	{
		global $db;
		if (!ereg("^([0-9]+)$",$_stock_no))
		{
			$this->Errors[]=_lang('invalid_stock_no');
			return false;
		}
		$this->stock_no=$_stock_no;
		$sql = 'SELECT * FROM `afs_stock2` WHERE `stock_no` = '.$_stock_no;
		if(! ($result=$db->sql_query($sql)))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		if($db->sql_numrows($result)<1)
		{
			$this->Errors[]=_lang('no_afs_stock2_found');
			return false;
		}

		$row = $db->sql_fetchrow($result);
		$this->yard=$row['yard'];
		$this->rego=$row['rego'];
		$this->vin=$row['vin'];
		$this->nvic=$row['nvic'];
		$this->make=$row['make'];
		$this->model=$row['model'];
		$this->apl=$row['apl'];
		$this->body=$row['body'];
		$this->engine=$row['engine'];
		$this->transmission=$row['transmission'];
		$this->colour=$row['colour'];
		$this->rrp=$row['rrp'];
		$this->year=$row['year'];
		$this->special=$row['special'];
		$this->km=$row['km'];
		
		$_row=$row;
		return true;


	}

	public function Insert()
	{
		global $db;
		$sql = 'INSERT INTO `afs_stock2` (`yard`, `rego`, `vin`, `nvic`, `make`, `model`, `apl`, `body`, `engine`, `transmission`, `colour`, `rrp`, `year`, `special`,  `km`) VALUES (\''.PreSql($this->yard).'\',  \''.PreSql($this->rego).'\',  \''.PreSql($this->vin).'\',  \''.PreSql($this->nvic).'\',  \''.PreSql($this->make).'\',  \''.PreSql($this->model).'\',  \''.PreSql($this->apl).'\',  \''.PreSql($this->body).'\',  \''.PreSql($this->engine).'\',  \''.PreSql($this->transmission).'\',  \''.PreSql($this->colour).'\',  \''.PreSql($this->rrp).'\',  \''.PreSql($this->year).'\',  \''.PreSql($this->special).'\',  \''.PreSql($this->km).'\')';
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
		include '../forms/fafs_stock2.php';

	}

	public function Delete()
	{
		global $db;

		$sql = 'DELETE FROM `afs_stock2` WHERE `stock_no`='.$this->stock_no;
		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		return true;

	}

	public function Edit($_op='Update')
	{
		$stock_no=PreForm($this->stock_no);
		$yard=PreForm($this->yard);
		$rego=PreForm($this->rego);
		$vin=PreForm($this->vin);
		$nvic=PreForm($this->nvic);
		$make=PreForm($this->make);
		$model=PreForm($this->model);
		$apl=PreForm($this->apl);
		$body=PreForm($this->body);
		$engine=PreForm($this->engine);
		$transmission=PreForm($this->transmission);
		$colour=PreForm($this->colour);
		$rrp=PreForm($this->rrp);
		$year=PreForm($this->year);
		$special=PreForm($this->special);
		$km=PreForm($this->km);

		$op=$_op;

		include '../forms/fafs_stock2.php';

	}

	public function Update()
	{
		global $db;
		$sql = 'UPDATE `afs_stock2` SET `yard` = \''.PreSql($this->yard).'\', `rego` = \''.PreSql($this->rego).'\', `vin` = \''.PreSql($this->vin).'\', `nvic` = \''.PreSql($this->nvic).'\', `make` = \''.PreSql($this->make).'\', `model` = \''.PreSql($this->model).'\', `apl` = \''.PreSql($this->apl).'\', `body` = \''.PreSql($this->body).'\', `engine` = \''.PreSql($this->engine).'\', `transmission` = \''.PreSql($this->transmission).'\', `colour` = \''.PreSql($this->colour).'\', `rrp` = \''.PreSql($this->rrp).'\', `year` = \''.PreSql($this->year).'\', `special` = \''.PreSql($this->special).'\', `km` = \''.PreSql($this->km).'\' WHERE `stock_no` = '.$this->stock_no;

		if(!$db->sql_query($sql))
		{
			$this->Errors[]=$db->sql_error_msg($result);
			return false;
		}

		return true;

	}

	public function FromForm()
	{
		$this->stock_no=PostForm($_POST['stock_no']);
		$this->yard=PostForm($_POST['yard']);
		$this->rego=PostForm($_POST['rego']);
		$this->vin=PostForm($_POST['vin']);
		$this->nvic=PostForm($_POST['nvic']);
		$this->make=PostForm($_POST['make']);
		$this->model=PostForm($_POST['model']);
		$this->apl=PostForm($_POST['apl']);
		$this->body=PostForm($_POST['body']);
		$this->engine=PostForm($_POST['engine']);
		$this->transmission=PostForm($_POST['transmission']);
		$this->colour=PostForm($_POST['colour']);
		$this->rrp=PostForm($_POST['rrp']);
		$this->year=PostForm($_POST['year']);
		$this->special=PostForm($_POST['special']);
		$this->km=PostForm($_POST['km']);

	}
	
}

?>