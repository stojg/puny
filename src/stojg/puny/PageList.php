<?php

namespace stojg\puny;

/**
 * This object represents a list of pages and can be used as list normally get
 * used as.
 * 
 */
class PageList {
	
	/**
	 * 
	 * @var DataSource
	 */
	protected $source = null;

	/**
	 *
	 * @var int
	 */
	protected $itemsPerPage;

	/**
	 *
	 * @param DataSource $source
	 */
	public function __construct(DataSource $source) {
		$this->source = $source;
	}

	/**
	 *
	 * @return DataSource
	 */
	public function getSource() {
		return $this->source;
	}

	/**
	 *
	 * @return int
	 */
	public function count() {
		return $this->source->count();
	}

	/**
	 *
	 * @param int$limit
	 * @return \stojg\puny\PageList
	 */
	public function limit($limit) {
		$this->source->limit($limit);
		return $this;
	}

	/**
	 *
	 * @param int $offset
	 * @return \stojg\puny\PageList
	 */
	public function offset($offset) {
		$this->source->offset($offset);
		return $this;
	}

	/**
	 *
	 * @param int $limit
	 * @return \stojg\puny\PageList
	 */
	public function itemsPerPage($limit) {
		$this->itemsPerPage = (int) $limit;
		return $this;
	}

	/**
	 *
	 * @return \stojg\puny\Page
	 */
	public function first() {
		$data = json_decode($this->source->first());
		return new Page($data);
	}

	/**
	 * Fetch a 'page', a list of items from the chosen page.
	 * The itemsPerPage variable must be set before fetching entries
	 * 
	 * @param int $page
	 * @return ArrayIterator
	 */
	public function page($page) {
		$limit = $this->itemsPerPage;
		$offset = $limit * max(0, $page-1);
		$pages = $this->source->limit($limit)->offset($offset)->toArray();
		$result = new \ArrayIterator();
		foreach($pages as $page) {
			$result->append(new Page(json_decode($page)));
		}
		return $result;
	}

	/**
	 * Get all pages and if $getDraft is true it will also include draft pages
	 *
	 * @param bool $getDraft
	 * @return \ArrayIterator
	 */
	public function get($getDraft=false) {
		$this->source->draft($getDraft);
		$pages = $this->source->toArray();
		$result = new \ArrayIterator();
		foreach($pages as $page) {
			$result->append(new Page(json_decode($page)));
		}
		return $result;
	}
}