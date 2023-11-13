<?php

//Used To Upload File
/* Arguments:    $file_id- The name of the input field contianing the file.
 *                $folder    - The folder to which the file should be uploaded to - it must be writable. OPTIONAL
 *                $types    - A list of comma(,) seperated extensions that can be uploaded. If it is empty, anything goes OPTIONAL
 * Returns  : This is somewhat complicated - this function returns an array with two values...
 *                The first element is randomly generated filename to which the file was uploaded to.
 *                The second element is the status - if the upload failed, it will be 'Error : Cannot upload the file 'name.txt'.' or something like that
 */
function Upload($file_id, $folder = "", $types = "", $maxsize = 5000000, $file_name = '') {
    if (!$_FILES[$file_id]['name'])
        return array('', 'No file specified');

    $file_title = $_FILES[$file_id]['name'];
    $file_size = $_FILES[$file_id]['size'];

    if ($file_size > $maxsize) {
        $result = "'" . $_FILES[$file_id]['name'] . "' File Size Is larger than Max Size:" . round($maxsize / 1024) . " Kb"; //Show error if any.
        return array('', $result);
    }

    //Get file extension
    $ext_arr = split("\.", basename($file_title));
    $ext = strtolower($ext_arr[count($ext_arr) - 1]); //Get the last extension
    //Not really uniqe - but for all practical reasons, it is
    $uniqer = substr(md5(uniqid(rand(), 1)), 0, 5);
    if ($file_name == '')
        $file_name = $uniqer . '_' . $file_title; //Get Unique Name
    else
        $file_name.="." . $ext;

    $all_types = explode(",", strtolower($types));
    if ($types) {
        if (in_array($ext, $all_types))
            ;
        else {
            $result = "'" . $_FILES[$file_id]['name'] . "' is not a valid file, only " . strtoupper($types) . " fromats are allowed"; //Show error if any.
            return array('', $result);
        }
    }

    //Where the file must be uploaded to
    if ($folder)
        $folder .= '/'; //Add a '/' at the end of the folder
    $uploadfile = $folder . $file_name;


    $result = '';
    //Move the file from the stored location to the new location
    if (!move_uploaded_file($_FILES[$file_id]['tmp_name'], $uploadfile)) {
        $result = "Cannot upload the file '" . $_FILES[$file_id]['name'] . "'"; //Show error if any.
        if (!file_exists($folder)) {
            $result .= " : Folder don't exist.";
        } elseif (!is_writable($folder)) {
            $result .= " : Folder not writable.";
        } elseif (!is_writable($uploadfile)) {
            $result .= " : File not writable.";
        }
        $file_name = '';
    } else {
        if (!$_FILES[$file_id]['size']) { //Check if the file is made
            @unlink($uploadfile); //Delete the Empty file
            $file_name = '';
            $result = "Empty file found - please use a valid file."; //Show the error message
        } else {
            chmod($uploadfile, 0777); //Make it universally writable.
        }
    }

    return array($file_name, $result);
}

