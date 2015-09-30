<?php

namespace at\fanninger\kirby\extension\imageext;

use at\fanninger\kirby\extension\webhelper\WebHelper;

class ImageExtObject {

	const DRIVER_GD = "gd";
	const DRIVER_IM = "im";
	
	const MODE_RESIZE = "resize";
	const MODE_CROP = "crop";
	const MODE_NONE = "none";
	
	const PROFILE_NONE = "none";
	
	const TAG_IMAGE = "image";
	const TAG_IMAGEEXT = "imageext";
	const TAG_PICTURE = "picture";
	const TAG_IMAGE_GALLERY = "image_gallery";
	const TAG_IMAGEEXT_GALLERY = "imageext_gallery";
	const TAG_SRCSET = "srcset";
	
	const TYPE_GALLERY = "gallery";
	const TYPE_IMAGE = "image";
	
	const ARRAY_ATTR = "attr";
	const ARRAY_SRCSET = "srcset";
	const ARRAY_TYPE = "type";
	const ARRAY_IMAGES = "images";
	const ARRAY_TAG = "tag";
	
	const PARA_DEBUG = "debug";
	const PARA_DRIVER = "driver";
	const PARA_SNIPPET_IMAGE = "snippet_image";
	const PARA_SNIPPET_GALLERY = "snippet_gallery";
	const PARA_PAGE_URL = "page_url";
	const PARA_PAGE_ROOT = "page_root";
	const PARA_PROFILE = "profile";
	const PARA_OVERWRITE = "overwrite";
	const PARA_MODE = "mode";
	const PARA_UPSCALE = "upscale";
	const PARA_FIGURE_CLASS = "figure_class";
	const PARA_FIGURE_CAPTION = "figure_caption";
	const PARA_FIGURE_CAPTION_TOP = "figure_caption_top";
	const PARA_FIGURE_CAPTION_FIELD = "figure_caption_field";
	const PARA_LINK_CLASS = "link_class";
	const PARA_LINK_TARGET = "link_target";
	const PARA_LINK_REL = "link_rel";
	const PARA_LINK_TITLE = "link_title";
	const PARA_LINK_URL = "link_url";
	const PARA_IMG_SOURCE = "image_source";
	const PARA_IMG_SOURCE_MODIFIED = "image_source_modified";
	const PARA_IMG_CLASS = "image_class";
	const PARA_IMG_ALT = "image_alt";
	const PARA_IMG_TITLE = "image_title";
	const PARA_IMG_WIDTH = "image_width";
	const PARA_IMG_HEIGHT = "image_height";
	const PARA_IMG_QUALITY = "image_quality";
	const PARA_IMG_MIMETYPE = "image_mimetype";
	const PARA_IMG_MEDIAQUERY = "image_mediaquery";
	const PARA_IMG_CROP_LEFT = "image_crop_left";
	const PARA_IMG_CROP_TOP = "image_crop_top";
	const PARA_IMG_EXTENSION = "image_extension";
	const PARA_IMG_OUTPUT_URL = "image_output_url";
	const PARA_IMG_OUTPUT_ROOT = "image_output_root";
	const PARA_IMG_OUTPUT_FILENAME = "image_output_filename";
	const PARA_GALLERY_CONTENT = "gallery_content";
	const PARA_GALLERY_CLASS = "gallery_class";
	const PARA_GALLERY_PREFIX = "gallery_prefix";
	const PARA_GALLERY_ID = "gallery_id";
	const PARA_GALLERY_LINK_ATTR = "gallery_img_attr";
	const PARA_GALLERY_LINK_CLASS = "gallery_img_class";
	const PARA_FILTER_BLUR = "filter_blur";
	const PARA_FILTER_GRAYSCALE = "filter_grayscale";
	const PARA_FILTER_BRIGHTNESS = "filter_brightness";
	const PARA_FILTER_CONTRAST = "filter_contrast";
	const PARA_FILTER_COLORIZE = "filter_colorize";
	const PARA_FILTER_EDGES = "filter_edges";
	const PARA_FILTER_EMBOSS = "filter_emboss";
	const PARA_FILTER_INVERT = "filter_invert";
	const PARA_FILTER_OPACITY = "filter_opacity";
	const PARA_FILTER_SEPIA = "filter_sepia";
	const PARA_FILTER_SKETCH = "filter_sketch";
	const PARA_FILTER_SMOOTH = "filter_smooth";
	const PARA_FILTER_PIXELATE = "filter_pixelate";
	const PARA_FILTER_OVERLAY = "filter_overlay";
	
