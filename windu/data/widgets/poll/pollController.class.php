<?php /*windu.org model*/
Class pollController extends widgetMainController
{		
	public function run() {
		$pollsDB = new pollsDB();

		if (is_numeric($this->params['id'])) {
			$id = $this->params['id'];
		}else{
			$id = $pollsDB->fetchRow(null,"RAND()")->id;
		}
		
		$poll = $pollsDB->getFullPoll($id);
		$votesCount = $pollsDB->getVotesCount($id);
		
		return array('poll'=>$poll,'votesCount'=>$votesCount,'cookie' => cookie::readCookie('poll-'.md5($poll->id)));
	}
}
?>