//resize -> 0 no resizing , 1 -> resize image with the first width w ,and height H,
//2 -> resize image with the width w and height H  , and make a Thumb copy whith
// width w1 height H1
function UploadImage($file_id, $folder = "", $types = "", $maxsize = 5000000, $file_name = '', $resize = 0, $w = 0, $h = 0, $w1 = 0, $h1 = 0, $related_ratio = 0, $aspect_w = 0, $aspect_h = 0, $validity = 0.05) {
    $windows = 1;
    if (!$_FILES[$file_id]['name'])
        return array('', 'No file specified');

    $file_title = $_FILES[$file_id]['name'];
    $file_size = $_FILES[$file_id]['size'];

    if ($file_size > $maxsize) {
        $result = "'" . $_FILES[$file_id]['name'] . "' File Size Is larger than Max Size:" . round($maxsize / 1024) . " Kb"; //Show error if any.
        return array('', $result);
    }

    if ($related_ratio == 1) {
        list($width, $height, $type, $attr) = getimagesize($_FILES[$file_id]['tmp_name']);

        $exp_width = $width / $aspect_w;
        $exp_height = $exp_width * $aspect_h;
        if (abs($exp_height - $height) > $validity * $exp_height) {
            if ($aspect_h == $aspect_w)
                $result = "'" . $_FILES[$file_id]['name'] . "Sorry the image upload for (" . $_FILES[$file_id][name] . ") failed: image ratio/size does not match the required aspect ratio 1:1 (Square Image). Please resize to upload."; //Show error if any.
            else
                $result = "Sorry the image upload for (" . $_FILES[$file_id][name] . ") failed: image ratio/size does not match the required aspect ratio $aspect_w:$aspect_h. Please resize to upload."; //Show error if any.
            return array('', $result);
        }
    }

    //Get file extension
    $ext_arr = split("\.", basename($file_title));
    $ext = strtolower($ext_arr[count($ext_arr) - 1]); //Get the last extension
    //Not really uniqe - but for all practical reasons, it is
    $uniqer = substr(md5(uniqid(rand(), 1)), 0, 5);
    if ($file_name == '')
        $file_name = $uniqer . '_' . $file_title; //Get Unique Name
    else
        $file_name.="." . $ext;
    $file_name = str_replace(" ", "_", $file_name);
    $special = array('/', '!', '&', '*', '~', '#', '$', '%', '^', '(', ')', '-', '<', '>', '?', '@', '+', '|', '=', '/', '\\', '"', '\'', '[', ']', '{', '}', ':', ';', ',');
    $file_name = str_replace($special, '_', $file_name);

    $all_types = explode(",", strtolower($types));
    if ($types) {
        if (in_array($ext, $all_types))
            ;
        else {
            $result = "'" . $_FILES[$file_id]['name'] . "' is not a valid file."; //Show error if any.
            return array('', $result);
        }
    }

    //Where the file must be uploaded to
    if ($folder)
        $folder .= '/'; //Add a '/' at the end of the folder
    $uploadfile = $folder . $file_name;
    $thumb_uploadfile = $folder . 'thumb_' . $file_name;

    $result = '';
    //Move the file from the stored location to the new location
    if (!move_uploaded_file($_FILES[$file_id]['tmp_name'], $uploadfile)) {
        $result = "Cannot upload the file '" . $_FILES[$file_id]['name'] . "'"; //Show error if any.
        if (!file_exists($folder)) {
            $result .= " : Folder don't exist.";
        } elseif (!is_writable($folder)) {
            $result .= " : Folder not writable.";
        } elseif (!is_writable($uploadfile)) {
            $result .= " : File not writable.";
        }
        $file_name = '';
    } else {
        if (!$_FILES[$file_id]['size']) { //Check if the file is made
            @unlink($uploadfile); //Delete the Empty file
            $file_name = '';
            $result = "Empty file found - please use a valid file."; //Show the error message
        } else {

            chmod($uploadfile, 0777); //Make it universally writable.
            //Resizing the image
            if ($resize == 1 || $resize == 2) {
                if (!smart_resize_image($uploadfile, $w, $h, true))
                    $result .= 'Could not resize original image to ' . $w . 'x' . $h;
            }


            if ($resize == 2) {
                if (!smart_resize_image($uploadfile, $w1, $h1, true, $thumb_uploadfile))
                    $result .= 'Could not resize original image to ' . $w1 . 'x' . $h1 . ' ( Image ' . "[$cmdStatus] )";
            }
        }
    }

    return array($file_name, $result);
}

