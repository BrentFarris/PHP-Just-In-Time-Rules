<?php

namespace JITR\Components\Math;

use JITR\Components\Component;

class GreaterThan extends Component {

	public function __construct($minimumResults = 0, $minimumArguments = 0) {
		parent::__construct(1, 2);
	}

	public function in($fromComponent) {

	}

	public function out() {
		$greater = $this->arguments[0] > $this->arguments[1];
		$this->results[0] = $greater;

		if ($greater) {
			if (isset($this->interpreterOutputs[0])) {
				\JITR\JITR::runInterpreter($this->interpreterOutputs[0]);
			}
		} else {
			if (isset($this->interpreterOutputs[1])) {
				\JITR\JITR::runInterpreter($this->interpreterOutputs[1]);
			}
		}

		return $this->results;
	}
}