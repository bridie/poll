<?php

namespace App;

use App\Question;
use App\Option;

class Poll
{
	private $question;
	private $options;
	private $database;

	public function __construct($question, $options, $database)
	{
		$this->database = $database;
		$this->question = new Question($question, $database);
		$this->options = array_map(array($this, 'setOptions'), $options);
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
		return new Option($option, $this->database);
	}
}