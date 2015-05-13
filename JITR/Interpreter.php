<?php

namespace JITR;

class Interpreter {

	const OUT_SIZE = 4;
	const USE_SIZE = 4;
	const RUN_SIZE = 4;

	/** @var String */
	public $script;
	/** @var String[] */
	public $lines = array();
	/** @var Array */
	public static $vars = array();
	/** @var \JITR\Components\Component[] */
	public $components = array();

	/** @var Array */
	public static $internals = array(
		'id' => 1,
		'coins' => 100
	);

	public function parse($script, $compress = false) {
		$this->script = preg_replace('/\s+/', '', $script);

		foreach (self::$internals as $key => $value) {
			$this->script = str_replace('$' . $key, $value, $this->script);
		}

		$this->lines = explode(';', $this->script);

		$inSubscript = false;
		/** @var Interpreter $subInterpreter */
		$subInterpreter = null;
		$subScript = '';
		/** @var \JITR\Components\Component $currentComponent */
		$currentComponent = null;
		foreach ($this->lines as $line) {
			if (empty($line)) {
				continue;
			}

			if ($line[0] == '}') {
				$subInterpreter->parse($subScript);
				$currentComponent->interpreterOutputs[] = $subInterpreter;
				$inSubscript = false;
				$subInterpreter = null;
			}

			if ($inSubscript) {
				if ($line[0] == '|') {
					$subInterpreter->parse($subScript);
					$currentComponent->interpreterOutputs[] = $subInterpreter;

					$subInterpreter = new Interpreter();
					$line = ltrim($line, '|');
					$subScript = $line.';';
				} else {
					$subScript .= $line.';';
				}
			} else if (strpos($line, '#') === 0) {
				$kv = explode('=', $line);
				if (!array_key_exists($kv[0], self::$vars)) {
					if (count($kv) == 2) {
						if ($kv[1] === 'true') {
							self::$vars[$kv[0]] = true;
						} else if ($kv[1] === 'false') {
							self::$vars[$kv[0]] = false;
						} else {
							self::$vars[$kv[0]] = $kv[1];
						}
					} else {
						self::$vars[$kv[0]];
					}
				}
			} else if (strpos($line, "\\JITR\\Components\\") === 0) {

				// Load the required class dynamically
				require_once(__DIR__.'/..'.str_replace("\\", '/', $line.'.php'));

				$this->components[] = new $line();
				$currentComponent = end($this->components);
			} else if (strpos($line, 'use(') === 0) {
				$args = explode(',', substr($line, self::USE_SIZE, strpos($line, ')') - self::USE_SIZE));
				foreach ($args as $arg) {
					if (array_key_exists($arg, self::$vars)) {
						$currentComponent->arguments[] = &self::$vars[$arg];
					}
				}
			} else if (strpos($line, 'out[') === 0) {
				$args = explode(',', substr($line, self::OUT_SIZE, strpos($line, ']') - self::OUT_SIZE));
				foreach ($args as $arg) {
					if (array_key_exists($arg, self::$vars)) {
						$currentComponent->results[] = &self::$vars[$arg];
					}
				}
			} else if (strpos($line, 'run{') === 0) {
				$inSubscript = true;
				$line = substr($line, self::RUN_SIZE);
				if ($subInterpreter == null) {
					$subInterpreter = new Interpreter();
					$subScript = $line.';';
				}
			}
		}

		if ($compress) {
			$this->compress();
		}
	}

	private function compress() {
		$compressVars = explode(',', 'a,s,d,f,g,h,j,k,l,q,w,e,r,t,y,u,i,o,p,z,x,c,v,b,n,m');
		$current = 0;
		$extended = 0;
		foreach (self::$vars as $key=>$value) {
			if ($extended > 0) {
				$this->script = str_replace($key, '#' . $compressVars[$current] . $extended, $this->script);
			} else {
				$this->script = str_replace($key, '#' . $compressVars[$current], $this->script);
			}

			$current++;
			if ($current === 26) {
				$current = 0;
				$extended++;
			}
		}
	}
}