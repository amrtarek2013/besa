<?php
set_time_limit(3600);
require_once 'Spreadsheet/Excel/Writer.php';
/**
Expanded And Modefied By Mohammed Mohy Azzam
The Bug Of Culomn starting with spaces was fixed

**/

/**
 *  IAM_CSVDump A class form performing a query dump and sending it to the browser or setting it or download.
 *  @package    iam_csvdump
 */

 /**
 *  IAM_CSVDump A class form performing a query dump and sending it to the browser or setting it or download.
 *  @author     Iv�n Ariel Melgrati <phpclasses@imelgrat.mailshell.com> - Postgre DB Handling by Umar Sear
 *  @package    iam_csvdump
 *  @version 1.0
 *
 *  IAM_CSVDump A class form performing a query dump and sending it to the browser or setting it or download.
 *
 *  Browser and OS detection for appropriate handling of download and EOL chars.
 *
 *  Requires PHP v 4.0+ and MySQL 3.23+. Some portions taken from the CSV_UTIL_CLASS by Andrej Arn <andrej@blueshoes.org>.
 *
 *  This library is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU Lesser General Public
 *  License as published by the Free Software Foundation; either
 *  version 2 of the License, or (at your option) any later version.
 *
 *  This library is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 *  Lesser General Public License for more details.
 *  Modified by Umar Sear <umarsear@gmail.com> 10/06/2006 to use Postgres instead of MySQL - 10/06/2006
 */
 
class xls_exporter
{
    /**
    * @desc Takes an array and creates a csv string from it.
    *
    * @access public
    * @param  Array  $array (see below)
    * @param  String $separator Field separator ()default is ';')
    * @param  String $trim  If the cells should be trimmed , default is 'both'. It can also be 'left', 'right' or 'both'. 'none' makes it faster since omits many function calls.
    * @param  Boolean   $removeEmptyLines (default is TRUE. removes "lines" that have no value, would come out empty.)
    * @return String A CSV String. It returns an empty string if there Array is empty (NULL)
    * @todo Add param "fill to fit max length"?
    */
    function arrayToCsvString($array, $separator=';', $trim='both', $removeEmptyLines=TRUE)
    {
    if (!is_array($array) || empty($array)) return '';

    switch ($trim) {
      case 'none':
        $trimFunction = FALSE;
        break;
      case 'left':
        $trimFunction = 'ltrim';
        break;
      case 'right':
        $trimFunction = 'rtrim';
        break;
      default: //'both':
        $trimFunction = 'trim';
        break;
    }
    $ret = array();
    reset($array);
    if (is_array(current($array)))
    {
      while (list(,$lineArr) = each($array))
      {
        if (!is_array($lineArr))
        {
          //Could issue a warning ...
          $ret[] = array();
        }
        else
        {
          $subArr = array();
          while (list(,$val) = each($lineArr))
          {
            $val      = $this->_valToCsvHelper($val, $separator, $trimFunction);
            $subArr[] = $val;
          }
        }
        $ret[] = join($separator, $subArr);
      }
     $crlf = $this->_define_newline();
     return join($crlf, $ret);
    } else
    {
      while (list(,$val) = each($array))
      {
        $val   = $this->_valToCsvHelper($val, $separator, $trimFunction);
        $ret[] = $val;
      }
      return join($separator, $ret);
    }
    }

    /**
    * @desc Works on a string to include in a csv string.
    * @access private
    * @param  String $val
    * @param  String $separator
    * @param  Mixed  $trimFunction If the cells should be trimmed , default is 'both'. It can also be 'left', 'right' or 'both'. 'none' makes it faster since omits many function calls.
    * @return String
    * @see    arrayToCsvString()
    */
    function _valToCsvHelper($val, $separator, $trimFunction) {
    if ($trimFunction) $val = $trimFunction($val);
    //If there is a separator (;) or a quote (") or a linebreak in the string, we need to quote it.
    $needQuote = FALSE;
    do {
      if (strpos($val, '"') !== FALSE) {
        $val = str_replace('"', '""', $val);
        $needQuote = TRUE;
        break;
      }
      if (strpos($val, $separator) !== FALSE) {
        $needQuote = TRUE;
        break;
      }
      if ((strpos($val, "\n") !== FALSE) || (strpos($val, "\r") !== FALSE)) { // \r is for mac
        $needQuote = TRUE;
        break;
      }
    } while (FALSE);
    if ($needQuote) {
      $val = '"' . $val . '"';
    }
    return $val;
    }

