<?php

namespace JITR\Components;

abstract class Component {
	/** @var Array */
	public $arguments = array();    // The list input arguments for this component
	/** @var Array */
	public $internal = array();     // The list of internal arguments for this component
	/** @var Array */
	public $results = array();      // The output arguments for this component
	/** @var Int */
	private $resultsLength;
	/** @var Int */
	private $argumentsLength;
	/** @var \JITR\Interpreter[] */
	public $interpreterOutputs = array();

	protected $inputComponents = array();
	protected $outputComponents = array();

	public abstract function in($fromComponent);
	public abstract function out();

	public function __construct($minimumResults = 0, $minimumArguments = 0) {
		$this->resultsLength = $minimumResults;
		$this->argumentsLength = $minimumArguments;
	}

	public function validate() {
		if (count($this->results) < $this->resultsLength) {
			// TODO:  Throw exception
		}

		if (count($this->arguments) < $this->argumentsLength) {
			// TODO:  Throw exception
		}
	}

	public function parseArguments(Array $args = array()) {
		$this->arguments = $args;
	}
}