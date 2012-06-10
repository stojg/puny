<?php

namespace stojg\puny;

/**
 * Description of Post
 *
 * @author stig
 */
class Post {

	/**
	 *
	 * @var string
	 */
	protected $filename = '';

	/**
	 *
	 * @var string
	 */
	protected $metaDivider = "---\n";

	/**
	 *
	 * @var string
	 */
	protected $content;

	protected $layout;

	protected $title;

	protected $comments;

	protected $date;

	protected $categories;

	protected $loaded = false;
	
	/**
	 *
	 * @param string $filepath
	 */
	public function __construct($filepath) {
		$this->filename = $filepath;
	}

	/**
	 *
	 * @return string
	 */
	public function toHTML() {
		$markdown = new dflydev\markdown\MarkdownParser();
		return $markdown->transformMarkdown($this->getContent());
	}

	public function getTitle() {
		if(!$this->loaded) {
			$this->setContent();
		}
		return $this->title;
	}

	public function getDate($format = 'Y-m-d H:i:s') {
		if(!$this->loaded) {
			$this->setContent();
		}
		return date($format, strtotime($this->date));
	}

	public function getCategories() {
		if(!$this->loaded) {
			$this->setContent();
		}
		return $this->categories;
	}

	/**
	 *
	 * @return string
	 */
	public function getContent() {
		if(!$this->loaded) {
			$this->setContent();
		}
		return $this->content;
	}

	/**
	 *
	 * @param string $content
	 */
	protected function setContent() {
		$content = trim(file_get_contents($this->filename));
		$startMeta = strpos($content, $this->metaDivider);
		$endMeta = strpos($content, $this->metaDivider, 1);
		if($startMeta === 0 && $endMeta) {
			$metaData = substr($content, $startMeta, $endMeta+strlen($this->metaDivider));
			$this->setMetadata($metaData);
			$content = substr_replace($content, '', $startMeta, $endMeta+strlen($this->metaDivider));
		}
		$this->content = trim($content);
		$this->loaded = true;
	}

	/**
	 *
	 * @param string $string
	 */
	protected function setMetadata($string) {
		$lines = explode(PHP_EOL, $string);
		foreach($lines as $line) {
			$dividerPos = strpos($line, ':');
			if($dividerPos === false) {
				continue;
			}

			$property = trim(substr($line, 0, $dividerPos));
			$value = trim(substr($line, $dividerPos+1));

			if(!$property || !$value) {
				continue;
			}

			if(strpos($value, '"') === 0) {
				$value = str_replace('"', '',$value);
			}

			if(strstr($value, '[')) {
				$value = str_replace(array('[',']'), '', $value);
				$value = explode(',', $value);
			}

			$this->$property = $value;

			
		}
	}
}