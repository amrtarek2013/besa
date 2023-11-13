<?

class winning_number
{
	public static $sErrors;
	public static function GetWinningNumber()
	{
		global $predir;
		if(!($x=@file_get_contents($predir.'admin/winning_number.txt')))
		return 0;
		else
		return $x;
	}
	
	public static function EditWinningNumber()
	{
		$winning_number=(winning_number::GetWinningNumber());
		include('../forms/fwinning_number.php');

	}
	
	public static function UpdateWinningNumber()
	{
		global $predir;
		$winning_number=$_POST['winning_number'];
		
		if(!file_put_contents($predir.'admin/winning_number.txt',$winning_number))
		{
			winning_number::$sErrors[]=_lang('no_data_have_written');
			return false;
		}
		return true;


	}	
}