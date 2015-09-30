<?php

namespace at\fanninger\kirby\extension\imageext;

use at\fanninger\kirby\extension\webhelper\WebHelper;

require_once 'kirbycms-extension-image-lib-gd.php';

class ImageExtImage extends ImageExtObject {
	
	protected $driver = null;
	
	public function parse($tag, array $block, array $attr_template = null){
		$this->data[self::ARRAY_TYPE] = self::TYPE_IMAGE;
		parent::parse($tag, $block, $attr_template);
	}
	
	public function parseFileAttributes(){
		$source = $this->data[self::ARRAY_ATTR][self::PARA_IMG_SOURCE];
		$source = ( is_object( $source ) )? $source : $this->imageExt->getPage()->file ( $source );
		if ( $source ) {
			$this->data[self::ARRAY_ATTR][self::PARA_IMG_SOURCE] = $source->filename();
			$this->data[self::ARRAY_ATTR][self::PARA_IMG_SOURCE_MODIFIED] = $source->modified();
			$this->data[self::ARRAY_ATTR][self::PARA_IMG_EXTENSION] = $source->extension();
			$this->data[self::ARRAY_ATTR][self::PARA_IMG_OUTPUT_FILENAME] = \str::template($this->data[self::ARRAY_ATTR][self::PARA_IMG_OUTPUT_FILENAME], array(
					'extension'    => $source->extension(),
					'name'         => $source->name(),
					'filename'     => $source->filename(),
					'safeName'     => \f::safeName($source->name()),
					'safeFilename' => \f::safeName($source->name()) . '.' . $this->data[self::ARRAY_ATTR][self::PARA_IMG_EXTENSION],
					'width'        => $this->data[self::ARRAY_ATTR][self::PARA_IMG_WIDTH],
					'height'       => $this->data[self::ARRAY_ATTR][self::PARA_IMG_HEIGHT],
					'hash'         => md5($source->root() . $this->settingsIdentifier()),
			));
			$this->data[self::ARRAY_ATTR][self::PARA_IMG_OUTPUT_URL]  = $this->data[self::ARRAY_ATTR][self::PARA_IMG_OUTPUT_URL] . '/' . $this->data[self::ARRAY_ATTR][self::PARA_IMG_OUTPUT_FILENAME];
			$this->data[self::ARRAY_ATTR][self::PARA_IMG_OUTPUT_ROOT] = $this->data[self::ARRAY_ATTR][self::PARA_IMG_OUTPUT_ROOT] . DS . $this->data[self::ARRAY_ATTR][self::PARA_IMG_OUTPUT_FILENAME];
	
			if ( $this->data[self::ARRAY_ATTR][self::PARA_GALLERY_ID] !== false && !empty($this->data[self::ARRAY_ATTR][self::PARA_GALLERY_ID]) ) {
				$this->data[self::ARRAY_ATTR][self::PARA_LINK_URL] = $source->url();
			}

			if ( is_string( $this->data[self::ARRAY_ATTR][self::PARA_IMG_ALT] ) && WebHelper::startsWith($this->data[self::ARRAY_ATTR][self::PARA_IMG_ALT], '{file-') && WebHelper::endsWith($this->data[self::ARRAY_ATTR][self::PARA_IMG_ALT], '}') ) {
				$field = substr($this->data[self::ARRAY_ATTR][self::PARA_IMG_ALT], 6, strlen($this->data[self::ARRAY_ATTR][self::PARA_IMG_ALT])-7);
				$this->data[self::ARRAY_ATTR][self::PARA_IMG_ALT] = $source->{$field}()->toString();		
			}			
			if ( is_string( $this->data[self::ARRAY_ATTR][self::PARA_IMG_TITLE] ) && WebHelper::startsWith($this->data[self::ARRAY_ATTR][self::PARA_IMG_TITLE], '{file-') && WebHelper::endsWith($this->data[self::ARRAY_ATTR][self::PARA_IMG_TITLE], '}') ) {
				$field = substr($this->data[self::ARRAY_ATTR][self::PARA_IMG_TITLE], 6, strlen($this->data[self::ARRAY_ATTR][self::PARA_IMG_TITLE])-7);
				$this->data[self::ARRAY_ATTR][self::PARA_IMG_TITLE] = $source->{$field}()->toString();		
			}
			if ( is_string( $this->data[self::ARRAY_ATTR][self::PARA_LINK_TITLE] ) && WebHelper::startsWith($this->data[self::ARRAY_ATTR][self::PARA_LINK_TITLE], '{file-') && WebHelper::endsWith($this->data[self::ARRAY_ATTR][self::PARA_LINK_TITLE], '}') ) {
				$field = substr($this->data[self::ARRAY_ATTR][self::PARA_LINK_TITLE], 6, strlen($this->data[self::ARRAY_ATTR][self::PARA_LINK_TITLE])-7);
				$this->data[self::ARRAY_ATTR][self::PARA_LINK_TITLE] = $source->{$field}()->toString();		
			}
		}
	}
	
