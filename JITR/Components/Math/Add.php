<?php

namespace JITR\Components\Math;

use JITR\Components\Component;

class Add extends Component {

	public function in($fromComponent) {

	}

	public function out() {
		$total = reset($this->arguments);
		for ($i = 1; $i < count($this->arguments); $i++) {
			$total += $this->arguments[$i];
		}

		$this->results[0] = $total;
		return $this->results;
	}
}