	protected  $para_mapping = array(
		ImageExt::ATTR_DRIVER => self::PARA_DRIVER,
		ImageExt::ATTR_PROFILE => self::PARA_PROFILE,
		ImageExt::ATTR_FIGURE_TEXT => self::PARA_FIGURE_CAPTION,
		ImageExt::ATTR_FIGURE_CLASS => self::PARA_FIGURE_CLASS,
		ImageExt::ATTR_FIGURE_CAPTION_TOP => self::PARA_FIGURE_CAPTION_TOP,
		ImageExt::ATTR_FIGURE_CAPTION_FIELD => self::PARA_FIGURE_CAPTION_FIELD,
		ImageExt::ATTR_LINK_CLASS => self::PARA_LINK_CLASS,
		ImageExt::ATTR_LINK_TARGET => self::PARA_LINK_TARGET,
		ImageExt::ATTR_LINK_REL => self::PARA_LINK_REL,
		ImageExt::ATTR_LINK_TITLE => self::PARA_LINK_TITLE,
		ImageExt::ATTR_LINK_URL => self::PARA_LINK_URL,
		ImageExt::ATTR_IMG_SRC => self::PARA_IMG_SOURCE,
		ImageExt::ATTR_IMG_CLASS => self::PARA_IMG_CLASS,
		ImageExt::ATTR_IMG_ALT => self::PARA_IMG_ALT,
		ImageExt::ATTR_IMG_TITLE => self::PARA_IMG_TITLE,
		ImageExt::ATTR_IMG_WIDTH => self::PARA_IMG_WIDTH,
		ImageExt::ATTR_IMG_HEIGHT => self::PARA_IMG_HEIGHT,
		ImageExt::ATTR_IMG_CROP_LEFT => self::PARA_IMG_CROP_LEFT,
		ImageExt::ATTR_IMG_CROP_TOP => self::PARA_IMG_CROP_TOP,
		ImageExt::ATTR_IMG_QUALITY => self::PARA_IMG_QUALITY,
		ImageExt::ATTR_IMG_MEDIAQUERY => self::PARA_IMG_MEDIAQUERY,
		ImageExt::ATTR_IMG_MIMETYPE => self::PARA_IMG_MIMETYPE,
		ImageExt::ATTR_GALLERY_ID => self::PARA_GALLERY_ID,
		ImageExt::ATTR_MODE => self::PARA_MODE,
		ImageExt::ATTR_UPSCALE => self::PARA_UPSCALE,
		ImageExt::ATTR_OVERWRITE => self::PARA_OVERWRITE,
		ImageExt::ATTR_FILTER_BLUR => self::PARA_FILTER_BLUR,
		ImageExt::ATTR_FILTER_GRAYSCALE => self::PARA_FILTER_GRAYSCALE,
		ImageExt::ATTR_FILTER_BRIGHTNESS => self::PARA_FILTER_BRIGHTNESS,
		ImageExt::ATTR_FILTER_CONTRAST => self::PARA_FILTER_CONTRAST,
		ImageExt::ATTR_FILTER_COLORIZE => self::PARA_FILTER_COLORIZE,
		ImageExt::ATTR_FILTER_EDGES => self::PARA_FILTER_EDGES,
		ImageExt::ATTR_FILTER_EMBOSS => self::PARA_FILTER_EMBOSS,
		ImageExt::ATTR_FILTER_INVERT => self::PARA_FILTER_INVERT,
		ImageExt::ATTR_FILTER_OPACITY => self::PARA_FILTER_OPACITY,
		ImageExt::ATTR_FILTER_SEPIA => self::PARA_FILTER_SEPIA,
		ImageExt::ATTR_FILTER_SKETCH => self::PARA_FILTER_SKETCH,
		ImageExt::ATTR_FILTER_SMOOTH => self::PARA_FILTER_SMOOTH,
		ImageExt::ATTR_FILTER_PIXELATE => self::PARA_FILTER_PIXELATE,
		ImageExt::ATTR_FILTER_OVERLAY => self::PARA_FILTER_OVERLAY,
		ImageExt::ATTR_SUPPORT_IMG_CLASS => self::PARA_IMG_CLASS,
		ImageExt::ATTR_SUPPORT_IMG_ALT => self::PARA_IMG_ALT,
		ImageExt::ATTR_SUPPORT_IMG_TITLE => self::PARA_IMG_TITLE,
		ImageExt::ATTR_SUPPORT_IMG_WIDTH => self::PARA_IMG_WIDTH,
		ImageExt::ATTR_SUPPORT_IMG_HEIGHT => self::PARA_IMG_HEIGHT,
		ImageExt::ATTR_SUPPORT_IMG_CROP_LEFT => self::PARA_IMG_CROP_LEFT,
		ImageExt::ATTR_SUPPORT_IMG_CROP_TOP => self::PARA_IMG_CROP_TOP,
		ImageExt::ATTR_SUPPORT_IMG_QUALITY => self::PARA_IMG_QUALITY,
		ImageExt::ATTR_SUPPORT_IMG_MEDIAQUERY => self::PARA_IMG_MEDIAQUERY,
		ImageExt::ATTR_SUPPORT_IMG_MIMETYPE => self::PARA_IMG_MIMETYPE,
		ImageExt::ATTR_SUPPORT_FIGURE_TEXT => self::PARA_FIGURE_CAPTION,
		ImageExt::ATTR_SUPPORT_FIGURE_CLASS => self::PARA_FIGURE_CLASS,
		ImageExt::ATTR_SUPPORT_FILTER_BLUR => self::PARA_FILTER_BLUR,
		ImageExt::ATTR_SUPPORT_LINK_CLASS => self::PARA_LINK_CLASS,
		ImageExt::ATTR_SUPPORT_LINK_URL => self::PARA_LINK_URL,
		ImageExt::ATTR_SUPPORT_LINK_TARGET => self::PARA_LINK_TARGET,
		ImageExt::ATTR_SUPPORT_FILTER_GRAYSCALE => self::PARA_FILTER_GRAYSCALE,
		ImageExt::ATTR_SUPPORT_FILTER_BRIGHTNESS => self::PARA_FILTER_BRIGHTNESS,
		ImageExt::ATTR_SUPPORT_FILTER_CONTRAST => self::PARA_FILTER_CONTRAST,
		ImageExt::ATTR_SUPPORT_FILTER_COLORIZE => self::PARA_FILTER_COLORIZE,
		ImageExt::ATTR_SUPPORT_FILTER_EDGES => self::PARA_FILTER_EDGES,
		ImageExt::ATTR_SUPPORT_FILTER_EMBOSS => self::PARA_FILTER_EMBOSS,
		ImageExt::ATTR_SUPPORT_FILTER_INVERT => self::PARA_FILTER_INVERT,
		ImageExt::ATTR_SUPPORT_FILTER_OPACITY => self::PARA_FILTER_OPACITY,
		ImageExt::ATTR_SUPPORT_FILTER_SEPIA => self::PARA_FILTER_SEPIA,
		ImageExt::ATTR_SUPPORT_FILTER_SKETCH => self::PARA_FILTER_SKETCH,
		ImageExt::ATTR_SUPPORT_FILTER_SMOOTH => self::PARA_FILTER_SMOOTH,
		ImageExt::ATTR_SUPPORT_FILTER_PIXELATE => self::PARA_FILTER_PIXELATE,
		ImageExt::ATTR_SUPPORT_FILTER_OVERLAY => self::PARA_FILTER_OVERLAY,
		ImageExt::ATTR_DEPRECATED_MODE => self::PARA_MODE,
		ImageExt::ATTR_DEPRECATED_IMG_TEXT => self::PARA_IMG_TITLE,
		ImageExt::ATTR_DEPRECATED_LINK_TARGET => self::PARA_LINK_TARGET
	);
	
