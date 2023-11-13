<?
//echo 'Hallo World';
include('SmsInterface.inc');
	$si = new SmsInterface (false, false);
        $si->addMessage(' 0407206441', 'Hallo there','314135121',0,169,false);
        	if (!$si->connect ('Australianfle004', '0365258', true, false))
		$log.= "failed. Could not contact server.\r\n";
                elseif (!$si->sendMessages ()) {
			
			$log.= "failed. Could not send message to server.\r\n";
			if ($si->getResponseMessage () !== NULL)
			$log.= "\nReason: " . $si->getResponseMessage () . "\r\n";
		} 
                
                echo nl2br($log);



?>
