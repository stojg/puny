<?php
namespace stojg\puny;

/**
 * Represents a single post
 *
 */
class File {

	/**
	 *
	 * @var type
	 */
	protected $filepath = '';

	/**
	 *
	 * @var string
	 */
	protected $mime = '';

	/**
	 *
	 * @var string
	 */
	protected $charset = '';

	/**
	 *
	 * @var string
	 */
	protected $basename = '';
	
	/**
	 *
	 * @param string $filepath
	 */
	public function __construct($filepath) {
		$this->filepath = $filepath;
		$this->basename = basename($filepath);
		$finfo = new \finfo(FILEINFO_MIME);
		list($this->mime, $this->charset) = explode('; ',$finfo->file($filepath));
	}

	public function getURL($width, $height) {

		$thumbnailPath = 'assets/thumbs/'.$width.'_'.$height.'_'.$this->basename;
		
		$center = new \stojg\crop\CropCenter($this->filepath);
		$croppedImage = $center->resizeAndCrop($width, $height);
		
		#$this->enhance($croppedImage);
		$croppedImage->writeimage($thumbnailPath);

		return $thumbnailPath;
	}

	/**
	 * Do some tricks to cleanup and minimize the thumbnails size
	 *
	 * @param Imagick $image
	 */
	protected function enhance(\Imagick $image) {
		$image->setImageCompression(\Imagick::COMPRESSION_JPEG);
		$image->setImageCompressionQuality(75);
		$image->contrastImage( 1 );
		$image->adaptiveBlurImage( 1, 1 );
		$image->stripImage();
	}
}