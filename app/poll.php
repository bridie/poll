<?php

namespace App;

use App\Question;
use App\Option;

class Poll
{
	private $question;
	private $options;

	public function __construct($question, $options)
	{
		$this->question = ($question instanceof Question) ? $question : new Question($question);
		$this->options = ($options[0] instanceof Option) ? $options : array_map(array($this, 'setOptions'), $options);
	}

	public function getQuestion()
	{
		return $this->question;
	}

	public function getOptions()
	{
		return $this->options;
	}

	public function create()
	{
		$this->question->create();
		foreach ($this->options as $option) {
			$option->setQuestionId($this->question->getId());
			$option->create();
		}
	}

	private function setOptions($option)
	{
		return new Option($option);
	}

	public static function getPollFromUrlComponent($urlComponent)
	{
		$question = Question::getQuestionFromUrlComponent($urlComponent);
		$options = Option::getOptionsFromQuestionId($question->getId());
		$poll = new Static($question, $options);
		return $poll;
	}
}