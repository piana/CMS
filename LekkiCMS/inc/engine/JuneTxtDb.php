<?php
/**
 * The Class used for access data,named JuneTxtDb.
 * 
 * @author Kang Chen <dreamneverfall@gmail.com>
 * @link http://projects.ourplanet.tk/junetxtdb/
 * @link http://code.google.com/p/junetxtdb/
 * @copyright &copy; 2010 Ourplanet Team
 * @license GPL 2
 * @version 0.3 alpha 2010-10-13
 */
class JuneTxtDB {
    private     $_version='0.3 alpha';
    protected   $_db_root_dir='data/';
    protected   $_field_separator='"';
    protected   $_error;
    protected   $_frame_ext='.frm.txt';//Default to '.frm.txt'.
    protected   $_data_ext='.dat.txt';//Default to '.dat.txt'.
    protected   $_index_ext='.idx.txt';//Default to '.idx.txt'.
    protected   $_insert_id;
    protected   $_currentDB;
    protected   $_charset='UTF-8';//Default to 'UTF-8'.
    private     $_supported_charsets=array('ISO-8859-1','ISO-8859-15','UTF-8','cp866','cp1251','cp1252','KOI8-R','BIG5','GB2312','BIG5-HKSCS','Shift_JIS','EUC-JP','ISO8859-1','ISO8859-15','ibm866','866','Windows-1251','win-1251','1251','Windows-1252','1252','koi8-ru','koi8r','950','936','SJIS','932','EUCJP');
    protected static $_error_code_list=array(
                    0=>"Unknown Error",
                    1=>"You should create your data root folder '%s' first!",
                    2=>"%s is not readable!",
                    3=>"%s is not writable!",
                    4=>"Database `%s` already exists!",
                    5=>"Could not create database `%s`,you should make the directory '%s' to 777!",
                    6=>"Could not chmod the directory '%s' to 777!",
                    7=>"The database `%s` could not drop,you can remove it manually.",
                    8=>"You shold select one database first! ",
                    9=>"Database `%s` not exists! ",
                    10=>"Table `%s` already exist!",
                    11=>"The parameter of fields must be Array, and at least one field!",
                    12=>"Table `%s` was created,but you need to chmod 777 to files:%s,%s,%s!",
                    13=>"Table `%s` could not created properly!",
                    14=>"The data you insert must be Array!",
                    15=>"The number of your record does not match with the number of fields!",
                    16=>"The field `%s` can not be NULL",
                    17=>"Data insert failed of permissions.",
                    18=>"Table `%s` does not exists!",
                    19=>"The condition Must be an array and Only has ONE element!",
                    20=>"Field `%s` does not exists int table `%s`",
                    21=>"The table '%s' could not open now,please try again later.",
                    22=>"Could not open file '%s' now,please try later.",
                    23=>"Table `%s` does not exists!",
                    24=>"table `%s` does not deleted properly!",
                    25=>"The data you updated Must NOT be array() !",
                    26=>"Database `%s` is not writable!",
                );

    /**
     * Constructor
     * @ignore Test 1 OK
     */
    public function JuneTxtDB($config=NULL){
        if($config)
            $this->setConfig($config);
        if(!$this->_connect())
            die($this->error());
    }

    /**
     * set config
     * @ignore Test 1 OK
     * @param array $config
     * @return void
     * @example $config=array('db_root_dir'=>'mydatadir/','frame_ext'=>'.f.txt','data_ext'=>'.d.txt','index_ext'=>'.i.txt','charset'=>'GB2312');
     */
    protected function setConfig($config){
        if(is_array($config)){
            if (isset ($config['db_root_dir']))
                $this->_set_dbrootdir ($config['db_root_dir']);
            if (isset ($config['frame_ext']))
                $this->_frame_ext=$config['frame_ext'];
            if (isset ($config['data_ext']))
                $this->_data_ext=$config['data_ext'];
            if (isset ($config['index_ext']))
                $this->_index_ext=$config['index_ext'];
            if (isset ($config['charset']))
                $this->set_charset ($config['charset']);
        }
    }