	protected $imageExt = null;
	protected $data = array();
	
	public function __construct( ImageExt $imageExt, $data = array() ) {
		$this->imageExt = $imageExt;
		$this->data = $data;
	}
	
	/**
	 * Generate a data array from a content block
	 * 
	 * @param array $block
	 * @param array $attr_template
	 */
	public function parse($tag, array $block, array $attr_template = null){
		switch ($tag) {
			case self::TAG_IMAGE:
			case self::TAG_IMAGEEXT:
				$this->data[self::ARRAY_TAG] = 'img';
				break;
			case self::TAG_SRCSET:
				$this->data[self::ARRAY_TAG] = 'source';
				break;
		}
		
		//Default attributes
		if ( is_array($block) && array_key_exists(WebHelper::BLOCK_ARRAY_VALUE_ATTRIBUTES, $block) )
			$this->data[self::ARRAY_ATTR] = $this->convertAndMergeAttributes( $tag, $block[WebHelper::BLOCK_ARRAY_VALUE_ATTRIBUTES], $attr_template );
		else 
			$this->data[self::ARRAY_ATTR] = $this->convertAndMergeAttributes( $tag, null, $attr_template );
		
		// Get image data and generate thumb file name
	}
	
  protected function convertAndMergeAttributes($tag, array $attr = null, array $attr_template = null){
		$attr_result = array();
		
		if ( array_key_exists( self::ARRAY_ATTR, $this->data) )
			$attr_result = array_merge($this->imageExt->getDefaults(), $this->data[self::ARRAY_ATTR]);
		else
			$attr_result = $this->imageExt->getDefaults();
		
		if ( is_array($attr_template) ) {
			foreach ( $attr_template as $key => $value ) {
				if ( array_key_exists($key, $attr_result) )
					$attr_result[$key] = $value;
			}
		}
		
		// Profile attributes
		$profiles = $this->imageExt->getProfiles();
		if ( is_array( $attr ) && array_key_exists( self::PARA_PROFILE, $attr) === true ) {
			$profile = $attr[self::PARA_PROFILE];
			if ( is_array( $profiles ) && array_key_exists($profile, $profiles) ){
				foreach ( $profiles[ $attr[self::PARA_PROFILE] ] as $key => $value ) {
					if ( array_key_exists($key, $this->para_mapping) )
						$key = $this->para_mapping[$key];
					
					if ( array_key_exists($key, $attr_result) )
						$attr_result[$key] = $this->checkValue( $key, $value );
				}
			}
		}

		// Set the other attributes
		if ( is_array($attr) ) {
			foreach($attr as $key => $value){
				if ( array_key_exists($key, $this->para_mapping) )
					$key = $this->para_mapping[$key];
				
				if ( array_key_exists($key, $attr_result) )
					$attr_result[$key] = $value;
			}
			
			if ( array_key_exists($tag, $attr) ) {
				$attr_result[self::PARA_IMG_SOURCE] = $attr[$tag];
			}
		}
		
		// Check values
		foreach($attr_result as $key => $value){ 
			$attr_result[$key] = $this->checkValue( $key, $value, $attr_result);
		}
		
		// Convert attributes to internal format
		$attr_result[self::PARA_PAGE_URL] = $this->imageExt->getPage()->url();
		$attr_result[self::PARA_PAGE_ROOT] = $this->imageExt->getPage()->root();
		
		return $attr_result;
	}
	
