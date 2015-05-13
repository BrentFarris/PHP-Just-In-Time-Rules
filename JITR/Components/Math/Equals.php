<?php

namespace JITR\Components\Math;

use JITR\Components\Component;

class Equals extends Component {

	public function __construct($minimumResults = 0, $minimumArguments = 0) {
		parent::__construct(1, 2);
	}

	public function in($fromComponent) {

	}

	public function out() {
		$same = true;
		for ($i = 1; $i < count($this->arguments); $i++) {
			if ($this->arguments[0] != $this->arguments[$i]) {
				$same = false;
				break;
			}
		}

		$this->results[0] = $same;

		if ($same) {
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