	public function generate(){
		// Check if file allready exist
		if ( $this->fileExist() )
			return;
	
		// Prüfe ob Quelle existiert
		if ( !file_exists($this->data[self::ARRAY_ATTR][self::PARA_PAGE_ROOT].DS.$this->data[self::ARRAY_ATTR][self::PARA_IMG_SOURCE]) ){
			return;
		}
		
		// Create instance of driver class
		$class_name = "ImageExtDriver".strtoupper($this->data[self::ARRAY_ATTR][self::PARA_DRIVER]);
		$filename = $this->data[self::ARRAY_ATTR][self::PARA_PAGE_ROOT].DS.$this->data[self::ARRAY_ATTR][self::PARA_IMG_SOURCE];
		if ( class_exists( $class_name ) === true ){
			$this->driver = new $class_name( $filename );
		}else{
			// Fallback, try to load GD
			$this->driver = new ImageExtDriverGD( $filename );
		}
		
		// Resize
		if ( $this->data[self::ARRAY_ATTR][self::PARA_MODE] === self::MODE_RESIZE ) {
			$upscale = $this->data[self::ARRAY_ATTR][self::PARA_UPSCALE];
			if ( is_int($this->data[self::ARRAY_ATTR][self::PARA_IMG_WIDTH]) && is_int($this->data[self::ARRAY_ATTR][self::PARA_IMG_HEIGHT]) ) {
				$this->driver->resize( $this->data[self::ARRAY_ATTR][self::PARA_IMG_WIDTH], $this->data[self::ARRAY_ATTR][self::PARA_IMG_HEIGHT], $upscale);
			} elseif ( is_int($this->data[self::ARRAY_ATTR][self::PARA_IMG_WIDTH]) ) {
				$this->driver->fit_to_width( $this->data[self::ARRAY_ATTR][self::PARA_IMG_WIDTH], $upscale);
			} elseif ( is_int($this->data[self::ARRAY_ATTR][self::PARA_IMG_HEIGHT]) ) {
				$this->driver->fit_to_height( $this->data[self::ARRAY_ATTR][self::PARA_IMG_HEIGHT], $upscale);
			}
		}
		// Crop
		if ( $this->data[self::ARRAY_ATTR][self::PARA_MODE] === self::MODE_CROP ) {
			if ( is_int($this->data[self::ARRAY_ATTR][self::PARA_IMG_CROP_LEFT]) && is_int($this->data[self::ARRAY_ATTR][self::PARA_IMG_CROP_TOP])
					&& is_int($this->data[self::ARRAY_ATTR][self::PARA_IMG_WIDTH]) && is_int($this->data[self::ARRAY_ATTR][self::PARA_IMG_HEIGHT]) ) {
	
					} elseif ( is_int($this->data[self::ARRAY_ATTR][self::PARA_IMG_WIDTH]) && is_int($this->data[self::ARRAY_ATTR][self::PARA_IMG_HEIGHT]) ) {
						$this->driver->thumbnail( $this->data[self::ARRAY_ATTR][self::PARA_IMG_WIDTH], $this->data[self::ARRAY_ATTR][self::PARA_IMG_HEIGHT]);
					}
		}
	
		// Execute filter
		foreach ( $this->data[self::ARRAY_ATTR] as $key => $value ) {
			switch ($key) {
				case self::PARA_FILTER_BLUR:
					if ( $value !== false ) {
						$this->driver->adaptiveBlurImage($value);
					}
					break;
				case self::PARA_FILTER_GRAYSCALE:
					if ( $value !== false ) {
						$this->driver->desaturate( $value );
					}
					break;
				case self::PARA_FILTER_BRIGHTNESS:
					if ( $value !== false ) {
						$this->driver->brightness($value);
					}
					break;
				case self::PARA_FILTER_CONTRAST:
					if ( $value !== false ) {
						$this->driver->contrast($value);
					}
					break;
				case self::PARA_FILTER_COLORIZE:
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
				case self::PARA_FILTER_EDGES:
					if ( $value !== false ) {
						$this->driver->edges();
					}
					break;
				case self::PARA_FILTER_EMBOSS:
					if ( $value !== false ) {
						$this->driver->emboss();
					}
					break;
				case self::PARA_FILTER_INVERT:
					if ( $value !== false ) {
						$this->driver->invert();
					}
					break;
				case self::PARA_FILTER_OPACITY:
					if ( $value !== false ) {
						$this->driver->opacity($value);
					}
					break;
				case self::PARA_FILTER_SEPIA:
					if ( $value !== false ) {
						$this->driver->sepia();
					}
					break;
				case self::PARA_FILTER_SKETCH:
					if ( $value !== false ) {
						$this->driver->sketch();
					}
					break;
				case self::PARA_FILTER_SMOOTH:
					if ( $value !== false ) {
						$this->driver->smooth($value);
					}
					break;
				case self::PARA_FILTER_PIXELATE:
					if ( $value !== false ) {
						$this->driver->pixelate($value);
					}
					break;
				case self::PARA_FILTER_OVERLAY:
					// {image-filename}[,position][,opacity][,offsetx][,offsety]
					if ( $value !== false ) {
						//TODO:
					}
					break;
				default:
			}
		}
	
		// Save new image
		$this->saveFile();
	}
	