    /**
     * set database root directory
     * @ignore Test 1 OK
     * @param string $rootdir
     * @return void
     */
    protected function _set_dbrootdir($rootdir){
        $this->_db_root_dir=$rootdir;
    }
    
    /**
     * connect to the database,if no errors return TRUE,othewise FALSE
     * @return boolean
     * @ignore Test 1 OK
     */
    private function _connect(){
    	$errormsg='';
    	if(!is_dir($this->_db_root_dir))
            $errormsg=sprintf (self::$_error_code_list[1],  $this->_db_root_dir);
    	elseif (!is_readable($this->_db_root_dir))
            $errormsg=sprintf (self::$_error_code_list[2],  $this->_db_root_dir);
    	elseif (!is_writable($this->_db_root_dir))
            $errormsg=sprintf (self::$_error_code_list[3],  $this->_db_root_dir);
    	/*elseif (!is_executable($this->_db_root_dir))
            $errormsg="$this->_db_root_dir is not executable!";*/
    	if($errormsg){
            $this->_trigger_error($errormsg);
            return FALSE;
    	}
    	return TRUE;
    }

    /**
     * Create One Database
     * @param string $dbname
     * @return boolean
     * @ignore Test 1 OK
     */
    public function create_db($dbname){
    	$error_string='';
        if(is_dir($this->_db_path($dbname)))
            $error_string=sprintf (self::$_error_code_list[4],$dbname);
        elseif(!mkdir($this->_db_path($dbname), 0777, TRUE))
            $error_string=sprintf (self::$_error_code_list[5],$dbname,$this->_db_root_dir);
        elseif(!chmod($this->_db_path($dbname),0777))
            $error_string=sprintf (self::$_error_code_list[6],  $dbname);
        if($error_string){
            $this->_trigger_error($error_string);
            return false;
        }
        return true;
    }
    
    /**
     * Trigger error
     * @param string $errormsg
     * @ignore Test 1 OK
     */
    protected function _trigger_error($errormsg){
        $this->_error=$errormsg;
    }
    
    /**
     * drop database 
     * @param string $dbname
     * @return boolean
     * @ignore Test 1 OK
     */
    public function drop_db($dbname){
        if (!$this->select_db($dbname))
    	    return FALSE;
    	$dbpath=$this->_db_root_dir.$dbname;
    	if (!rmdirs($dbpath)){
    	    $errormsg=sprintf (self::$_error_code_list[7], $dbname);
            $this->_trigger_error($errormsg);
            return FALSE;
    	}
        return TRUE;
    }

    /**
     * set the active database
     * @param string $dbname
     * @return boolean
     * @ignore Test 1 OK
     */
    public function select_db($dbname){
        $errormsg='';
        if (!$dbname)
            $errormsg=self::$_error_code_list[8];
        if(!$this->_db_exists($dbname))
            $errormsg=sprintf (self::$_error_code_list[9],$dbname);
        if($errormsg){
            $this->_trigger_error($errormsg);
            return FALSE;
        }
        $this->_currentDB=$dbname;
        return TRUE;
    }

