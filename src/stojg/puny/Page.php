<?php
namespace stojg\puny;

/**
 * This is the object representing a ordinary page
 */
class Page {

	/**
	 *
	 * @var string
	 */
	protected $title = null;

	/**
	 *
	 * @var string
	 */
	protected $date = null;

	/**
	 *
	 * @var boolean
	 */
	protected $comments = null;

	/**
	 *
	 * @var array
	 */
	protected $categories = array();

	/**
	 *
	 * @var boolean
	 */
	protected $draft = null;

	/**
	 *
	 * @var string
	 */
	protected $content = null;

	/**
	 *
	 * @param \stdClass $data
	 */
	public function __construct(\stdClass $data) {
		$this->title = $data->title;
		$this->date = $data->date;
		$this->comments = $data->comments;
		$this->categories = $data->categories;
		$this->draft = isset($data->draft)?$data->draft:null;
		$this->content = $data->content;
	}

	/**
	 *
	 * @return string
	 */
	public function title() {
		return $this->title;
	}

	/**
	 *
	 * @return date
	 */
	public function date() {
		return $this->date;
	}

	/**
	 *
	 * @return bool
	 */
	public function comments() {
		return $this->comments;
	}

	/**
	 *
	 * @return array
	 */
	public function categories() {
		return $this->categories;
	}

	/**
	 *
	 * @return bool
	 */
	public function draft() {
		return $this->draft;
	}

	/**
	 *
	 * @return string
	 */
	public function content() {
		return $this->content;
	}
}