	public function toHTML(){
		$content = "";
		
		if( $this->data[self::ARRAY_ATTR][self::PARA_SNIPPET_IMAGE] !== false && file_exists( kirby()->roots->snippets ().'/'.$this->data[self::ARRAY_ATTR][self::PARA_SNIPPET_IMAGE].'.php' ) ){
			$content = ( string ) snippet( $this->data[self::ARRAY_ATTR][self::PARA_SNIPPET_IMAGE], array( 'data' => $this->data), true );
		}else{
			if ( array_key_exists(self::ARRAY_SRCSET, $this->data) && is_array( $this->data[self::ARRAY_SRCSET] ) && count($this->data[self::ARRAY_SRCSET]) > 0 ){
				// Source image exist
				
				foreach ( $this->data[self::ARRAY_SRCSET] as $srcset ) {
					$attr = array();
					if ( !empty($this->data[self::ARRAY_ATTR][self::PARA_IMG_MIMETYPE]) )
						$attr['type'] = $this->data[self::ARRAY_ATTR][self::PARA_IMG_MIMETYPE];
					if ( !empty($this->data[self::ARRAY_ATTR][self::PARA_IMG_MEDIAQUERY]) )
						$attr['media'] = $this->data[self::ARRAY_ATTR][self::PARA_IMG_MEDIAQUERY];
					$content .= \Html::tag("source", null, $attr);
				}
				
				$attr = array();
				if ( !empty($this->data[self::ARRAY_ATTR][self::PARA_IMG_OUTPUT_URL]) )
					$attr['src'] = $this->data[self::ARRAY_ATTR][self::PARA_IMG_OUTPUT_URL];
				if ( !empty($this->data[self::ARRAY_ATTR][self::PARA_IMG_CLASS]) )
					$attr['class'] = $this->data[self::ARRAY_ATTR][self::PARA_IMG_CLASS];
				if ( !empty($this->data[self::ARRAY_ATTR][self::PARA_IMG_ALT]) )
					$attr['alt'] = $this->data[self::ARRAY_ATTR][self::PARA_IMG_ALT];
				if ( !empty($this->data[self::ARRAY_ATTR][self::PARA_IMG_TITLE]) )
					$attr['title'] = $this->data[self::ARRAY_ATTR][self::PARA_IMG_TITLE];
				$content .= \Html::tag("img", null, $attr);
				
				$attr = array();
				$content = \Html::tag("picture", $content, $attr);
			} else {
				// Image
				$attr = array();
				if ( !empty($this->data[self::ARRAY_ATTR][self::PARA_IMG_OUTPUT_URL]) )
					$attr['src'] = $this->data[self::ARRAY_ATTR][self::PARA_IMG_OUTPUT_URL];
				if ( !empty($this->data[self::ARRAY_ATTR][self::PARA_IMG_CLASS]) )
					$attr['class'] = $this->data[self::ARRAY_ATTR][self::PARA_IMG_CLASS];
				if ( !empty($this->data[self::ARRAY_ATTR][self::PARA_IMG_ALT]) )
					$attr['alt'] = $this->data[self::ARRAY_ATTR][self::PARA_IMG_ALT];
				if ( !empty($this->data[self::ARRAY_ATTR][self::PARA_IMG_TITLE]) )
					$attr['title'] = $this->data[self::ARRAY_ATTR][self::PARA_IMG_TITLE];
				$content = \Html::tag("img", null, $attr);
			}
			
			// Hyperlink
			if ( !empty($this->data[self::ARRAY_ATTR][self::PARA_LINK_URL]) ) {
				$attr = array();
				if ( !empty($this->data[self::ARRAY_ATTR][self::PARA_LINK_REL]) )
					$attr['rel'] = $this->data[self::ARRAY_ATTR][self::PARA_LINK_REL];
				if ( !empty($this->data[self::ARRAY_ATTR][self::PARA_LINK_TARGET]) )
					$attr['target'] = $this->data[self::ARRAY_ATTR][self::PARA_LINK_TARGET];
				if ( !empty($this->data[self::ARRAY_ATTR][self::PARA_LINK_TITLE]) )
					$attr['title'] = $this->data[self::ARRAY_ATTR][self::PARA_LINK_TITLE];
				if ( !empty($this->data[self::ARRAY_ATTR][self::PARA_LINK_CLASS]) )
					$attr['class'] = $this->data[self::ARRAY_ATTR][self::PARA_LINK_CLASS];
				if ( !empty($this->data[self::ARRAY_ATTR][self::PARA_GALLERY_LINK_CLASS]) ) {
					if ( !empty($attr['class']) )
						$attr['class'] = $attr['class']." ".$this->data[self::ARRAY_ATTR][self::PARA_GALLERY_LINK_CLASS];
					else
						$attr['class'] = $this->data[self::ARRAY_ATTR][self::PARA_GALLERY_LINK_CLASS];
				}
				if ( !empty($this->data[self::ARRAY_ATTR][self::PARA_GALLERY_ID]) ){
					$attr[$this->data[self::ARRAY_ATTR][self::PARA_GALLERY_LINK_ATTR]] = $this->data[self::ARRAY_ATTR][self::PARA_GALLERY_PREFIX].$this->data[self::ARRAY_ATTR][self::PARA_GALLERY_ID];
				}
				$content = \Html::a($this->data[self::ARRAY_ATTR][self::PARA_LINK_URL], $content, $attr);
			}
			
			// Figure
			if ( $this->data[self::ARRAY_ATTR][self::PARA_FIGURE_CAPTION] !== false && !empty($this->data[self::ARRAY_ATTR][self::PARA_FIGURE_CAPTION]) ) {
				if ( $this->data[self::ARRAY_ATTR][self::PARA_FIGURE_CAPTION] === true && !empty($this->data[self::ARRAY_ATTR][self::PARA_FIGURE_CAPTION_FIELD]) && $this->data[self::ARRAY_ATTR][self::PARA_FIGURE_CAPTION_FIELD] !== false ){
					$content = WebHelper::blockFigure($content, $this->data[self::ARRAY_ATTR][self::PARA_FIGURE_CAPTION_FIELD], $this->data[self::ARRAY_ATTR][self::PARA_FIGURE_CAPTION_TOP], $this->data[self::ARRAY_ATTR][self::PARA_FIGURE_CLASS]);
				} else {
					$content = WebHelper::blockFigure($content, $this->data[self::ARRAY_ATTR][self::PARA_FIGURE_CAPTION], $this->data[self::ARRAY_ATTR][self::PARA_FIGURE_CAPTION_TOP], $this->data[self::ARRAY_ATTR][self::PARA_FIGURE_CLASS]);
				}
			}
		}
		return $content;
	}
	
