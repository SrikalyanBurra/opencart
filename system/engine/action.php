<?php
class Action {
	private $id;
	private $route;
	private $method = 'index';

	public function __construct($route) {
		$this->id = $route;
		
		$parts = explode('/', preg_replace('/[^a-zA-Z0-9_\/]/', '', (string)$route));
		//$file_test = fopen('file_test.txt', 'w+');
		//fwrite($file_test,implode(',',$parts));
		//fclose($file_test);
		//exit();
		//test_dump(implode(',',$parts));
		
		// Break apart the route
		//$i=0;
		while ($parts) {
			$file = DIR_APPLICATION . 'controller/' . implode('/', $parts) . '.php';
			//fwrite($file_test,implode(',',$parts)."number: ".$i."\n");
			//$i=$i+1;
			if (is_file($file)) {
				$this->route = implode('/', $parts);		
				
				break;
			} else {
				$this->method = array_pop($parts);
			}
		}
		//exit();
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function execute($registry, array $args = array()) {
		// Stop any magical methods being called
		if (substr($this->method, 0, 2) == '__') {
			return new \Exception('Error: Calls to magic methods are not allowed!');
		}

		$file = DIR_APPLICATION . 'controller/' . $this->route . '.php';		
		$class = 'Controller' . preg_replace('/[^a-zA-Z0-9]/', '', $this->route);
		
		// Initialize the class
		if (is_file($file)) {
			include_once($file);
		
			$controller = new $class($registry);
		} else {
			return new \Exception('Error: Could not call ' . $this->route . '/' . $this->method . '!');
		}
		
		$reflection = new ReflectionClass($class);
		
		if ($reflection->hasMethod($this->method) && $reflection->getMethod($this->method)->getNumberOfRequiredParameters() <= count($args)) {
			//test_dump(get_class($controller)." ".$this->method);
			return call_user_func_array(array($controller, $this->method), $args);
		} else {
			return new \Exception('Error: Could not call ' . $this->route . '/' . $this->method . '!');
		}
	}
}
