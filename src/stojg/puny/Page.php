<?php
namespace stojg\puny;

class Page {
	
	protected $title = null;

	protected $date = null;

	protected $comments = null;

	protected $categories = null;

	protected $draft = null;

	protected $content = null;

	public function __construct(\stdClass $data) {
		$this->title = $data->title;
		$this->date = $data->date;
		$this->comments = $data->comments;
		$this->categories = $data->categories;
		$this->draft = $data->draft;
		$this->content = $data->content;
	}

	public function title() {
		return $this->title;
	}

	public function date() {
		return $this->date;
	}

	public function comments() {
		return $this->comments;
	}

	public function categories() {
		return $this->categories;
	}

	public function draft() {
		return $this->draft;
	}

	public function content() {
		return $this->content;
	}
}