	protected function checkValue($key, $value, $attr_result=null){
		switch ($key){
			case self::PARA_FIGURE_CAPTION:
			case self::PARA_IMG_TITLE:
			case self::PARA_LINK_TITLE:
			case self::PARA_IMG_ALT:
				if ( is_bool( $value ) )
					$value = $value;
				elseif ( is_string( $value ) && ( $value === "true" || $value === "false" ) )
					$value = ($value === "true")? true : false;
				elseif ( is_string( $value ) )
					$value = $value;
				else
					$value = false;
				break;
			case self::PARA_FILTER_GRAYSCALE:
			case self::PARA_FILTER_OPACITY:
				if ( is_int($value) && $value >= 0 && $value <= 100 )
					$value = $value;
				elseif ( is_numeric($value) && intval($value) >= 0 && intval($value) <= 100 )
					$value = intval($value);
				elseif ( $value === true || ( is_string($value) && strtolower($value) === "true" ) )
					$value = 100;
				else
					$value = $this->imageExt->getDefaults()[$key];
				break;
			case self::PARA_FILTER_COLORIZE:
				break;
			case self::PARA_FILTER_BLUR:
				if ( is_bool($value) )
				  $value = ($value)? 1 : false;
				elseif ( is_numeric($value) )
				  $value = (intval($value) > 0)? intval($value) : false;
				elseif ( is_string($value) )
					$value = (strtolower($value) === "true")? 1 : false;
				elseif ( $value === true || $value === false )
					$value = ($value === true)? 1 : $value;
				else
					$value = $this->imageExt->getDefaults()[$key];
				break;
			case self::PARA_UPSCALE:
			case self::PARA_FILTER_EDGES:
			case self::PARA_FILTER_EMBOSS:
			case self::PARA_FILTER_INVERT:
			case self::PARA_FILTER_SEPIA:
			case self::PARA_FILTER_SKETCH:
				if ( is_bool($value) )
					return $value;
				elseif ( is_string($value) )
					$value = (strtolower($value) === "true")? true: false;
				else
					$value = $this->imageExt->getDefaults()[$key];
				break;
			case self::PARA_FILTER_CONTRAST:
				if ( is_int($value) && $value >= -100 && $value <= 100 )
					$value = $value;
				elseif ( is_numeric($value) && intval($value) >= -100 && intval($value) <= 100 )
					$value = intval($value);
				else
					$value = $this->imageExt->getDefaults()[$key];
				break;
			case self::PARA_FILTER_BRIGHTNESS:
				if ( is_int($value) && $value >= -255 && $value <= 255 )
					$value = $value;
				elseif ( is_numeric($value) && intval($value) >= -255 && intval($value) <= 255 )
					$value = intval($value);
				else
					$value = $this->imageExt->getDefaults()[$key];
				break;
			case self::PARA_FILTER_SMOOTH:
				if ( is_int($value) && $value >= -10 && $value <= 10 )
					$value = $value;
				elseif ( is_numeric($value) && intval($value) >= -10 && intval($value) <= 10 )
					$value = intval($value);
				else
					$value = $this->imageExt->getDefaults()[$key];
				break;
			case self::PARA_FILTER_PIXELATE:
			case self::PARA_IMG_WIDTH:
			case self::PARA_IMG_HEIGHT:
				if ( is_int($value) && $value > 0 )
					$value = $value;
				elseif ( is_numeric($value) && intval($value) > 0 )
					$value = intval($value);
				elseif ( $value === true || $value === false )
					$value = $value;
				else
					$value = $this->imageExt->getDefaults()[$key];
				break;
			case self::PARA_IMG_QUALITY:
				if ( is_int($value) && $value >= 0 && $value <= 100 )
					$value = $value;
				elseif ( is_numeric($value) && intval($value) >= 0 && intval($value) <= 100 )
					$value = intval($value);
				else
					$value = $this->imageExt->getDefaults()[$key];
				break;
			case self::PARA_LINK_URL:
				// Check if it a file of the current page
				if ( strlen($value) > 0 ) {
					if ( $this->imageExt->getPage()->file($value) )
						$value = $this->imageExt->getPage()->file($value)->url();
					$value = \Url($value);
				}
				break;
			case self::PARA_FILTER_OVERLAY:
				break;
		}
		return $value;
	}
	
	public function optimizeOutput(){
		
	}
	
	/**
	 * Generates the final HTML code
	 * 
	 * @return string
	 */
	public function toHTML(){
		return "";
	}
	
	public function toArray(){
		return $this->data;
	}
	
	public function getDebug(){
		$content = print_r($this->data, true);
		$content = WebHelper::convert($content);
		$content = \Html::tag("code", $content);
		return \Html::tag("pre", $content);
	}
	
	/**
	 * Return the array structure as string
	 * 
	 * @return string
	 */
	public function toString(){
		ob_start();
		var_dump($this->data);
		$output = ob_get_contents();
		ob_end_clean();
		
		return $output;
	}
	
	public function __toString() {
		return $this->toString();
	}
}
