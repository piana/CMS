<?php /*windu.org model*/
class redirectDB extends baseDB
{
	const TYPE_PAGE = 0;
	const TYPE_EXTERNAL_LINK = 1;
		
	public function add($data){
		
		$data['source'] = str_replace(HOME, '{{$HOME}}', $data['source']);
		
		if (is_numeric($data['target'])) {
			$data['type'] = self::TYPE_PAGE;
		}else{
			$data['type'] = self::TYPE_EXTERNAL_LINK;
		}
		if ($this->fetchCount("source='{$data['source']}'")>0) {
			return $this->updateRow($data, "source='{$data['source']}'");
		}else{
			return $this->insert($data);
		}
		
	}
	public function getTarget($source){
		$source = generate::cleanUrl(str_replace(HOME,'{{$HOME}}', $source));
		$redirect = $this->fetchRow("source = '{$source}'");
		if ($redirect!='') {
			$target = '';
			$pagesDB = new pagesDB();
			
			switch ($redirect->type) {
			    case self::TYPE_PAGE: $target = HOME.$pagesDB->fetchRow("id={$redirect->target}")->urlKey; break;
			    case self::TYPE_EXTERNAL_LINK: $target = $redirect->target; break;
			}	
			
			return $target;		
		}
		return NULL;
	}	
	public function hasRedirect($source) {

		$source = str_replace(HOME,'{{$HOME}}', $source);

		if ($this->fetchCount("source='{$source}'")>0) {
			return TRUE;
		}
		return FALSE;
	}
	public function deleteRedirect($id) {
		$this->delete($id);
	}

}
?>