function smart_resize_image($file, $width = 0, $height = 0, $proportional = false, $output = 'file', $file_name = false) {
    if ($height <= 0 && $width <= 0) {
        return false;
    }


    $info = getimagesize($file);
    $image = '';


    $final_width = 0;
    $final_height = 0;
    list($width_old, $height_old) = $info;

    if (
            $proportional) {
        if ($width == 0)
            $factor = $height / $height_old;
        elseif ($height == 0)
            $factor = $width / $width_old;
        else
            $factor = min($width / $width_old, $height / $height_old);


        $final_width = round($width_old * $factor);
        $final_height = round($height_old * $factor);
    }
    else {

        $final_width = ( $width <= 0 ) ? $width_old : $width;
        $final_height = ( $height <= 0 ) ? $height_old : $height;
    }

    switch (
    $info[2]) {
        case IMAGETYPE_GIF:
            $image = imagecreatefromgif($file);
            break;
        case IMAGETYPE_JPEG:
            $image = imagecreatefromjpeg($file);
            break;
        case IMAGETYPE_PNG:
            $image = imagecreatefrompng($file);
            break;
        default:
            return false;
    }

    $image_resized = imagecreatetruecolor($final_width, $final_height);

    if (($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG)) {
        $trnprt_indx = imagecolortransparent($image);

        // If we have a specific transparent color
        if ($trnprt_indx >= 0) {

            // Get the original image's transparent color's RGB values
            $trnprt_color = imagecolorsforindex($image, $trnprt_indx);

            // Allocate the same color in the new image resource
            $trnprt_indx = imagecolorallocate($image_resized, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);

            // Completely fill the background of the new image with allocated color.
            imagefill($image_resized, 0, 0, $trnprt_indx);

            // Set the background color for new image to transparent
            imagecolortransparent($image_resized, $trnprt_indx);
        }
        // Always make a transparent background color for PNGs that don't have one allocated already
        elseif ($info[2] == IMAGETYPE_PNG) {

            // Turn off transparency blending (temporarily)
            imagealphablending($image_resized, false);

            // Create a new transparent color for image
            $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);

            // Completely fill the background of the new image with allocated color.
            imagefill($image_resized, 0, 0, $color);

            // Restore transparency blending
            imagesavealpha($image_resized, true);
        }
    }


    imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);

    if ($delete_original) {
        if ($use_linux_commands)
            exec('rm ' . $file);
        else
            @unlink($file);
    }

    switch (strtolower($output)) {
        case 'browser':
            $mime = image_type_to_mime_type($info[2]);
            header("Content-type: $mime");
            $output = NULL;
            break;
        case 'file':
            $output = ($file_name ? $file_name : $file);
            break;
        case 'return':
            return $image_resized;
            break;
        default:
            break;
    }

    switch (
    $info[2]) {
        case IMAGETYPE_GIF:
            imagegif($image_resized, $output);
            break;
        case IMAGETYPE_JPEG:
            imagejpeg($image_resized, $output);
            break;
        case IMAGETYPE_PNG:
            imagepng($image_resized, $output);
            break;
        default:
            return false;
    }

    return
            true;
}

function ListSelectOptions($str, $str2 = "", $selected = "") {
    $items = explode(",", $str);
    $items2 = explode(",", $str2);
    $i = 0;
    $List = "";
    while ($items[$i]) {

        if ($items[$i] == $selected)
            $sel = "selected";
        else
            $sel = "";
        if ($selected == "" && $i == 0)
            $sel = "selected";
        $List.= "<option value=\"$items[$i]\" title=\"$items2[$i]\" $sel>$items[$i]</option>\n";
        $i++;
    }
    return $List;
}

function MyMD5($id, $key = "MYNAMEISMOHY") {
    return md5(md5($id) ^ md5($key));
}