    /**
     * @param string $tablename
     * @param array $fields
     * @example $fields=array(
     * 	                 array('name'=>'mid','auto_increment'=>true),
     *                   array('name'=>'author'),
     *                   array('name'=>'body')
     *                   );
     * @return Boolean
     * @ignore Test 1 OK
     */
    public function create_table($tablename,$fields){
    	if(!$this->select_db($this->_currentDB))
            return FALSE;
        $errormsg='';
        if($this->_table_exists($this->_currentDB, $tablename)){
            $errormsg=sprintf (self::$_error_code_list[10],$this->_currentDB.'.'.$tablename);
        }elseif(!is_writable($this->_db_path($this->_currentDB))){
            $errormsg=sprintf (self::$_error_code_list[26],$this->_currentDB);
        }elseif(!is_array($fields) || count($fields)<1){
            $errormsg=self::$_error_code_list[11];
        }
        if($errormsg){
            $this->_trigger_error($errormsg);
            return FALSE;
        }
        //parse the array to string,then write it into the frame file
        $field_string=$this->_parse_fields_create($fields);
        $table_files=$this->_table_files($this->_currentDB,$tablename);
        $frame_status=file_put_contents($table_files['frame'], $field_string);//write into frame file
        $index_status=file_put_contents($table_files['index'], '1');//write into index file
        $data_status=touch($table_files['data']);//create data file
        if($frame_status && $index_status && $data_status){//if the three files created successfully
            if(chmod($table_files['frame'],0777) && chmod($table_files['index'],0777) && chmod($table_files['data'],0777))
                return TRUE;
            $errmsg=sprintf(self::$_error_code_list[12], $tablename, $table_files['frame'],$table_files['index'],$table_files['data']);
            $this->_trigger_error($errmsg);
            return FALSE;
        }else{
            $errmsg=sprintf(self::$_error_code_list[13], $tablename);
            $this->_trigger_error($errmsg);
            return FALSE;
        }
    }
    
    /**
     * get the filenames of one table
     * @param string $dbname
     * @param string $tablename
     * @return return the table info.
     * @ignore Test 1 OK
     */
    private function _table_files($dbname,$tablename){
    	$tbpath=$this->_table_path($dbname,$tablename);
    	$tb_data_file=$tbpath.$this->_data_ext;
    	$tb_index_file=$tbpath.$this->_index_ext;
    	$tb_frm_file=$tbpath.$this->_frame_ext;
    	$table=array();
    	$table['index']=$tb_index_file;
    	$table['frame']=$tb_frm_file;
    	$table['data']=$tb_data_file;
    	return $table;
    }

    /**
     * parse the Array to String ,so that we put it into frame file
     * @param Array $fields
     * @return string $str
     * @ignore Test 1 OK
     */
    public function _parse_fields_create($fields){
        $str='';
        $auto_exists=NULL;//标示自增字段是否已存在
        foreach ($fields as $field){
            if (isset ($field['name']) && is_string($field['name'])){
                $str.=$field['name'];
                if(isset ($field['auto_increment'])){
                    if(!$auto_exists){
                        $str.=':auto_increment';
                        $auto_exists=TRUE;
                    }
                }
                $str.="\n";
            }
        }
        return $str;
    }
    /**
     * insert data into table
     * @param string $tablename
     * @param array $data
     * @return boolean
     * @ignore Test 1 OK
     */
    public function insert($tablename,$data){
        if(!$this->select_db($this->_currentDB))
            return FALSE;
        if(!$this->_table_exists($this->_currentDB,$tablename)){
            $errmsg=sprintf(self::$_error_code_list[23], $tablename);
            $this->_trigger_error($errmsg);
            return FALSE;
    	}
    	$table_files=$this->_table_files($this->_currentDB,$tablename);
    	$frmf=$table_files['frame'];
    	$datf=$table_files['data'];
    	$idxf=$table_files['index'];
    	if(!is_array($data)){
            $errmsg=self::$_error_code_list[14];
            $this->_trigger_error($errmsg);
            return FALSE;
    	}
    	$frm=$this->_get_frame($this->_currentDB,$tablename);
    	//check if all field was filled
    	if(count($data)!=count($frm)){
            $errmsg=self::$_error_code_list[15];
            $this->_trigger_error($errmsg);
            return FALSE;
    	}
    	for ($i=0,$num=count($data);$i<$num;$i++){
            //if one field was set to NULL
            if(@in_array('auto_increment',$frm[$i]))
            	$data[$i]=NULL;
            if($data[$i]==NULL){
                //check if the field is auto_increment
            	if(@!in_array('auto_increment',$frm[$i])){
                    $errmsg=sprintf(self::$_error_code_list[16],$frm[$i]);
                    $this->_trigger_error($errmsg);
                    return FALSE;
                }
                //replace NULL with the auto_inrement number,get from the index.txt
                $auto_num=(int)file_get_contents($idxf);
            	$data[$i]=$auto_num;
            }
            $data[$i]=$this->_escape_string($data[$i]);
    	}
    	$insert_str=implode($this->_field_separator,$data);
    	$insert_str.="\n";
    	if(file_put_contents($datf,$insert_str,FILE_APPEND) && file_put_contents($idxf,$auto_num+1)){
    	    $this->_insert_id=$auto_num;
    	    return TRUE;
    	}else{
    	    $errmsg=self::$_error_code_list[17];
    	    return FALSE;
    	}
    }

