<?
class BitrixIntegration{
	public $main_dir = '/home/u975649297/domains/besaeg.com/public_html';
	public function execute($data,$type){
		switch ($type) {
			case 'book-appointment':
				$this->add_lead_from_book_appointment($data,$type);
				break;
			
			default:
				// code...
				break;
		}
	}
	public function add_lead_from_book_appointment($data,$type){
		// $options =  [];
		// $result = $this->bitrix_process_api('crm.lead.list',$options);
		$data_arr = [];
		if(!empty($data['name'])){
			$data_arr['TITLE'] = $data['name'];
			$name_arr = $this->get_name_info($data['name']);
		}
		if(!empty($name_arr['first_name'])){
			$data_arr['NAME'] = $name_arr['first_name'];
		}
		if(!empty($name_arr['second_name'])){
			$data_arr['SECOND_NAME'] = $name_arr['second_name'];
		}
		if(!empty($name_arr['last_name'])){
			$data_arr['LAST_NAME'] = $name_arr['last_name'];
		}
		$data_arr['STATUS_ID'] = 'NEW';
		$data_arr['OPENED'] = 'Y';
		// $data_arr['PHONE'] = [ [ "VALUE"=> "555888","VALUE_TYPE"=> "WORK" ] ];
		if(!empty($data_arr['TITLE'])){
			$options =  ['fields' => $data_arr,];

			$result = $this->bitrix_process_api('crm.lead.add',$options);
			echo '<pre>';
			print_r($result);
			echo '</pre>';die;
		}
	}
	function bitrix_process_api($endpoint,$options){
		require_once ($this->main_dir.'/plugins/bitrix/crest.php');
		$response = CRest::call($endpoint, $options);
		if ($response['error']) {
		    return ['status'=>false,'message'=>$response['error_description']];
		} else {
		    return ['status'=>true,'data'=>$response['result']];
		}
		return ['status'=>false,'message'=>'Invalid Request'];
	}
	function get_name_info($name){
		$return = [];
		if(empty($name)){
			return [];
		}
		$name_segments = explode(' ',$name);
		if(!empty($name_segments[0])){
			$return['first_name'] = $name_segments[0];
		}
		if(!empty($name_segments[1])){
			$return['second_name'] = $name_segments[1];
		}
		if(!empty($name_segments[2])){
			$return['last_name'] = $name_segments[2];
		}

		return $return;
	}
}
//------------------------------------------
// $data = ['name'=>'Karim'];
// $bitrix = new BitrixIntegration();
// $bitrix->execute($data,'book-appointment');