function SendMailWithAttach($from, $to, $subject, $msg, $files1 = "", $files2 = "", $files3 = "", $files4 = "", $files5 = "") {
    if ($files1["tmp_name"] != "") {
        $fileatt1 = $files1["tmp_name"]; // Path to the file
        $fileatt_type1 = "application/octet-stream"; // File Type
        $fileatt_name1 = $files1["name"]; // Filename that will be used for the file as the attachment
    }

    if ($files2["tmp_name"] != "") {
        $fileatt2 = $files2["tmp_name"]; // Path to the file
        $fileatt_type2 = "application/octet-stream"; // File Type
        $fileatt_name2 = $files2["name"]; // Filename that will be used for the file as the attachment
    }

    if ($files3["tmp_name"] != "") {
        $fileatt3 = $files3["tmp_name"]; // Path to the file
        $fileatt_type3 = "application/octet-stream"; // File Type
        $fileatt_name3 = $files3["name"]; // Filename that will be used for the file as the attachment
    }

    if ($files4["tmp_name"] != "") {
        $fileatt4 = $files4["tmp_name"]; // Path to the file
        $fileatt_type4 = "application/octet-stream"; // File Type
        $fileatt_name4 = $files4["name"]; // Filename that will be used for the file as the attachment
    }

    if ($files5["tmp_name"] != "") {
        $fileatt5 = $files5["tmp_name"]; // Path to the file
        $fileatt_type5 = "application/octet-stream"; // File Type
        $fileatt_name5 = $files5["name"]; // Filename that will be used for the file as the attachment
    }

    $email_from = $from; // Who the email is from
    $email_subject = $subject; // The Subject of the email
    $email_txt = $msg; // Message that the email has in it

    $email_to = $to; // Who the email is too

    $headers = "From: " . $email_from;


    if ($files1["tmp_name"] != "") {
        $file1 = fopen($fileatt1, 'rb');
        $data1 = fread($file1, filesize($fileatt1));
        fclose($file1);
    }

    if ($files2["tmp_name"] != "") {
        $file2 = fopen($fileatt2, 'rb');
        $data2 = fread($file2, filesize($fileatt2));
        fclose($file2);
    }

    if ($files3["tmp_name"] != "") {
        $file3 = fopen($fileatt3, 'rb');
        $data3 = fread($file3, filesize($fileatt3));
        fclose($file3);
    }

    if ($files4["tmp_name"] != "") {
        $file4 = fopen($fileatt4, 'rb');
        $data4 = fread($file4, filesize($fileatt4));
        fclose($file4);
    }

    if ($files5["tmp_name"] != "") {
        $file5 = fopen($fileatt5, 'rb');
        $data5 = fread($file5, filesize($fileatt5));
        fclose($file5);
    }

    $semi_rand = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

    $headers .= "\nMIME-Version: 1.0\n" .
            "Content-Type: multipart/mixed;\n" .
            " boundary=\"{$mime_boundary}\"";

    $email_message .= "This is a multi-part message in MIME format.\n\n" .
            "--{$mime_boundary}\n" .
            "Content-Type:text/html; charset=\"iso-8859-1\"\n" .
            "Content-Transfer-Encoding: 7bit\n\n" .
            $email_txt . "\n\n";



    if ($files1["tmp_name"] != "") {
        $data1 = chunk_split(base64_encode($data1));
        $email_message .= "--{$mime_boundary}\n" .
                "Content-Type: {$fileatt_type1};\n" .
                " name=\"{$fileatt_name1}\"\n" .
                //"Content-Disposition: attachment;\n" .
                //" filename=\"{$fileatt_name}\"\n" .
                "Content-Transfer-Encoding: base64\n\n" .
                $data1 . "\n\n";
    }

    if ($files2["tmp_name"] != "") {
        $data2 = chunk_split(base64_encode($data2));
        $email_message .= "--{$mime_boundary}\n" .
                "Content-Type: {$fileatt_type2};\n" .
                " name=\"{$fileatt_name2}\"\n" .
                //"Content-Disposition: attachment;\n" .
                //" filename=\"{$fileatt_name}\"\n" .
                "Content-Transfer-Encoding: base64\n\n" .
                $data2 . "\n\n";
    }

    if ($files3["tmp_name"] != "") {
        $data3 = chunk_split(base64_encode($data3));
        $email_message .= "--{$mime_boundary}\n" .
                "Content-Type: {$fileatt_type3};\n" .
                " name=\"{$fileatt_name3}\"\n" .
                //"Content-Disposition: attachment;\n" .
                //" filename=\"{$fileatt_name}\"\n" .
                "Content-Transfer-Encoding: base64\n\n" .
                $data4 . "\n\n";
    }

    if ($files4["tmp_name"] != "") {
        $data4 = chunk_split(base64_encode($data4));
        $email_message .= "--{$mime_boundary}\n" .
                "Content-Type: {$fileatt_type4};\n" .
                " name=\"{$fileatt_name4}\"\n" .
                //"Content-Disposition: attachment;\n" .
                //" filename=\"{$fileatt_name}\"\n" .
                "Content-Transfer-Encoding: base64\n\n" .
                $data4 . "\n\n";
    }

    if ($files5["tmp_name"] != "") {
        $data5 = chunk_split(base64_encode($data5));
        $email_message .= "--{$mime_boundary}\n" .
                "Content-Type: {$fileatt_type5};\n" .
                " name=\"{$fileatt_name5}\"\n" .
                //"Content-Disposition: attachment;\n" .
                //" filename=\"{$fileatt_name}\"\n" .
                "Content-Transfer-Encoding: base64\n\n" .
                $data5 . "\n\n";
    }
    $email_message.="--{$mime_boundary}--\n";

    $ok = mail($email_to, $email_subject, $email_message, $headers);

    if ($ok)
        return 0;
    else
        return 1;
}

