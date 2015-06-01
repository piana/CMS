<?php /*windu.org model*/
class mailingtemplatesDB extends baseDB
{
	public function add($data) {
		$this->insert($data);
	}
	public function render($id,$emailObject) {
		$content = $this->fetchRow("id={$id}")->content;
		$contentFinal = str_replace('{name}', $emailObject->name, $content);
		$contentFinal = str_replace('{exclude}', $HOME.'admin/do/mailingExclude/exclude/'.$emailObject->ekey.'/', $contentFinal);
		
		$pattern = '#\\{(.*?)\\}#s';
		preg_match_all($pattern, $contentFinal, $matches);
		$stringsArray = explode($matches[1][0], '|');
		
		foreach ($matches[1] as $match){
			$stringsArray = explode('|',$match);
			$count = count($stringsArray);
			$rand = rand(0, $count-1);
			$contentFinal = str_replace('{'.$match.'}', $stringsArray[$rand], $contentFinal);
		}
		
		$contentFinal = str_replace('{exclude}', $HOME.'admin/do/mailingExclude/exclude/'.$emailObject->ekey.'/', $contentFinal);
		return $contentFinal;
	}
}
?>
