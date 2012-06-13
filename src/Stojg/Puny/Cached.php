<?php
namespace stojg\puny;

/**
 * Wraps a class with APC cache
 */
class Cached {

	/**
	 *
	 * @var Object
	 */
	protected $object = null;

	/**
	 *
	 * @param type $class
	 */
	public function __construct($class) {
		$this->object = $class;
	}

	/**
	 *
	 * @param string $methodName
	 * @param array $arguments
	 * @return mixed
	 */
	public function __call($methodName, $arguments) {

		if(method_exists($this->object, $methodName)) {
			$callableName = $methodName;
		}

		if(method_exists($this->object, 'get'.$methodName)) {
			$callableName = 'get'.$methodName;
		}

		if(!$callableName) {
			throw new Exception('Can\'t call ', get_class($this->object).'::'.$methodName);
		}

		if($this->getCache($callableName, $arguments, $data)) {
			return $data;
		}
		
		$data = call_user_func_array(array($this->object, $callableName), $arguments);
		
		$this->setCache($callableName, $arguments, $data);
		return $data;
	}

	/**
	 *
	 * @param type $methodName
	 * @param type $arguments
	 * @param type $data
	 * @return boolean
	 */
	protected function getCache($methodName, $arguments, &$data) {
		if(!$this->cacheIsEnabled()) {
			return false;
		}
		$cacheKey = $this->object->getCacheKey().$methodName.md5(serialize($arguments));
		$data = apc_fetch($cacheKey, $cacheHit);
		return $cacheHit;
	}

	/**
	 *
	 * @param type $methodName
	 * @param type $arguments
	 * @param type $data
	 * @return boolean
	 */
	protected function setCache($methodName, $arguments, $data) {
		if(!$this->cacheIsEnabled()) {
			return false;
		}
		$cacheKey = $this->object->getCacheKey().$methodName.md5(serialize($arguments));
		apc_store($cacheKey, $data);
	}

	/**
	 *
	 * @return boolean
	 */
	protected function cacheIsEnabled() {
		if(!function_exists('apc_fetch')) {
			return false;
		}
		if(!method_exists($this->object, 'getCacheKey')) {
			return false;
		}
		return true;
	}
}