//Used To Round the Money
function Money($str) {
    $money = number_format($str, 2, '.', '');
    if ($money < $str)
        $money+=0.01;
    return "$" . $money;
}

function DrawImage($FileName, $MaxWidth, $extra = "", $mode = "echo") {
    if (is_file($FileName)) {
        list($width, $height, $type, $attr) = getimagesize($FileName);
        if ($width > $MaxWidth)
            $width = $MaxWidth;
    }
    if ($mode == "echo")
        echo '<img src="' . $FileName . '" width=' . $width . ' ' . $extra . ' border=0 >';
    else
        return '<img src="' . $FileName . '" width=' . $width . ' ' . $extra . ' border=0 >';
}

function DrawImage2($FileName, $MaxHeight, $extra = "", $mode = "echo") {
    if (is_file($FileName)) {
        list($width, $height, $type, $attr) = getimagesize($FileName);
        if ($height > $MaxHeight)
            $height = $MaxHeight;
        if ($mode == "echo")
            echo '<img src="' . $FileName . '" height=' . $height . ' border=0 ' . $extra . ' >';
        else
            return '<img src="' . $FileName . '" height=' . $height . ' border=0 ' . $extra . ' >';
    }
}

function MyMail($to, $object, $message, $head, $title = "", $parameters = null) {
    $message = MailHead($title) . $message . MailFoot();
    //echo "TO :$to<br>TITLE:$object<BR>FORM:$head<BR>MESSAGE:<BR>$message";
    $object = "Ozcar: " . $object;


    file_put_contents($predir . 'admin/emails.html', "TO :$to<br>TITLE:$title<BR>FORM:$head<BR>MESSAGE:<BR>$message<br/><br/><br/>----------------------------------------------------<br/><br/><br/>", FILE_APPEND);
    if ($_SERVER['REMOTE_ADDR'] == '41.152.42.78') {
        //echo ($message); 
    }
    return mail($to, $object, $message, $head, $parameters);
}

function PreForm($str) {
    $str = htmlspecialchars_decode($str);
    return htmlspecialchars($str);
}

function PostForm($str, $maxlenth = 99999999) {
    if (get_magic_quotes_gpc() == 1)
        $str = stripcslashes($str);
    if (strlen($str) > $maxlenth)
        $str = substr($str, 0, $maxlenth);
    return $str;
}

function PreSql($str, $removecode = 1) {
    if ($removecode == 1) {
        $str = htmlspecialchars_decode($str);
        $str = htmlspecialchars($str);
    }
    $str = addslashes($str);
    return $str;
}

function HiddenText($name, $value, $extra = "") {
    echo "\n" . '<input type="hidden" name="' . $name . '" value="' . $value . '"  ' . $extra . ' />';
}

function HiddenForm($action = "", $method = "POST", $extra = "") {
    echo '<form action="' . $action . '" method="' . $method . '">';
}

function CloseHiddenForm($extra = "") {
    echo $extra . '</form>';
}

function HideCCNo($no) {
    return substr($no, 0, 4) . "-" . str_repeat("*", 4) . "-" . str_repeat("*", 4) . "-" . str_repeat("*", 4);
}

function DatabaseLastUpdate() {

    global $db, $dbname;
    $result = $db->sql_query("SHOW TABLE STATUS FROM `$dbname` ");
    $max_dt = 0;
    while ($row = $db->sql_fetchrow($result)) {

        $tmp_dt = strtotime($row['Update_time']);
        if ($tmp_dt > $max_dt)
            $max_dt = $tmp_dt;
    }
    $last_date = getdate($max_dt);
    return $last_date['year'] . "-" . $last_date['mon'] . "-" . $last_date['mday'] . " " . $last_date['hours'] . ":" . $last_date['minutes'] . ":" . $last_date['seconds'];
}

function curPageUrl() {
    $pageUrl = 'http';
    if ($_SERVER["HTTPS"] == "on") {
        $pageUrl .= "s";
    }
    $pageUrl .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageUrl .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageUrl .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageUrl;
}

function radio_checked($value, $str) {
    if ($str == $value)
        echo "checked=\"checked\"";
}

function select_item($value, $str) {
    if ($str == $value)
        return "selected=\"selected\"";
}

