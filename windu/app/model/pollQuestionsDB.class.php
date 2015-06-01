<?php /*windu.org model*/
class pollQuestionsDB extends baseDB
{
	public function add($data)
	{
		$data['ekey'] = generate::ekey($this);
		$this->insert($data);
		return $returnData;
	}
	public function getFullQuestions($pollId) {
		$pollAnswersDB = new pollAnswersDB();
		
		$questions = $this->fetchAll("pollId={$pollId}");
		
		$finalObject = new stdClass();
		foreach ($questions as $question){
			$question->votes = $pollAnswersDB->getVotesCount($question->id);
			$questionsFinal[] = $question;
		}
		return $questionsFinal;
	}
}
?>