	protected function saveFile(){
		$this->driver->save( $this->data[self::ARRAY_ATTR][self::PARA_IMG_OUTPUT_ROOT], $this->data[self::ARRAY_ATTR][self::PARA_IMG_QUALITY] );
	}
	
	public function fileExist(){
		if ( $this->data[self::ARRAY_ATTR][self::PARA_OVERWRITE] === true )
			return false;
		if ( file_exists( $this->data[self::ARRAY_ATTR][self::PARA_IMG_OUTPUT_ROOT] ) && \f::modified( $this->data[self::ARRAY_ATTR][self::PARA_IMG_OUTPUT_ROOT] ) >= $this->data[self::ARRAY_ATTR][self::PARA_IMG_SOURCE_MODIFIED] )
			return true;
	
		return false;
	}
	
	protected function settingsIdentifier(){
		return implode('-', array(
				$this->data[self::ARRAY_ATTR][self::PARA_MODE],
				$this->data[self::ARRAY_ATTR][self::PARA_UPSCALE],
				$this->data[self::ARRAY_ATTR][self::PARA_IMG_WIDTH],
				$this->data[self::ARRAY_ATTR][self::PARA_IMG_HEIGHT],
				$this->data[self::ARRAY_ATTR][self::PARA_IMG_CROP_LEFT],
				$this->data[self::ARRAY_ATTR][self::PARA_IMG_CROP_TOP],
				$this->data[self::ARRAY_ATTR][self::PARA_FILTER_BLUR],
				$this->data[self::ARRAY_ATTR][self::PARA_FILTER_BRIGHTNESS],
				$this->data[self::ARRAY_ATTR][self::PARA_FILTER_COLORIZE],
				$this->data[self::ARRAY_ATTR][self::PARA_FILTER_CONTRAST],
				$this->data[self::ARRAY_ATTR][self::PARA_FILTER_EDGES],
				$this->data[self::ARRAY_ATTR][self::PARA_FILTER_EMBOSS],
				$this->data[self::ARRAY_ATTR][self::PARA_FILTER_GRAYSCALE],
				$this->data[self::ARRAY_ATTR][self::PARA_FILTER_INVERT],
				$this->data[self::ARRAY_ATTR][self::PARA_FILTER_OPACITY],
				$this->data[self::ARRAY_ATTR][self::PARA_FILTER_SEPIA],
				$this->data[self::ARRAY_ATTR][self::PARA_FILTER_SKETCH],
				$this->data[self::ARRAY_ATTR][self::PARA_FILTER_SMOOTH],
				$this->data[self::ARRAY_ATTR][self::PARA_FILTER_PIXELATE],
				$this->data[self::ARRAY_ATTR][self::PARA_FILTER_OVERLAY]
		));
	}
	
	public function optimizeOutput(){
		foreach($this->data[self::ARRAY_ATTR] as $key => $value){
			switch($key){
				case self::PARA_FIGURE_CAPTION:
				case self::PARA_IMG_TITLE:
				case self::PARA_LINK_TITLE:
				case self::PARA_IMG_ALT:
					$this->data[self::ARRAY_ATTR][$key] = htmlspecialchars($value, ENT_QUOTES|ENT_HTML5);
					break;
			}
		}
	}
}