function checked($str) {
    if ($str)
        echo "checked=\"checked\"";
}

function ListOptions($arr_items, $arr_values, $sel = "", $ret = false) {

    for ($i = 0; $i < sizeof($arr_items); $i++)
        $LIST.= "<option value=\"$arr_values[$i]\" " . select_item($sel, $arr_values[$i]) . " >$arr_items[$i]</option> \n";

    if ($ret)
        return $LIST;
    else
        echo $LIST;
}

function ListMultiOptions($arr_items, $arr_values, $sel = "") {
    $sel = ' ,' . $sel . ', ';
    for ($i = 0; $i < sizeof($arr_items); $i++) {
        if (strpos($sel, ",{$arr_values[$i]},") > 0)
            $selected = ' selected="selected" ';
        else
            $selected = '';
        echo "<option value=\"$arr_values[$i]\" $selected >$arr_items[$i]</option> \n";
    }
}

function _lang($token) {
    global $_LANG;
    if (!isset($_LANG[$token])) {
        $err = debug_backtrace();
        $err_line = $err[0][line];
        $err_file = $err[0][file];

//		trigger_error("Can not find token '<b>$token</b>' in <b>$err_file</b> on <b>$err_line</b> ",E_USER_WARNING);
        return $token;
    }

    return $_LANG[$token];
}

function my_is_integer($str) {
    if (preg_match("/^([0123456789]+)$/", $str))
        return true;
    else
        return false;
}

function session_started() {

    if (isset($_SESSION)) {
        return true;
    } else {
        return false;
    }
}

function CutLongerThan($str, $long) {
    if (strlen($str) <= $long)
        return $str;
    else
        return substr($str, 0, $long - 3) . "...";
}

function IsNewDay() {
    global $predir;
    include($predir . "last_day.php");

    if (date("Y-m-d") == $last_date)
        return false;
    $file = fopen($predir . "last_day.php", "w") or die("can't open 'last_day.php' file");
    fwrite($file, "<?php " . date("Y-m-d") . " ?>") or die("can't write on 'last_day.php' file");
    return true;
}

function GetUnlimitedCount($query) {
    global $db;

    $query = str_replace('_from', '!$#SC', $query);
    if (!ereg("(SELECT|Select|select)((.)+)(FROM|From|from)((.)+)(ORDER |Order |order )((.)+)(LIMIT|Limit|limit)((.)+)", $query, $arr))
        ereg("(SELECT|Select|select)((.)+)(FROM|From|from)((.)+)(LIMIT|Limit|limit)((.)+)", $query, $arr);
    $arr[2] = str_replace("* ", "' '", $arr[2]);
    $sql = "$arr[1] COUNT(*),'1' as `ss_ss`, $arr[2] $arr[3] $arr[4] $arr[5] $arr[6] GROUP BY `ss_ss` LIMIT 0,1";
    $sql = str_replace('!$#SC', '_from', $sql);


    $result = $db->sql_query($sql) OR die($sql . "<br/>" . $db->sql_error_msg($result));
    $row = $db->sql_fetchrow($result);

    return $row[0];
}

function MysqlGetUnlimitedCount($query) {
    global $mysql_db;
    if (!ereg("(SELECT|Select|select)((.)+)(FROM|From|from)((.)+)(ORDER |Order |order )((.)+)(LIMIT|Limit|limit)((.)+)", $query, $arr))
        ereg("(SELECT|Select|select)((.)+)(FROM|From|from)((.)+)(LIMIT|Limit|limit)((.)+)", $query, $arr);
    $arr[2] = str_replace("* ", "' '", $arr[2]);
    $sql = "$arr[1] COUNT(*),'1' as `ss_ss`, $arr[2] $arr[3] $arr[4] $arr[5] $arr[6] GROUP BY `ss_ss` LIMIT 0,1";



    $result = $mysql_db->sql_query($sql) OR die($sql . "<br/>" . $mysql_db->sql_error_msg($result));
    $row = $mysql_db->sql_fetchrow($result);

    return $row[0];
}

function PageCount($item_count, $no_per_page) {
    return ($item_count / $no_per_page == floor($item_count / $no_per_page)) ?
            ($item_count / $no_per_page) : (floor($item_count / $no_per_page) + 1);
}

