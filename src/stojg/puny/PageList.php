<?php

namespace stojg\puny;

class PageList {
	
	/**
	 * 
	 * @var DataSource
	 */
	protected $source = null;

	public function __construct(DataSource $source) {
		$this->source = $source;
	}

	public function getSource() {
		return $this->source;
	}

	public function count() {
		return $this->source->count();
	}

	public function limit($limit) {
		$this->source->limit($limit);
		return $this;
	}

	public function offset($offset) {
		$this->source->offset($offset);
		return $this;
	}

	public function first() {
		$data = json_decode($this->source->first());

		return new Page($data);
	}
}