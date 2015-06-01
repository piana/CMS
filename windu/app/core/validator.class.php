<?php /*windu.org core*/
class validator
{
	public function required($value,$params = null)
	{
		if(is_array($value))
		{
			if ($value['name']=='' or $value['size']==0)
			{
				return TRUE; 
			}
			else
			{
				return FALSE;
			}			
		}
		else
		{
			if ($value=='')
			{
				return TRUE; 
			}
			else if (isset($params['forbiddenVal']))
			{
				if ($value==$params['forbiddenVal']) return TRUE; else return FALSE;
			}
			else
			{
				return FALSE;
			}
		}
	}
	public function email($value, $params = null, &$data)
	{
		if (!$this->required($value))
		{
			$val1=explode('@',$value);
			$val2=explode('.',$value);
			if (!isset($val1[1])){$val1[1]='';}
			if (!isset($val2[1])){$val2[1]='';}
			
			if ((strlen($val1[0])>=1) and (strlen($val1[1])>=3) and (strlen($val2[1])>=1))
			{return FALSE;} else {return TRUE;}
		}
	}
	public static function isEmail($value)
	{
		$val1=explode('@',$value);
		$val2=explode('.',$value);
		if (!isset($val1[1])){$val1[1]='';}
		if (!isset($val2[1])){$val2[1]='';}
			
		if ((strlen($val1[0])>=1) and (strlen($val1[1])>=3) and (strlen($val2[1])>=1))
		{return TRUE;} else {return FALSE;}
	}	
	public function plnip($nip)
	{
		 $steps = array(6, 5, 7, 2, 3, 4, 5, 6, 7);
		 $nip = str_replace('-', '', $nip);
		 $nip = str_replace(' ', '', $nip);
		 
		 if (strlen($nip) != 10) { return TRUE; }
		 for ($x = 0; $x < 9; $x++) $sum_nb += $steps[$x] * $nip[$x];
		 if ($sum_nb % 11 == $nip[9]) { return FALSE; }
		 else { return TRUE; }
	} 	
	
	public function url($value, $params = null, &$data)
	{
		if (!$this->required($value))
		{
			$pattern = "#((http|https|ftp)://(\S*?\.\S*?))(\s|\;|\)|\]|\[|\{|\}|,|\"|'|:|\<|$|\.\s)#ie";
			if (preg_match($pattern, $value)) {
				return FALSE;
			}
			return TRUE;
		}
	}	
	public function stringLength($value,$params, &$data)
	{
		if (!$this->required($value))
		{			
			$lenght_min=$params[0];
			$lenght_max=$params[1];
			if (($lenght_max==NULL or strlen($value)<=$lenght_max) and ($lenght_min==NULL or strlen($value)>=$lenght_min))
			{return FALSE;} else {return TRUE;}
		}
	}
	public function numericLength($value,$params,&$data)
	{
		if (!$this->required($value))
		{			
			$min=$params[0];
			$max=$params[1];
			
			if (is_numeric($value) and ($max==NULL or $value<=$max) and ($min==NULL or $value>=$min))
			{return FALSE;} else {return TRUE;}
		}
	}
	public function numeric($value,$params,&$data)
	{
		if (!$this->required($value))
		{			
			if (is_numeric($value))
			{return FALSE;} else {return TRUE;}
		}
	}	
	public function bool($value,$params,&$data)
	{
		if (!$this->required($value))
		{			
			if (is_bool($value))
			{return FALSE;} else {return TRUE;}
		}
	}		
	public function string($value,$params,&$data)
	{
		if (!$this->required($value))
		{			
			if (is_string($value))
			{return FALSE;} else {return TRUE;}
		}
	}	
	public function unique($value,$params,&$data,$fieldName)//w table podajemy uchwyt do tabeli z ktorej bedizemy czytac dane
	{	
		$table = $params['table'];
		$where = $params['where'];	
		if (!$this->required($value))
		{			
			if($where!=null){$where = ' and '.$where;}
			$val=$table->select("$fieldName='$value' $where",null,$fieldName)->fetch();
			if (!is_array($val))
			{return FALSE;} else {return TRUE;}
		}
	}	
	public function exist($value,$params,&$data,$fieldName)//w table podajemy uchwyt do tabeli z ktorej bedizemy czytac dane
	{
		$table = $params['table'];
		if (!$this->required($value))
		{			
			$val=$table->select("$fieldName='$value'",null,$fieldName)->fetch();
			if (!is_array($val))
			{return TRUE;} else {return FALSE;}
		}
	}	
	public function same($value,$params,&$data) //w parametrze podajemy pole z ktorym funkcja porowna wartosc $value
	{
		if (!$this->required($value))
		{			
			if ($value!=$data[$params])
			{return TRUE;} else {return FALSE;}
		}
	}

	public function fileSize($value,$params,&$data,$fieldName)
	{
		if(is_array($value))
		{
			$min=$params[0];
			$max=$params[1];
			
			if ($value['size']<$min or $value['size']>$max)
			{
				return TRUE; 
			}
			else
			{
				return FALSE;
			}			
		}
	}
	public function datatime($value,$params,&$data)
	{
		if(preg_match("/^(\d{2})-(\d{2})-(\d{4}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $value, $matches) or $value=='')
		{return FALSE;} else {return TRUE;}
	}		
	function fileType($value,$params,&$data,$fieldName)
	{
		if(is_array($value) and $value['error']==0)
		{
			foreach ($params as $ext){
				if(strlen($ext)==2){
					$extPom = substr($value['name'], -3, 3);
				}else{
					$extPom = substr($value['name'], -4, 4);
				}		
				
				$extPom = strtolower($extPom);
				$extPom = str_replace('.','',$extPom);	
				
				if ($ext == $extPom)
				{
					$find = 1;
					break;
				}
				else
				{
					$find = 0;				
				}
			}
			if ($find == 1) {
				return FALSE;
			}else{
				return TRUE;
			}			
		}else{
			return FALSE;
		}
	}
}
?>