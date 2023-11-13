<?php

class email {

    /////////////////// //Assign Gifr message ///////////////////////////////

    const msg_subj1 = 'Regarding your Car Enquiry';
    const msg_body1 = '<br>
                      {$message}                
                      ';
    const msg_subj2 = '{$subject}';
    const msg_body2 = ' {$message} ';
    //////////////////////////////////////////////////////////////////////////


    public static function SendEmail($email_address, $msg_id, $parameters = false, $from_email = false, $to_admin = false) {
        global $site;
   
        if ($to_admin)
        $email_address = $site['from_mail'];

        if (!$from_email)
        $from_email =    $site['name'] .'<'.$site['from_mail'].'>';

        list ( $subj, $body ) = self::GetMessage ( $msg_id );
		
		
        return MyMail ( $email_address, $tmp = self::PreBody ( $subj, $parameters ), self::PreBody ( $body, $parameters ), "From: $from_email\nReply-To: $from_email\nContent-Type: text/html", $tmp );
    }
    public static function SendEmailWithAttachment($email_address, $msg_id, $parameters = false, $from_email = false, $to_admin = false, $atttachment_file, $file_name) {
        global $support_mail;
        if ($admin)
        $email_address = $support_mail;

        if (! $from_email)
        $from_email = $support_mail;

        list ( $subj, $body ) = self::GetMessage ( $msg_id );

        return SendMailWithStreamAttach ( $from_email, $email_address, $tmp = self::PreBody ( $subj, $parameters ), self::PreBody ( $body, $parameters ), $atttachment_file, $file_name );
    }

    public static function PreBody($body, $parameters) {

        global $script_url;
        $parameters = array_merge ( $parameters, array ('script_url' => $script_url ) );
        foreach ( $parameters as $key => $value ) {
            $body = str_replace ( '{$' . $key . '}', $value, $body );
        }
        return $body;
    }

    public static function GetMessage($msg_id) {
        return array (constant ( "email::msg_subj$msg_id" ), constant ( "email::msg_body$msg_id" ) );
    }

}

?>