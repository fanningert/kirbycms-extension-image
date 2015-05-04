<?php

namespace at\fanninger\kirby\extension\imageext;

use at\fanninger\kirby\extension\webhelper\WebHelper;

require_once 'kirbycms-extension-image-lib-gd.php';

class ImageExtImage {
	
	protected $driver = null;
	protected $parameter = array();
	
	public function __construct($attr) {
		if ( !is_array($attr) )
			throw new \Exception("Missing attribute array");
		
		$this->parameter = $attr;
		
		// Create instance of driver class
		$class_name = "ImageExtDriver".strtoupper($this->parameter[ImageExt::PARA_DRIVER]);
		if ( class_exists( $class_name ) === true ){
			$this->driver = new $class_name( $this->parameter[ImageExt::PARA_PAGE_ROOT].DS.$this->parameter[ImageExt::PARA_IMG_SOURCE] );
		}else{
			// Fallback, try to load GD
			$this->driver = new ImageExtDriverGD( $this->parameter[ImageExt::PARA_PAGE_ROOT].DS.$this->parameter[ImageExt::PARA_IMG_SOURCE] );
		}
	}
	
	public function executeFunctions(){
		// Resize
		if ( $this->parameter[ImageExt::PARA_MODE] === ImageExt::MODE_RESIZE ) {
			$upscale = $this->parameter[ImageExt::PARA_UPSCALE];
			if ( is_int($this->parameter[ImageExt::PARA_IMG_WIDTH]) && is_int($this->parameter[ImageExt::PARA_IMG_HEIGHT]) ) {
				$this->driver->resize( $this->parameter[ImageExt::PARA_IMG_WIDTH], $this->parameter[ImageExt::PARA_IMG_HEIGHT], $upscale);
			} elseif ( is_int($this->parameter[ImageExt::PARA_IMG_WIDTH]) ) {
				$this->driver->fit_to_width( $this->parameter[ImageExt::PARA_IMG_WIDTH], $upscale);
			} elseif ( is_int($this->parameter[ImageExt::PARA_IMG_HEIGHT]) ) {
				$this->driver->fit_to_height( $this->parameter[ImageExt::PARA_IMG_HEIGHT], $upscale);
			}
		}
		// Crop
		if ( $this->parameter[ImageExt::PARA_MODE] === ImageExt::MODE_CROP ) {
			if ( is_int($this->parameter[ImageExt::PARA_IMG_CROP_LEFT]) && is_int($this->parameter[ImageExt::PARA_IMG_CROP_TOP]) 
					&& is_int($this->parameter[ImageExt::PARA_IMG_WIDTH]) && is_int($this->parameter[ImageExt::PARA_IMG_HEIGHT]) ) {
				
			} elseif ( is_int($this->parameter[ImageExt::PARA_IMG_WIDTH]) && is_int($this->parameter[ImageExt::PARA_IMG_HEIGHT]) ) {
				$this->driver->thumbnail( $this->parameter[ImageExt::PARA_IMG_WIDTH], $this->parameter[ImageExt::PARA_IMG_HEIGHT]);
			}
		}
		
		// Execute filter
		foreach ( $this->parameter as $key => $value ) {
			switch ($key) {
				case ImageExt::PARA_FILTER_BLUR:
					if ( $value !== false ) {
						$this->driver->adaptiveBlurImage($value);
					}
					break;
				case ImageExt::PARA_FILTER_GRAYSCALE:
					if ( $value !== false ) {
						$this->driver->desaturate( $value );
					}
					break;
				case ImageExt::PARA_FILTER_BRIGHTNESS:
					if ( $value !== false ) {
						$this->driver->brightness($value);
					}
					break;
				case ImageExt::PARA_FILTER_CONTRAST:
					if ( $value !== false ) {
						$this->driver->contrast($value);
					}
					break;
				case ImageExt::PARA_FILTER_COLORIZE:
					// {color_hex}[,opacity]
					if ( $value !== false && !empty($value) ) {
						$split_array = explode(',', $value);
						$color = $split_array[0];
						$opacity = 100;
						if ( count($split_array) > 1 ){
							$opacity = $split_array[1];
							if ( is_numeric($opacity) && intval($opacity) > 0) {
								$opacity = intval($opacity);
								if ( $opacity > 100 )
									$opacity = 100;
							} else {
								$opacity = 100;
							}
						}
						if ( !empty($color) ) {
							$this->driver->colorize($color, $opacity);
						} 
					}
					break;
				case ImageExt::PARA_FILTER_EDGES:
					if ( $value !== false ) {
						$this->driver->edges();
					}
					break;
				case ImageExt::PARA_FILTER_EMBOSS:
					if ( $value !== false ) {
						$this->driver->emboss();
					}
					break;
				case ImageExt::PARA_FILTER_INVERT:
					if ( $value !== false ) {
						$this->driver->invert();
					}
					break;
				case ImageExt::PARA_FILTER_OPACITY:
					if ( $value !== false ) {
						$this->driver->opacity($value);
					}
					break;
				case ImageExt::PARA_FILTER_SEPIA:
					if ( $value !== false ) {
						$this->driver->sepia();
					}
					break;
				case ImageExt::PARA_FILTER_SKETCH:
					if ( $value !== false ) {
						$this->driver->sketch();
					}
					break;
				case ImageExt::PARA_FILTER_SMOOTH:
					if ( $value !== false ) {
						$this->driver->smooth($value);
					}
					break;
				case ImageExt::PARA_FILTER_PIXELATE:
					if ( $value !== false ) {
						$this->driver->pixelate($value);
					}
					break;
				case ImageExt::PARA_FILTER_OVERLAY:
					// {image-filename}[,position][,opacity][,offsetx][,offsety]
					if ( $value !== false ) {
						//TODO:
					}
					break;
				default:
			}
		}
		
		return $this;
	}
	
