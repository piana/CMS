<?php /*windu.org model*/
class pollsDB extends baseDB
{
	public function add($data)
	{
		$data['status'] = 0;
		$this->insert($data);
		return $returnData;
	}
	public function getFullPoll($pollId) {
		$pollQuestionsDB = new pollQuestionsDB();
		
		$poll = $this->fetchRow("id={$pollId}");
		$poll->questions = $pollQuestionsDB->getFullQuestions($pollId);
		
		return $poll;
	}
	public function getVotesCount($pollId) {
		$questionIdList = self::getCommaArrayQuestions($pollId);
		$pollAnswersDB = new pollAnswersDB();
		
		return $pollAnswersDB->fetchCount("questionId in ({$questionIdList})");
	}	
	public static function getCommaArrayQuestions($pollId) {
		$pollQuestionsDB = new pollQuestionsDB();
		$questions = $pollQuestionsDB->fetchAll("pollId = {$pollId}");
		
		foreach ($questions as $question){
			$questionIdList .= $question->id.',';
			
		}
		$questionIdList = rtrim($questionIdList,',');
		return $questionIdList;
	}

}
?>