    /**
     * get data from one table specified by condition
     * @param string $tablename
     * @param mixed string '*' or array
     * @example $condtion=array('id'=>1);$condition=array('author'=>'chen');
     * @return  mixed:Returns array(an empty array if no records in table) on success or FALSE on failure.
     * @ignore Test 1 OK
     */
    public function select($tablename,$condition='*'){
        if (!$this->select_db($this->_currentDB))
            return FALSE;
    	if(!$this->_table_exists($this->_currentDB,$tablename)){
            $errmsg=  sprintf(self::$_error_code_list[23],$this->_currentDB.'.'.$tablename);
            $this->_trigger_error($errmsg);
            return FALSE;
    	}
        if($condition=='*'){
            $result=$this->_select_all_in_table($this->_currentDB,$tablename);
            return $result;
        }
        if(!is_array($condition) || count($condition)!=1 ){
            $errmsg=self::$_error_code_list[19];
            $this->_trigger_error($errmsg);
            return FALSE;
    	}
        $field=key($condition);
    	if ( ($key=$this->_field_exists($this->_currentDB,$tablename,$field)) === FALSE){
            $errmsg=  sprintf(self::$_error_code_list[20], $field,$this->_currentDB.'.'.$tablename);
            $this->_trigger_error($errmsg);
            return FALSE;
    	}
    	$datf=$this->_table_path($this->_currentDB,$tablename).$this->_data_ext;
    	$data=$this->_select_by_field($datf,$key,$condition[$field]);
    	if($data===FALSE){
            $errmsg=sprintf(self::$_error_code_list[21], $tablename);
            $this->_trigger_error($errmsg);
            return FALSE;
    	}
        if($data==array()){
            return array();
        }
        $data=$this->_unescape_data($data);
        $frame_data=$this->_read_frame($this->_currentDB,$tablename);
        $data=$this->_array_combine($frame_data,$data);
    	return $data;
    }

    /**
     * unescape the record
     * @param array $data
     * @return mixed:array or FALSE
     */
    protected  function _unescape_data($data){
        if(!is_array($data) || empty ($data)){
            return FALSE;
        }
        foreach ($data as &$_each){
            foreach ($_each as &$__each){
                $__each=$this->_unescape_string($__each);
            }
        }
        return $data;
    }

