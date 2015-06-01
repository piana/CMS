<?php /*windu.org core*/
class csv
{
	//return array from csv
	public static function toArray($file, $delimiter = ';', $enclosure = '"', $escape = '\\') {
		$lines = file($file);
		foreach ($lines as $line){
			$parsedArray[] = str_getcsv($line,$delimiter,$enclosure,$escape);
		}
		return $parsedArray;
	}
	//return csv string
	public static function rowToCsv(array &$fields, $delimiter = ';', $enclosure = '"', $encloseAll = false, $nullToMysqlNull = false ) {
	    $delimiter_esc = preg_quote($delimiter, '/');
	    $enclosure_esc = preg_quote($enclosure, '/');
	
	    $output = array();
	    foreach ( $fields as $field ) {
	        if ($field === null && $nullToMysqlNull) {
	            $output[] = 'NULL';
	            continue;
	        }

	        if ( $encloseAll || preg_match( "/(?:${delimiter_esc}|${enclosure_esc}|\s)/", $field ) ) {
	            $output[] = $enclosure . str_replace($enclosure, $enclosure . $enclosure, $field) . $enclosure;
	        }
	        else {
	            $output[] = $field;
	        }
	    }
	    return implode($delimiter,$output);
	}	
	public static function rowsToCsv(array &$fields,$delimiter = ';', $enclosure = '"', $encloseAll = false, $nullToMysqlNull = false ) {
        $csvString = '';
        foreach ($fields as $field){
			$csvString .= csv::rowToCsv($field,$delimiter,$enclosure,$encloseAll,$nullToMysqlNull)."\n";
		}
		return $csvString;
	}
	public static function getCsvFile($fileName,array &$fields, $delimiter = ';', $enclosure = '"', $encloseAll = false, $nullToMysqlNull = false ) {
		$csvString = csv::rowsToCsv($fields, $delimiter, $enclosure, $encloseAll, $nullToMysqlNull);

		header('Content-Type:application/CSV');
		header("Content-Disposition:attachment;filename='{$fileName}.csv'");
		echo $csvString;
	}   
}
?>