function AddQueryToUrl($url, $q) {
    if (strtolower(substr($url, -3)) == "php" || strtolower(substr($url, -1)) == "/") {
        return ($url . "?" . $q);
    }
    else
        return ($url . "&" . $q);
}

function MYSQL2PG($sql) {

    $sql = str_replace("`", "\"", $sql);
    $sql = str_replace('\'\'', "NULL", $sql);

    $sql = preg_replace("/LIMIT ([0-9]+),([ 0-9]+)/", "LIMIT \\2 OFFSET \\1", $sql);
    return $sql;
}

function mrand($l, $h, $t, $len = false, $exclude = -999) {
    if ($l > $h) {
        $a = $l;
        $b = $h;
        $h = $a;
        $l = $b;
    }
    if ((($h - $l) + 1) < $t || $t <= 0)
        return false;

    $n = array();
    if ($len > 0) {
        if (strlen($h) < $len && strlen($l) < $len)
            return false;

        if (strlen($h - 1) < $len && strlen($l - 1) < $len && $t > 1)
            return false;

        do {
            $x = rand($l, $h);
            if (!in_array($x, $n) && strlen($x) == $len)
                $n[] = $x;
        }
        while (count($n) < $t);
    }
    else {
        do {
            $x = rand($l, $h);
            if (!in_array($x, $n) && $exclude != $x)
                $n[] = $x;
        }
        while (count($n) < $t);
    }
    return $n;
}

function sort2d_asc(&$arr, $key) {
    //we loop through the array and fetch a value that we store in tmp 
    for ($i = 0; $i < count($arr); $i++) {
        $tmp = $arr[$i];
        $pos = false;
        //we check if the key we want to sort by is a string 
        $str = is_numeric($tmp[$key]);
        if (!$str) {
            //we loop the array again to compare against the temp value we have 
            for ($j = $i; $j < count($arr); $j++) {
                if (StringManip::is_date($tmp[$key])) {
                    if (StringManip::compareDates($arr[$j][$key], $tmp[$key], $type = 'asc')) {
                        $tmp = $arr[$j];
                        $pos = $j;
                    }
                    //we string compare, if the string is "smaller" it will be assigned to the temp value   
                } else if (strcasecmp($arr[$j][$key], $tmp[$key]) < 0) {
                    $tmp = $arr[$j];
                    $pos = $j;
                }
            }
        } else {
            for ($j = $i; $j < count($arr); $j++) {
                if ($arr[$j][$key] < $tmp[$key]) {
                    $tmp = $arr[$j];
                    $pos = $j;
                }
            }
        }
        if ($pos !== false) {
            $arr[$pos] = $arr[$i];
            $arr[$i] = $tmp;
        }
    }
}

function multi2dSortAsc(&$arr, $key) {
    $sort_col = array();
    foreach ($arr as $sub)
        $sort_col[] = $sub[$key];
    array_multisort($sort_col, $arr);
}

function preparePassedValue($value) {
    return urlencode(base64_encode($value));
}

function getPassedValue($value) {
    return urldecode(base64_decode($value));
}

if (!function_exists('json_encode')) {

    function json_encode($a = false) {
        if (is_null($a))
            return 'null';
        if ($a === false)
            return 'false';
        if ($a === true)
            return 'true';
        if (is_scalar($a)) {
            if (is_float($a)) {
                // Always use "." for floats.
                return floatval(str_replace(",", ".", strval($a)));
            }

            if (is_string($a)) {
                static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
                return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
            }
            else
                return $a;
        }
        $isList = true;
        for ($i = 0, reset($a); $i < count($a); $i++, next($a)) {
            if (key($a) !== $i) {
                $isList = false;
                break;
            }
        }
        $result = array();
        if ($isList) {
            foreach ($a as $v)
                $result[] = json_encode($v);
            return '[' . join(',', $result) . ']';
        } else {
            foreach ($a as $k => $v)
                $result[] = json_encode($k) . ':' . json_encode($v);
            return '{' . join(',', $result) . '}';
        }
    }

}

function OptionsList($arr, $selected = false) {

    foreach ($arr as $k => $v)
        $List.= '<option value="' . $k . '" title="' . $v . '" ' . ($selected == $k ? 'Selected' : '') . ' >' . $v . '</option>' . "\n";
    $i++;

    return $List;
}

?>