    /**
     * get field的data
     * Note:If the file was opened successfully,the value returned alwasy be an array。
		But array() was returned if no record that match the conditon was found.
     * @param string $file
     * @param string $key
     * @param mixed $value
     * @return  mixed:Returns $filedata on success or FALSE on failure.
     * @ignore Test 1 OK
     */
    private function _select_by_field($file,$key,$value){
        $filedata = array();//初始化变量，用于存储数据
        $handle = @fopen($file,'rb+');//以rb+方式打开文件
        //若文件被正确打开 
        if($handle){
            flock($handle,LOCK_SH);//分享锁定（读取）
            //若没有到达文件结尾
            while(!feof($handle)){
                $row=fgets($handle);//$row=fgets($handle,9999);
                //若此记录是字符串
                if(is_string($row)){
                    $row_data=explode('"',$row);//将此行记录分离为一个数组
                    if ($row_data[$key]==$value)//若找到指定 id 的记录，读取(查找)结束
                        $filedata[]=$row_data;
                }
            }
            flock($handle,LOCK_UN);//取消锁定
            fclose($handle);//关闭指针
        }
        else//若文件没有被正确打开，触发错误
            return FALSE;
        return $filedata;
    }
    /**
     * check if one field exists
     * @param string $dbname
     * @param string $tablename
     * @param string $field
     * @return mixed: FLASE or the key for field
     * @ignore Test 1 OK
     */
    private function _field_exists($dbname,$tablename,$field){
    	$fields=$this->_read_frame($dbname,$tablename);
    	if(($key=array_search($field,$fields,TRUE)) === FALSE )
            return FALSE;
    	return $key;
    }
    
    /**
     * get all data from one table
     * @param $dbname
     * @param $tablename
     * @return FALSE or $data(返回关联数组)
     * @ignore Test 1 OK
     */
    public function _select_all_in_table($dbname,$tablename){
        $frmf=$this->_table_path($dbname,$tablename).$this->_frame_ext;
        $datf=$this->_table_path($dbname,$tablename).$this->_data_ext;
        $data=$this->_readover($datf);
        if($data===FALSE){
            $errmsg=  sprintf(self::$_error_code_list[22], $datf);
            $this->_trigger_error($errmsg);
            return FALSE;
        }
        if ($data==array())
            return array();
        $data=  $this->_unescape_data($data);
        $frame_data=$this->_read_frame($dbname,$tablename);
        $data=$this->_array_combine($frame_data,$data);
        return $data;
    }
    
    /**
     * combine array
     * @param array $a
     * @param array $b
     * @return array
     * @ignore Test 1 OK
     */
    function _array_combine($a,$b){
        foreach ($b as &$per_element){
            $per_element=$this->array_combine_special($a, $per_element);
        }
        return $b;
    }

    private function array_combine_special($a, $b, $pad = TRUE) {
        $acount = count($a);
        $bcount = count($b);
        if (!$pad) {
            $size = ($acount > $bcount) ? $bcount : $acount;
            $a = array_slice($a, 0, $size);
            $b = array_slice($b, 0, $size);
        } else {
            if ($acount > $bcount) {
                $more = $acount - $bcount;
                $more = $acount - $bcount;
                for($i = 0; $i < $more; $i++) {
                    $b[] = "";
                }
            } else if ($acount < $bcount) {
                $more = $bcount - $acount;     
                for($i = 0; $i < $more; $i++) {
                    $key = 'extra_field_0' . $i;
                    $a[] = $key;
                }
               
            }
        }  
        return array_combine($a, $b);
    }
    
