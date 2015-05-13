<?php

namespace JITR\Components\Debug;

use JITR\Components\Component;

class Log extends Component {

	public function __construct($minimumResults = 0, $minimumArguments = 0) {
		parent::__construct(0, 1);
	}

	public function in($fromComponent) {

	}

	public function out() {
		echo print_r($this->arguments, true);

		return $this->results;
	}
}