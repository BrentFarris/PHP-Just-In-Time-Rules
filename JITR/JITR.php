<?php

namespace JITR;

class JITR {

	/** @var Interpreter */
	private $interpreter = null;

	public function __construct() {
		$this->interpreter = new Interpreter();
	}

	public function run($script) {
		$this->interpreter->parse($script, true);

		self::runInterpreter($this->interpreter);
		return $this->interpreter;
	}

	public static function runInterpreter($interpreter) {
		/** @var \JITR\Components\Component */
		$previousComponent = null;
		foreach ($interpreter->components as $component) {   /** @var \JITR\Components\Component $component */
			$component->validate();
			$component->in($previousComponent);
			$component->out();
			$previousComponent = $component;
		}
	}
}