    /**
     * get FRAME of one table
     * @param string $dbname
     * @param string $tablename
     * @return array $frm
     * @example array(3) {
                      [0]=>
                      string(3) "mid"
                      [1]=>
                      string(6) "author"
                      [2]=>
                      string(4) "body"
                    }
     * @ignore Test 1 OK
     */
    private function _read_frame($dbname,$tablename){
    	$frm=$this->_get_frame($dbname,$tablename);
    	foreach ($frm as &$f){
            if(is_array($f))
                $f=$f[0];
    	}
    	return $frm;
    }
    /**
     *	read table
     * 	@param $filename;
     *  @param $method;
     *  @return $filedata or FALSE;
     * @ignore Test 1 OK
     */
    function _readover($filename,$method='rb'){
        $filedata = array();
        $handle = @fopen($filename,$method);
        if($handle){
            flock($handle,LOCK_SH);
            while(!feof($handle)){
                $row=fgets($handle); //$row=fgets($handle,9999);
                if(is_string($row)){
                    $now_array=explode($this->_field_separator,$row);
                    $filedata[]=$now_array;
                }
            }
            flock($handle,LOCK_UN);
            fclose($handle);
            return $filedata;
        }else{
            return FALSE;
        }
    }
    /**
     * get table frame
     * @param string $dbname
     * @param string $tablename
     * @return array $frm
     * @example array(3) {
                      [0]=>
                      array(2) {
                        [0]=>
                        string(3) "mid"
                        [1]=>
                        string(14) "auto_increment"
                      }
                      [1]=>
                      string(6) "author"
                      [2]=>
                      string(4) "body"
                    }
     * @ignore Test 1 OK
     */
    public function _get_frame($dbname,$tablename){
    	$tbpath=$this->_table_path($dbname,$tablename);
    	$tbfr=$tbpath.$this->_frame_ext;
    	$str=trim(file_get_contents($tbfr));
    	$frm=explode("\n",$str);
    	foreach ($frm as &$v){
            $tmp_ar=explode(':',$v);
            if(count($tmp_ar)>1)
                $v=array($tmp_ar[0],$tmp_ar[1]);
    	}
    	return $frm;
    }



    /**
     * check if one db exists
     * @param  string $dbname
     * @return boolean
     * @ignore Test 1 OK
     */
    public function _db_exists($dbname){
        if (!is_dir($this->_db_path($dbname)))
            return FALSE;
        return TRUE;
    }

    /**
     * check if one table exists
     * @param $dbname
     * @param $tablename
     * @ignore Test 1 OK
     */
    public function _table_exists($dbname,$tablename){
    	$table_files=$this->_table_files($dbname,$tablename);
        foreach ($table_files as $file){
            if (!file_exists($file))
                return FALSE;
        }
        return TRUE;
    }

    /**
     * return the path of table
     * @param string $dbname
     * @param string $tablename
     * @return string
     * @ignore Test 1 OK
     */
    public function _table_path($dbname,$tablename){
        return $this->_db_path($dbname).'/'.$tablename;
    }
    /**
     * return the path of database
     * @param string $dbname
     * @return string
     * @ignore Test 1 OK
     */
    public function _db_path($dbname){
        return $this->_db_root_dir.$dbname;
    }

    /**
     * print the errors
     * @ignore Test 1 OK
     */
    public function error(){
        echo $this->_error;
    }
    
    /**
     * return the id just inserted
     * @ignore Test 1 OK
     */
    public function insert_id(){
    	return $this->_insert_id;
    }
    
    /**
     * List databases available on the server.
     * @return array $db
     * @ignore Test 1 OK
     */
    public function list_dbs(){
    	$db=array();
    	$d=dir($this->_db_root_dir);
    	while ($tmp=$d->read()){
            if(is_dir($this->_db_root_dir.$tmp) && substr($tmp,0,1)!='.' )
                $db[]=$tmp;
    	}	
    	return $db;
    }
    
    /**
     * return tables of one database
     * @param string $dbname
     * @return mixed :array or FALSE
     * @ignore Test 1 OK
     * @NOTE:You must use the === operator to test the return value.
     */
    public function list_tables(){
        if (!$this->select_db($this->_currentDB))
    	    return FALSE;
    	$tables=array();
    	$table_exts=array($this->_index_ext,$this->_data_ext,$this->_frame_ext);
    	$dbpath=$this->_db_root_dir.$this->_currentDB;
    	$d=dir($dbpath);
    	while($tmp=$d->read()){
            $fileInfo = pathinfo($dbpath.'/'.$tmp);
            if(is_file($dbpath.'/'.$tmp) && $fileInfo['extension']=='txt'){
            	$tmp=str_replace($table_exts,'',$tmp);
    		$tables[]=$tmp;	
            }
    	}
    	$tables=array_unique($tables);
    	return $tables;
    }
    