    /**
    * @desc Define EOL character according to target OS
    * @access private
    * @return String A String containing the End Of Line Sequence corresponding to the client's OS
    */
    function _define_newline()
    {
         $unewline = "\r\n";

         if (strstr(strtolower($_SERVER["HTTP_USER_AGENT"]), 'win'))
         {
            $unewline = "\r\n";
         }
         else if (strstr(strtolower($_SERVER["HTTP_USER_AGENT"]), 'mac'))
         {
            $unewline = "\r";
         }
         else
         {
            $unewline = "\n";
         }

         return $unewline;
    }

    /**
    * @desc Define the client's browser type
    * @access private
    * @return String A String containing the Browser's type or brand
    */
    function _get_browser_type()
    {
        $USER_BROWSER_AGENT="";

        if (ereg('OPERA(/| )([0-9].[0-9]{1,2})', strtoupper($_SERVER["HTTP_USER_AGENT"]), $log_version))
        {
            $USER_BROWSER_AGENT='OPERA';
        }
        else if (ereg('MSIE ([0-9].[0-9]{1,2})',strtoupper($_SERVER["HTTP_USER_AGENT"]), $log_version))
        {
            $USER_BROWSER_AGENT='IE';
        }
        else if (ereg('OMNIWEB/([0-9].[0-9]{1,2})', strtoupper($_SERVER["HTTP_USER_AGENT"]), $log_version))
        {
            $USER_BROWSER_AGENT='OMNIWEB';
        }
        else if (ereg('MOZILLA/([0-9].[0-9]{1,2})', strtoupper($_SERVER["HTTP_USER_AGENT"]), $log_version))
        {
            $USER_BROWSER_AGENT='MOZILLA';
        }
        else if (ereg('KONQUEROR/([0-9].[0-9]{1,2})', strtoupper($_SERVER["HTTP_USER_AGENT"]), $log_version))
        {
            $USER_BROWSER_AGENT='KONQUEROR';
        }
        else
        {
            $USER_BROWSER_AGENT='OTHER';
        }

        return $USER_BROWSER_AGENT;
    }

    /**
    * @desc Define MIME-TYPE according to target Browser
    * @access private
    * @return String A string containing the MIME-TYPE String corresponding to the client's browser
    */
    function _get_mime_type()
    {
        $USER_BROWSER_AGENT= $this->_get_browser_type();

        $mime_type = ($USER_BROWSER_AGENT == 'IE' || $USER_BROWSER_AGENT == 'OPERA')
                       ? 'application/octetstream'
                       : 'application/octet-stream';
        return $mime_type;
    }

    /**
    * @desc Generates a CSV File from an SQL String (and outputs it to the browser)
    * @access private
    * @param  String $dbname Name of the Database
    * @param  String $user User to Access the Database
    * @param  String $password Password to Access the Database
    * @param  String $host Name of the Host holding the DB
    */
    function _db_connect($dbname="mysql", $user="root", $password="", $host="localhost")
    {
      $result = @$dbcon=pg_connect("host=$host dbname=$dbname user=$user password=$password");
      if(!$result)     // If no connection, return 0
      {
       return false;
      }
      return $result;
    }

