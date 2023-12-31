<?
class BitrixIntegration{
	public $main_dir = '/home/u975649297/domains/besaeg.com/public_html';

	public function sendApplicationFiles($data){
		if(empty($data['mobile']) || empty($data['files']) ){
			return false;
		}
		
		$mobile = $data['mobile'];
		$files = $data['files'];
		$existed_lead = $this->get_lead_by_mobile($mobile);
		if(!empty($existed_lead['data'][0]['ID'])){
			$lead_id = $existed_lead['data'][0]['ID'];
		}
		
		$files_arr = [];
		foreach ($files as $file) {
			$file_content = file_get_contents($file);
			$files_arr[]=[
						'fileData' => [
            							basename($file),
            							base64_encode($file_content)
          							]
  						];
		}

		//=============

		if(!empty($lead_id) && !empty($files_arr)){
			$options = [];
			$api_name = 'crm.lead.update';
			$options['id'] = $lead_id;
			$data_arr['UF_CRM_1610308772'] = $files_arr;
			$options['fields'] =  $data_arr;
			if(!empty($options)){
				$result = $this->bitrix_process_api($api_name,$options);
				// print_r($result);
				// $existed_lead = $this->get_lead_by_id(88785);
				// print_r($existed_lead);die;
			}
		}

		
	}
	public function upload_file_to_disk($filePath){
		// $filePath = '/home/u975649297/domains/besaeg.com/public_html/webroot/uploads/sliders/64c800089de6b_web-illustrations-final-trails-02.png';
		$options = [];
		$api_name = 'disk.storage.uploadfile';
		$options['id'] = 9599;
		// $options['data'] = json_encode(['NAME' => basename($filePath)]);
		$options['data'] = ['NAME' => basename($filePath)];
		// $fileData = new CURLFile($filePath);
		// $options['fileContent'] = $fileData;
		// $options['fileContent'] = 'R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';
		
	 	$file_content = file_get_contents($filePath);
    	$options['fileContent'] = base64_encode($file_content);
		if(!empty($options)){
			$result = $this->bitrix_process_api($api_name,$options);
			if($result['status']==1){
				return $result['data']['ID'];
			}
		}
		return false;
	}
	
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
		$existed_lead = [];
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

			$existed_lead = $this->get_lead_by_mobile($mobile);
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
		//responsible
		$data_arr['ASSIGNED_BY_ID'] = 422;


		$api_name = 'crm.lead.add';
		$options = [];
		if(!empty($existed_lead['data'][0]['ID'])){
			$options['id'] = $existed_lead['data'][0]['ID'];
			$api_name = 'crm.lead.update';
			if(!empty($existed_lead['data'][0]['STATUS_ID'])){
				$current_status = $existed_lead['data'][0]['STATUS_ID'];
				if(!in_array($current_status, ['JUNK','UC_0V372G','UC_UM2CL8']) ){
					$data_arr['ASSIGNED_BY_ID'] = $existed_lead['data'][0]['ASSIGNED_BY_ID'];
				}
			}
		}
		if(!empty($data_arr['TITLE'])){
			$options['fields'] =  $data_arr;
		}
		if(!empty($options)){
			$result = $this->bitrix_process_api($api_name,$options);
		}
	}
	public function add_lead_from_visitors_application($data,$type,$extras){
		$study_levels = [
			0=>44,1=>44,
			2=>46,3=>46,4=>46,
		];
		$data_arr = [];
		$existed_lead = [];
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
			$existed_lead = $this->get_lead_by_mobile($mobile);
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
		//responsible
		$data_arr['ASSIGNED_BY_ID'] = 422;
		if(isset($data['fair_venue'])){
			if($data['fair_venue']==1){
				$data_arr['ASSIGNED_BY_ID'] = 9551;
			}
		}

		$api_name = 'crm.lead.add';
		$options = [];
		if(!empty($existed_lead['data'][0]['ID'])){
			$options['id'] = $existed_lead['data'][0]['ID'];
			$api_name = 'crm.lead.update';
			if(!empty($existed_lead['data'][0]['STATUS_ID'])){
				$current_status = $existed_lead['data'][0]['STATUS_ID'];
				if(!in_array($current_status, ['JUNK','UC_0V372G','UC_UM2CL8']) ){
					$data_arr['ASSIGNED_BY_ID'] = $existed_lead['data'][0]['ASSIGNED_BY_ID'];
				}
			}
		}
		if(!empty($data_arr['TITLE'])){
			$options['fields'] =  $data_arr;
		}
		if(!empty($options)){
			$result = $this->bitrix_process_api($api_name,$options);
		}
	}
	public function add_lead_from_register($data,$type,$extras){
		$study_levels = [
			0=>44,1=>44,
			2=>46,3=>46,4=>46,
		];
		$data_arr = [];
		$existed_lead = [];
		if(!empty($data['first_name'])){
			$data_arr['TITLE'] = $data['first_name'];
			$data_arr['NAME'] = $data['first_name'];
			if(!empty($data['last_name'])){
				$data_arr['LAST_NAME'] = $data['last_name'];
				$data_arr['TITLE'] .= ' '.$data['last_name'];
			}
		}
		
		if(!empty($data['mobile'])){
			$mobile = '';
			if(!empty($data['mobile_code'])){
				$mobile = $data['mobile_code'];
			}
			$mobile .= $data['mobile'];
			$data_arr['PHONE'] = [ [ "VALUE"=> $mobile,"VALUE_TYPE"=> "WORK" ] ];
			$existed_lead = $this->get_lead_by_mobile($mobile);
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
		//responsible
		$data_arr['ASSIGNED_BY_ID'] = 422;

		if(!empty($data['city']) ){
			if(strpos($data['city'], 'alex')!==false){
				$data_arr['ASSIGNED_BY_ID'] = 9551;
			}
			$data_arr['UF_CRM_1695279678041'] = $data['city'];
		}
		if(!empty($data['current_status']) ){
			$data_arr['UF_CRM_1695270017192'] = $data['current_status'];
		}
		$data_arr['SOURCE_ID'] = 'CALL';

		$data_arr['STATUS_ID'] = 'NEW';
		$data_arr['OPENED'] = 'Y';
		
		$api_name = 'crm.lead.add';
		$options = [];
		if(!empty($existed_lead['data'][0]['ID'])){
			$options['id'] = $existed_lead['data'][0]['ID'];
			$api_name = 'crm.lead.update';
			if(!empty($existed_lead['data'][0]['STATUS_ID'])){
				$current_status = $existed_lead['data'][0]['STATUS_ID'];
				if(!in_array($current_status, ['JUNK','UC_0V372G','UC_UM2CL8']) ){
					$data_arr['ASSIGNED_BY_ID'] = $existed_lead['data'][0]['ASSIGNED_BY_ID'];
				}
			}
		}
		if(!empty($data_arr['TITLE'])){
			$options['fields'] =  $data_arr;
		}
		if(!empty($options)){
			$result = $this->bitrix_process_api($api_name,$options);
		}
	}

	function get_lead_by_mobile($mobile){
		$options = [
					// 'filter'=>['NAME'=>'Habiba Magdy Elbana']
			// https://besaeg.bitrix24.com/rest/9599/0v97c3ewjshg6a37/crm.lead.list.json?filter[PHONE]=201143118052
					'filter'=>['PHONE'=>$mobile]
					];
		$result = $this->bitrix_process_api('crm.lead.list',$options);
		return $result;
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