	public function saveFile(){
		@$this->driver->save( $this->parameter[ImageExt::PARA_IMG_OUTPUT_ROOT], $this->parameter[ImageExt::PARA_IMG_QUALITY] );
		
		return $this;
	}
	
	public function toHTML(){
		// Image
		$attr = array();
		if ( !empty($this->parameter[ImageExt::PARA_IMG_OUTPUT_URL]) )
			$attr['src'] = $this->parameter[ImageExt::PARA_IMG_OUTPUT_URL];
		if ( !empty($this->parameter[ImageExt::PARA_IMG_CLASS]) )
			$attr['class'] = $this->parameter[ImageExt::PARA_IMG_CLASS];
		if ( !empty($this->parameter[ImageExt::PARA_IMG_ALT]) )
			$attr['alt'] = $this->parameter[ImageExt::PARA_IMG_ALT];
		if ( !empty($this->parameter[ImageExt::PARA_IMG_TITLE]) )
			$attr['title'] = $this->parameter[ImageExt::PARA_IMG_TITLE];
		$content = \Html::tag("img", null, $attr);
		
		// Hyperlink
		if ( !empty($this->parameter[ImageExt::PARA_LINK_URL]) ) {
			$attr = array();
			if ( !empty($this->parameter[ImageExt::PARA_LINK_REL]) )
				$attr['rel'] = $this->parameter[ImageExt::PARA_LINK_REL];
			if ( !empty($this->parameter[ImageExt::PARA_LINK_TARGET]) )
				$attr['target'] = $this->parameter[ImageExt::PARA_LINK_TARGET];
			if ( !empty($this->parameter[ImageExt::PARA_LINK_TITLE]) )
				$attr['title'] = $this->parameter[ImageExt::PARA_LINK_TITLE];
			if ( !empty($this->parameter[ImageExt::PARA_LINK_CLASS]) )
				$attr['class'] = $this->parameter[ImageExt::PARA_LINK_CLASS];
			if ( !empty($this->parameter[ImageExt::PARA_GALLERY_LINK_CLASS]) ) {
				if ( !empty($attr['class']) )
					$attr['class'] = $attr['class']." ".$this->parameter[ImageExt::PARA_GALLERY_LINK_CLASS];
				else
					$attr['class'] = $this->parameter[ImageExt::PARA_GALLERY_LINK_CLASS];
			}
			if ( !empty($this->parameter[ImageExt::PARA_GALLERY_ID]) ){
				$attr[$this->parameter[ImageExt::PARA_GALLERY_LINK_ATTR]] = $this->parameter[ImageExt::PARA_GALLERY_PREFIX].$this->parameter[ImageExt::PARA_GALLERY_ID];
			}
			$content = \Html::a($this->parameter[ImageExt::PARA_LINK_URL], $content, $attr);
		}
		
		// Figure
		if ( $this->parameter[ImageExt::PARA_FIGURE_CAPTION] !== false && !empty($this->parameter[ImageExt::PARA_FIGURE_CAPTION]) ) {
			if ( $this->parameter[ImageExt::PARA_FIGURE_CAPTION] === true && !empty($this->parameter[ImageExt::PARA_FIGURE_CAPTION_FIELD]) && $this->parameter[ImageExt::PARA_FIGURE_CAPTION_FIELD] !== false ){
				$content = WebHelper::blockFigure($content, $this->parameter[ImageExt::PARA_FIGURE_CAPTION_FIELD], $this->parameter[ImageExt::PARA_FIGURE_CAPTION_TOP], $this->parameter[ImageExt::PARA_FIGURE_CLASS]);
			} else {
				$content = WebHelper::blockFigure($content, $this->parameter[ImageExt::PARA_FIGURE_CAPTION], $this->parameter[ImageExt::PARA_FIGURE_CAPTION_TOP], $this->parameter[ImageExt::PARA_FIGURE_CLASS]);
			}
		}
		
		return $content;
	}
	
	public function __toString(){
		return $this->toHTML();
	}
}