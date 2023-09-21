<?
class BitrixIntegration{
	public $main_dir = '/home/u975649297/domains/besaeg.com/public_html';
	public function execute($data,$type,$extras = []){
		switch ($type) {
			case 'book-appointment':
				$this->add_lead_from_book_appointment($data,$type,$extras);
				break;
			case 'visitors-application':
				$this->add_lead_from_visitors_application($data,$type,$extras);
				break;
			case 'register-student':
				$this->add_lead_from_register($data,$type,$extras);
				break;
			
			default:
				// code...
				break;
		}
	}
	public function add_lead_from_book_appointment($data,$type,$extras){
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
		if(!empty($data['mobile'])){
			$mobile = '';
			if(!empty($data['mobile_code'])){
				$mobile = $data['mobile_code'];
			}
			$mobile .= $data['mobile'];
			$data_arr['PHONE'] = [ [ "VALUE"=> $mobile,"VALUE_TYPE"=> "WORK" ] ];
		}
		if(!empty($data['email'])){
			$data_arr['EMAIL'] = [ [ "VALUE"=> $data['email'],"VALUE_TYPE"=> "WORK" ] ];
		}

		$data_arr['STATUS_ID'] = 'NEW';
		$data_arr['OPENED'] = 'Y';

		$data_arr['SOURCE_ID'] = 'EMAIL';

		if(!empty($data['destination_id']) && !empty($extras['countriesList']) ){
			$data_arr['UF_CRM_1610306282'] = $extras['countriesList'][$data['destination_id']];
			$data_arr['UF_CRM_1694999838223'] = $extras['countriesList'][$data['destination_id']];
		}
		if(!empty($data['subject_area_id']) && !empty($extras['subjectAreas']) ){
			$data_arr['UF_CRM_1694999790491'] = $extras['subjectAreas'][$data['subject_area_id']];
		}
		$study_levels = [
			0=>44,1=>44,
			2=>46,3=>46,4=>46,
		];
		if(!empty($data['study_level'])){
			$data_arr['UF_CRM_1610102425'] = $study_levels[$data['study_level']];
		}
		

		

		if(!empty($data_arr['TITLE'])){
			$options =  ['fields' => $data_arr,];

			$result = $this->bitrix_process_api('crm.lead.add',$options);
			// echo '<pre>';
			// print_r($result);
			// echo '</pre>';die;
		}
	}
	public function add_lead_from_visitors_application($data,$type,$extras){
		$study_levels = [
			0=>44,1=>44,
			2=>46,3=>46,4=>46,
		];
		$data_arr = [];
		if(!empty($data['name'])){
			$data_arr['TITLE'] = $data['name'];
			$data_arr['NAME'] = $data['name'];
			if(!empty($data['surname'])){
				$data_arr['LAST_NAME'] = $data['surname'];
				$data_arr['TITLE'] .= ' '.$data['surname'];
			}
		}
		
		if(!empty($data['mobile'])){
			$mobile = '';
			if(!empty($data['mobile_code'])){
				$mobile = $data['mobile_code'];
			}
			$mobile .= $data['mobile'];
			$data_arr['PHONE'] = [ [ "VALUE"=> $mobile,"VALUE_TYPE"=> "WORK" ] ];
		}
		if(!empty($data['email'])){
			$data_arr['EMAIL'] = [ [ "VALUE"=> $data['email'],"VALUE_TYPE"=> "WORK" ] ];
		}
		if(!empty($data['study_level'])){
			$data_arr['UF_CRM_1610102425'] = $study_levels[$data['study_level']];
		}

		$data_arr['STATUS_ID'] = 'NEW';
		$data_arr['OPENED'] = 'Y';

		$data_arr['SOURCE_ID'] = 'UC_K5MWDQ';
		if(!empty($data['school_name'])){
			$data_arr['UF_CRM_1695270017192'] = $data['school_name'];
		}
		if(!empty($data['destination_id']) && !empty($extras['countriesList']) ){
			$data_arr['UF_CRM_1610306282'] = $extras['countriesList'][$data['destination_id']];
			$data_arr['UF_CRM_1694999838223'] = $extras['countriesList'][$data['destination_id']];
		}
		if(isset($data['fair_venue']) && !empty($extras['fairVenues']) ){
			$data_arr['UF_CRM_1695270330920'] = $extras['fairVenues'][$data['fair_venue']];
		}
		// print_r($data_arr);die("-------------");
		if(!empty($data_arr['TITLE'])){
			$options =  ['fields' => $data_arr,];

			$result = $this->bitrix_process_api('crm.lead.add',$options);
			// echo '<pre>';
			// print_r($result);
			// echo '</pre>';die;
		}
	}
	public function add_lead_from_register($data,$type,$extras){
		$study_levels = [
			0=>44,1=>44,
			2=>46,3=>46,4=>46,
		];
		$data_arr = [];
		if(!empty($data['first_name'])){
			$data_arr['TITLE'] = $data['first_name'];
			$data_arr['NAME'] = $data['first_name'];
			if(!empty($data['last_name'])){
				$data_arr['LAST_NAME'] = $data['last_name'];
				$data_arr['TITLE'] .= $data['last_name'];
			}
		}
		
		if(!empty($data['mobile'])){
			$mobile = '';
			if(!empty($data['mobile_code'])){
				$mobile = $data['mobile_code'];
			}
			$mobile .= $data['mobile'];
			$data_arr['PHONE'] = [ [ "VALUE"=> $mobile,"VALUE_TYPE"=> "WORK" ] ];
		}
		if(!empty($data['email'])){
			$data_arr['EMAIL'] = [ [ "VALUE"=> $data['email'],"VALUE_TYPE"=> "WORK" ] ];
		}
		if(isset($data['current_study_level'])){
			$data_arr['UF_CRM_1610102425'] = $study_levels[$data['current_study_level']];
		}
		if(!empty($data['subject_area_id']) && !empty($extras['subjectAreas']) ){
			$data_arr['UF_CRM_1694999790491'] = $extras['subjectAreas'][$data['subject_area_id']];
		}
		if(!empty($data['destination_id']) && !empty($extras['countriesList']) ){
			$data_arr['UF_CRM_1694999838223'] = $extras['countriesList'][$data['destination_id']];
		}
		if(isset($data['gender']) ){
			if($data['gender']==1){
				$data_arr['UF_CRM_1694999663599'] = 'Female';
			}else{
				$data_arr['UF_CRM_1694999663599'] = 'Male';
			}
		}
		if( !empty($extras['bd']) ){
			$data_arr['BIRTHDATE'] = $extras['bd'];
			$age = $this->calculate_age($extras['bd']);
			if($age){
				$data_arr['UF_CRM_1688457637'] = $age;
			}
		}
		
		if(!empty($data['nationality_id']) && !empty($extras['countriesList']) ){
			$data_arr['UF_CRM_1695279653581'] = $extras['countriesList'][$data['nationality_id']];
		}
		if(!empty($data['city']) ){
			$data_arr['UF_CRM_1695279678041'] = $data['city'];
		}
		if(!empty($data['current_status']) ){
			$data_arr['UF_CRM_1695270017192'] = $data['current_status'];
		}
		$data_arr['SOURCE_ID'] = 'CALL';

		$data_arr['STATUS_ID'] = 'NEW';
		$data_arr['OPENED'] = 'Y';
		if(!empty($data_arr['TITLE'])){
			$options =  ['fields' => $data_arr,];

			$result = $this->bitrix_process_api('crm.lead.add',$options);
			// echo '<pre>';
			// print_r($result);
			// echo '</pre>';die;
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
	function calculate_age($dateOfBirth){
	    $dob = DateTime::createFromFormat('d.m.Y', $dateOfBirth);
		if (!$dob) {
	        return false;
	    }
	    $currentDate = new DateTime();
	    $interval = $dob->diff($currentDate);
		$age = $interval->y;
	    return $age;
	}

}
//------------------------------------------
// $data = ['name'=>'Karim'];
// $bitrix = new BitrixIntegration();
// $bitrix->execute($data,'book-appointment');