        /**
    * @desc Generates a CSV File from an SQL String (and outputs it to the browser)
    * @access private
    * @param  String $query_string An SQL statement (usually a SELECT statement)
    * @param  String $dbname Name of the Database
    * @param  String $user User to Access the Database
    * @param  String $password Password to Access the Database
    * @param  String $host Name of the Host holding the DB
    * @param  Boolean $list_fields Whether to output the field names in the first row
    */
    function _generate_csv($query_string, $dbname="mysql", $user="root", $password="", $host="localhost", $list_fields=true,$seprator=";")
    {

      if(!$conn= $this->_db_connect($dbname, $user , $password, $host))
          die("Error. Cannot connect to Database.");
      else
      {
        $result = @pg_exec($conn,$query_string);
        if(!$result)
            return "###ERROR###";
        else
        {
            $file = "";
            $crlf = $this->_define_newline();
            if($list_fields)
            {
                 for($i=0;$i < (pg_num_fields($result))-1;$i++)
                    $file.= pg_field_name($result,$i).$seprator;
                 $file.=pg_field_name($result,pg_num_fields($result)-1).$crlf;
            }

             while ($str= @pg_fetch_row($result))
            {
                $file .= $this->arrayToCsvString($str,$seprator).$crlf;
            }
            return $file;
        }
      }
    }
    
    /**
    * @desc Generates a Xls File from an SQL String (and outputs it to the browser)
    * @access private
    * @param  String $query_string An SQL statement (usually a SELECT statement)
    * @param  String $dbname Name of the Database
    * @param  String $user User to Access the Database
    * @param  String $password Password to Access the Database
    * @param  String $host Name of the Host holding the DB
    * @param  Boolean $list_fields Whether to output the field names in the first row
    */
    function _generate_xls($query_string, $dbname="mysql", $user="root", $password="", $host="localhost", $list_fields=true)
    {

      if(!$conn= $this->_db_connect($dbname, $user , $password, $host))
          die("Error. Cannot connect to Database.");
      else
      {
        $result = @pg_exec($conn,$query_string);
        if(!$result)
            return "###ERROR###";
        else
        {
            $file = array();
            
            if($list_fields)
            {    
            	$file_header = array();        	 
                 for($i=0;$i < (pg_num_fields($result))-1;$i++)                    
                    $file_header[]=pg_field_name($result,$i);
                 $file[]= $file_header;
            }
             
             while ($str= @pg_fetch_row($result))
            {
                $file[]= $str;
            }
            return $file;
        }
      }
    }

    /**
    * @desc Generate the CSV File and send it to browser or download it as a file
    * @access public
    * @param String $query_string  An SQL statement (usually a SELECT statement)
    * @param String $filename  Filename to use when downloading the File. Default="dump". If set to "", the dump is displayed on the browser.
    * @param String $extension Extension to use when downloading the File. Default="csv"
    * @param  String $dbname Name of the Database to use
    * @param  String $user User to Access the Database
    * @param  String $password Password to Access the Database
    * @param  String $host Name of the Host holding the DB
    * @param  Boolean $list_fields Whether to output the field names in the first row
	 */
    function dump($query_string, $filename="dump" , $dbname="mysql", $user="root", $password="", $host="localhost", $list_fields=true )
    {
            $now = gmdate('D, d M Y H:i:s') . ' GMT';
            $USER_BROWSER_AGENT= $this->_get_browser_type();

            if ($filename!="")
            {
            	$xls =$this->_generate_xls($query_string, $dbname, $user, $password, $host, $list_fields);
                if ($xls!="###ERROR###")
                {    
//==================
$workbook = new Spreadsheet_Excel_Writer();
$arr = array(
      'Sheet'=>$xls
      );
foreach($arr as $wbname=>$rows)
{
    $rowcount = count($rows);
    $colcount = count($rows[0]);

    $worksheet =& $workbook->addWorksheet($wbname);
   
    for( $j=0; $j<$rowcount; $j++ )
    {
        for($i=0; $i<$colcount;$i++)
        {
            if (isset($rows[$j][$i]))
            {
                $data=$rows[$j][$i];
                $worksheet->writeString($j, $i, $data );
            }
        }
    }
}
$filenamewithext = $filename.'.xls' ;
$workbook->send($filenamewithext);
$workbook->close();

//==================                	
    		    }
                else
                {   
                	echo $query_string."</br>";
            	    die("Error With The SQL");
                }


            }
            else
            {
                 echo "<html><body><pre>";
                 echo htmlspecialchars($this->_generate_csv($query_string, $dbname, $user, $password, $host, $list_fields));
                 echo "</PRE></BODY></HTML>";
            }
    }
}
?>