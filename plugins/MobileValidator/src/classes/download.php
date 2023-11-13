<?
/*
* Class has simple interface to download any file from a server
* without displaying the location of the file
*
* Author: Viatcheslav Ivanov, E-Witness Inc., Canada;
* mail: ivanov@e-witness.ca;
* web: www.e-witness.ca; www.coolwater.ca; www.strongpost.net;
* version: 1.1 /08.19.2002
*
*/



class download {
	var $df_path = "";
	var $df_contenttype = "";
	var $df_contentdisposition = "";
	var $df_filename = "";

	function download($df_path,  $df_filename = "",$df_contenttype = "Automatic", $df_contentdisposition = "attachment") {
		$this->df_path = $df_path;
		$exetenson=split("\.",$df_path);
		if(sizeof($exetenson)>0)
			$exetenson=$exetenson[sizeof($exetenson)-1];
		else 
			$exetenson="";
		
		if($df_contenttype=="Automatic") $this->df_contenttype=$this->GetContentType($exetenson);
		else 
		$this->df_contenttype=$df_contenttype;
		
		$this->df_contenttype = $df_contenttype;
		$this->df_contentdisposition = $df_contentdisposition;
		$this->df_filename = ($df_filename)? $df_filename : basename($df_path);
		if(strpos($this->df_filename,".")<1) $this->df_filename=$this->df_filename.".".$exetenson;
	}
	
	public function GetContentType($exetenson)
	{
		switch ($exetenson) {
			/*case "doc":
				return 'application/msword';
				break;
			case "pdf":
				return 'application/pdf';
				break;
			case "rtf":
				return 'application/rtf';
				break;*/
			default:
				return 'application/octet-stream';
				break;
		}
	}

	// check is specified file exists?
	function df_exists() {
		
		if (substr($this->df_path,-1)=="/") return false;
		if(file_exists($this->df_path))  return true;
		return false;
	}

	// get file size
	function df_size() {
		if($this->df_exists()) return filesize($this->df_path);
		return false;
	}

	// return permission number for user 'other'
	function df_permitother() {
		return substr(decoct(fileperms($this->df_path)),-1);
	}

	// download file
	function DownloadFile() {

		if($this->df_exists() && $this->df_permitother() >= 4) {
			header("Content-type: ".$this->df_contenttype);
			header("Content-Disposition: ".$this->df_contentdisposition."; filename=\"".$this->df_filename."\"");
			header("Content-Length: ".$this->df_size());
			
			$fp = readfile($this->df_path, "r");
			return $fp;
		}
		return false;
	}

}



?>