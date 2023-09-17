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
		$options =  [
					'fields' => [
				        'TITLE' => 'KG-Lead',
				        'NAME' => 'kkkkarim',
				        'SECOND_NAME' => 'GGGGGamal',
				        'LAST_NAME' => 'GGGGGamal',
				        'STATUS_ID' => 'NEW',
						// "ASSIGNED_BY_ID": 1, 
    					"OPENED"=> "Y", 
						"PHONE"=> [ [ "VALUE"=> "555888","VALUE_TYPE"=> "WORK" ] ] ,

				    ],
				];
		$result = $this->bitrix_process_api('crm.lead.add',$options);
		echo '<pre>';
		print_r($result);
		echo '</pre>';die;
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
}
//------------------------------------------
// $data = ['name'=>'Karim'];
// $bitrix = new BitrixIntegration();
// $bitrix->execute($data,'book-appointment');