    /**
     * drop table
     * @param $tablename
     * @return boolean
     * @ignore TEST 1 OK
     */
    public function drop_table($tablename){
        if (!$this->select_db($this->_currentDB))
    	    return FALSE;
    	if(!$this->_table_exists($this->_currentDB,$tablename)){
            $errmsg= sprintf(self::$_error_code_list[23], $this->_currentDB.'.'.$tablename);
            $this->_trigger_error($errmsg);
            return FALSE;
    	}	
    	$table_files=$this->_table_files($this->_currentDB,$tablename);
    	foreach ($table_files as $file){
            if(!unlink($file)){
                $errmsg=  sprintf(self::$_error_code_list[24], $this->_currentDB.'.'.$tablename);
    		$this->_trigger_error($errmsg);
    		return FALSE;
            }
    	}
    	return TRUE;
    }
    
    /**
     * delete or update one record from table 
     * @param string $tablename
     * @param array $condition e.g:$condition=array('id'=>1)
     * @param string $action:D=Delete,U=update
     * @param array $data;
     * @return boolean 
     * @bug:当查询条件中的字段是最后一个字段，不会删除此条记录！
     * @ignore Test 1 OK
     */
    public function update($tablename,$condition,$data,$isDelete=FALSE){
        if (!$this->select_db($this->_currentDB))
            return FALSE;
    	if(!$this->_table_exists($this->_currentDB,$tablename)){
            $errmsg=sprintf(self::$_error_code_list[23], $this->_currentDB.'.'.$tablename);
            $this->_trigger_error($errmsg);
            return FALSE;
    	}
    	if(!is_array($condition) || count($condition)!=1 ){
            $errmsg=self::$_error_code_list[19];
            $this->_trigger_error($errmsg);
            return FALSE;
    	}
    	$field=key($condition);
    	if ( ($key=$this->_field_exists($this->_currentDB,$tablename,$field)) === FALSE){
            $errmsg=sprintf(self::$_error_code_list[20], $field,$this->_currentDB.'.'.$tablename);
            $this->_trigger_error($errmsg);
            return FALSE;
    	}
    	$datf=$this->_table_path($this->_currentDB,$tablename).$this->_data_ext;	
        if(!is_array($data)){
            $errmsg=self::$_error_code_list[14];
            $this->_trigger_error($errmsg);
            return FALSE;
    	}
    	if(!$isDelete){
            if($data==array()){
    	    $errmsg=self::$_error_code_list[25];
            $this->_trigger_error($errmsg);
            return FALSE;
            }
        }else{
                $data=array();
        }
    	if($data==array())
            $string='';
    	else{
            $frm=$this->_get_frame($this->_currentDB,$tablename);
	    //check if all field was filled
	    if(count($data)!=count($frm)){
	    	$errmsg=self::$_error_code_list[15];
	    	$this->_trigger_error($errmsg);
	    	return FALSE;
	    }
	    foreach($data as &$per_element){
                $per_element=$this->_escape_string($per_element);
	    }
            $string=implode($this->_field_separator,$data);
	    $string.="\n";
    	}
    	if(!$this->_modify($datf,$key,$condition[$field],$string)){
            $errmsg=sprintf(self::$_error_code_list[21], $this->_currentDB.'.'.$tablename);
            $this->_trigger_error($errmsg);
            return FALSE;
    	}
    	return TRUE;
    }

    /**
     * delete one record from table
     * @param string $tbl
     * @param array $condition
     * @return boolean
     * @ignore Test 1 OK
     */
    public function delete($tbl,$condition){
        return $this->update($tbl, $condition, array(), TRUE);
    }

