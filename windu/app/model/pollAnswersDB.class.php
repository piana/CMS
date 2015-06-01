<?php /*windu.org model*/
class pollAnswersDB extends baseDB
{
	public function addVote($questionEkey)
	{
		$questionsDB = new pollQuestionsDB();
		$question = $questionsDB->fetchRow("ekey='{$questionEkey}'");

		$voterIp = generate::ip();
		$cookieName = 'poll-'.md5($question->pollId);
		
		if ($this->fetchCount("questionId={$question->id} and createIP = '{$voterIp}'")==0 and cookie::get($cookieName)!=1) {
			$data['questionId'] = $question->id;
			$data['createTime'] = generate::sqlDatetime();
			$data['createIp'] = $voterIp;
			
			$this->insert($data);
			return true;
		}
		cookie::setCookie($cookieName,1);
		return false;
	}
	public function getVotesCount($questionId) {
		return intval($this->fetchCount("questionId={$questionId}"));
	}

}
?>