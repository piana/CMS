<?php /*windu.org core*/
class less
{
	public static function getVariablesFromFile($url) {
		$variableLines = null;
		$url = str_replace(HOME, __SITE_PATH.'/', $url);
		if (file_exists($url)) {
			$lines = file($url);
			if (is_array($lines)) {
				foreach ($lines as $line){
					if ($line[0]=='@' and $line[1]=='e' and $line[2]=='-') {
						$line = str_replace(array(' ',';'),array('',''), $line);
						$line = explode(':', $line);
						
						$data['value'] = trim($line[1]);
						$data['valueNumeric'] = preg_replace('/\D/', '', trim($line[1]));
						$data['name'] = str_replace('@','',trim($line[0]));
						$data['simpleName'] = str_replace('-', '', $data['name']);
						$data['showName'] = str_replace(array('@e-color-','@e-bigsize-','@e-normalsize-','@e-smallsize-','@e-fontsize-'), array('','','','',''), $line[0]);
						
						$typePom = explode('-',$line[0]);
						$data['type'] = $typePom[1];
						
						$variableLines[] = $data;
					}			
				}
			}
		}
		return $variableLines;
	} 
	public static function replaceVariables($url,$variablesArray) {
		$url = str_replace(HOME, __SITE_PATH.'/', $url);
		$lines = file($url);
		foreach ($lines as $line){
			if ($line[0]=='@' and $line[1]=='e' and $line[2]=='-') {
				$linePom = str_replace(array(' ',';'),array('',''), $line);
				$linePom = explode(':', $linePom);
								
				$finalLines .= $linePom[0].': '.$variablesArray[$linePom[0]].";\n";
			}else{
				$finalLines .= $line;
			}			
		}
		
		baseFile::saveFile($url, $finalLines);
	}  
}
?>