    /**
     * modify record
     * Note：always return true if the file was opened successfully
     * @param string $filename
     * @param string $key
     * @param mixed $value
     * @param string $string
     * @return boolean
     * @ignore Test 1 OK
     */
    function _modify($filename,$key,$value,$string){
    	$mode='rb+';
    	$filesize=filesize($filename);//得到文件的size
    	$str=file_get_contents($filename);//得到文件内容
        $handle=fopen($filename,$mode);//打开文件
        if(!$handle)//若无法打开文件，返回FALSE            
            return FALSE;
        //$id_len=strlen($mid);//get the length of $mid此处需要更新
        $file_point=array();
        $m_len=0;
        $find=FALSE;
        while(!feof($handle)){
            $file_point[]=ftell($handle);//记录当前的指针位置
            $str_line=fgets($handle); // $str_line=fgets($handle,9999);
            //若此记录是字符串
            if(is_string($str_line)){
                $row_data=explode($this->_field_separator,$str_line);//将此行记录分离为一个数组
                //若找到指定 key 的记录，读取(查找)结束
                if ($row_data[$key]==$value){
                    $find=TRUE;
                    $m_len=strlen($str_line);//$m_len 代表当前行的长度
                    break;//break the while
                }
            }
        }
        if(!$find){//if no record according the condition found,return true
            return TRUE;
        }
        $begin_point=end($file_point);// the start of modified line
        $offset=$begin_point+$m_len;//the lenth need to be modified
        fseek($handle,$offset);//移动指针到需要修改的内容之后无需修改的部分的开始
        $last_string=fread($handle,$filesize+1);//读取后面的内容
    
        $put_string=$string.$last_string;//需要写入的内容：新的字符串及原来无需修改的内容
    
        fseek($handle,$begin_point);//移动指针到需要修改的地方
        fwrite($handle,$put_string);//开始写入
    
        $new_all_len=$begin_point+strlen($put_string);//计算文件的新的长度
    
        ftruncate($handle,$new_all_len);//将文件截取到新的长度
        fclose($handle);
        return TRUE;
    }
    
    /**
     * Escape string
     * @param  string $string
     * @return string
     * @ignore Test 1 OK
     */
    private function _escape_string($string){
        return htmlspecialchars(trim($string), ENT_QUOTES,$this->_charset);
    }

    /**
     * Unescape string
     * @param  string $string
     * @return string
     * @ignore Test 1 OK
     */
    private function _unescape_string($string){
        return htmlspecialchars_decode(trim($string), ENT_QUOTES);
    }
    
    /**
     * Sets the character set
     * @param $charset
     * @return void
     * @ignore Test 1 OK
     */
    public function set_charset($charset){
        if (in_array($charset,$this->_supported_charsets))
            $this->_charset=$charset;
    }
    
    /**
     * Returns the name of the character set
     * @return string :Returns the character set name.
     * @ignore Test 1 OK
     */
    public function get_charset(){
        return $this->_charset;
    }
    
    /**
     * return the version of JuneTxtDb
     * @return string
     * @ignore Test 1 OK
     */
    public function get_version(){
        return $this->_version;
    }
    
    /**
     * Get number of rows in result
     * @param $result
     * @return integer
     * @ignore Test 1 OK
     */
    public function num_rows($result){
        return count($result); 
    }
}
/**
 * @author FleaPHP Framework 
 * @link http://www.fleaphp.org/ 
 * @copyright Copyright &copy; 2005 - 2008 QeeYuan China Inc. (http://www.qeeyuan.com)
 * @license http://www.yiiframework.com/license/  
 */
function rmdirs($dir)
{
    $dir = realpath($dir);
    if ($dir == '' || $dir == '/' ||  (strlen($dir) == 3 && substr($dir, 1) == ':\\'))
    {
        //we do not allowed to delete root directory.
        return false;
    }

    if(false !== ($dh = opendir($dir))) {
        while(false !== ($file = readdir($dh))) {
            if($file == '.' || $file == '..') { continue; }
            $path = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($path)) {
                if (!rmdirs($path)) { return false; }
            } else {
                unlink($path);
            }
        }
        closedir($dh);
        rmdir($dir);
        return true;
    } else {
        return false;
    }
}
?>