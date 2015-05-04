<?php

namespace at\fanninger\kirby\extension\imageext;

use at\fanninger\kirby\extension\webhelper\WebHelper;

require_once 'kirbycms-extension-image-lib-image.php';
require_once 'kirbycms-extension-image-lib-gallery.php';

class ImageExt {
	
	const DRIVER_GD = "gd";
	const DRIVER_IM = "im";
	
	const MODE_RESIZE = "resize";
	const MODE_CROP = "crop";
	const MODE_NONE = "none";
	
	const PROFILE_NONE = "none";
	
	const CONFIG_PARAM_PREFIX = "kirby.extension.imageext";
	const CONFIG_PARAM_DEFAULT_DRIVER = "kirby.extension.imageext.driver";
	const CONFIG_PARAM_SUPPORT_TAG_IMAGE = "kirby.extension.imageext.support.tag.image";
	const CONFIG_PARAM_SUPPORT_TAG_GALLERY = "kirby.extension.imageext.support.tag.image_gallery";
	const CONFIG_PARAM_PROFILES = "kirby.extension.imageext.profiles";
	const CONFIG_PARAM_DEFAULT_PROFILE = "kirby.extension.imageext.default_profile";
	const CONFIG_PARAM_WATERMARK = "kirby.extension.imageext.watermark";
	const CONFIG_PARAM_DEFAULT_WIDTH = "kirby.extension.imageext.width";
	const CONFIG_PARAM_DEFAULT_HEIGHT = "kirby.extension.imageext.height";
	const CONFIG_PARAM_DEFAULT_QUALITY = "kirby.extension.imageext.quality";
	const CONFIG_PARAM_DEFAULT_CAPTION_FIELD = "kirby.extension.imageext.caption_field";
	const CONFIG_PARAM_DEFAULT_CAPTION_TOP = "kirby.extension.imageext.caption_top";
	const CONFIG_PARAM_DEFAULT_CLASS_LINK = "kirby.extension.imageext.linkclass";
	const CONFIG_PARAM_DEFAULT_CLASS_IMG = "kirby.extension.imageext.imgclass";
	const CONFIG_PARAM_DEFAULT_CLASS_FIGURE = "kirby.extension.imageext.figureclass";
	const CONFIG_PARAM_DEFAULT_GALLERY_CLASS = "kirby.extension.imageext.gallery.class";
	const CONFIG_PARAM_DEFAULT_GALLERY_PREFIX = "kirby.extension.imageext.gallery.prefix";
	const CONFIG_PARAM_DEFAULT_GALLERY_LINK_CLASS = "kirby.extension.imageext.gallery.link.class";
	const CONFIG_PARAM_DEFAULT_GALLERY_LINK_ATTR = "kirby.extension.imageext.gallery.link.attr";
	const CONFIG_PARAM_DEFAULT_TARGET = "kirby.extension.imageext.target";
	
	const ATTR_DRIVER = "driver";
	const ATTR_PROFILE = "profile";
	const ATTR_FIGURE_TEXT = "caption_text";
	const ATTR_FIGURE_CLASS = "caption_class";
	const ATTR_FIGURE_CAPTION_TOP = "caption_top";
	const ATTR_FIGURE_CAPTION_FIELD = "caption_field";
	const ATTR_LINK_CLASS = "link_class";
	const ATTR_LINK_TARGET = "link_target";
	const ATTR_LINK_REL = "link_rel";
	const ATTR_LINK_TITLE = "link_title";
	const ATTR_LINK_URL = "link_url";
	const ATTR_IMG_SRC = "image_source";
	const ATTR_IMG_CLASS = "image_class";
	const ATTR_IMG_ALT = "image_alt";
	const ATTR_IMG_TITLE = "image_title";
	const ATTR_IMG_WIDTH = "image_width";
	const ATTR_IMG_HEIGHT = "image_height";
	const ATTR_IMG_CROP_LEFT = "image_left";
	const ATTR_IMG_CROP_TOP = "image_top";
	const ATTR_IMG_QUALITY = "image_quality";
	const ATTR_GALLERY_ID = "gallery";
	const ATTR_MODE = "mode";
	const ATTR_UPSCALE = "upscale";
	const ATTR_OVERWRITE = "overwrite";
	const ATTR_FILTER_BLUR = "filter_blur";
	const ATTR_FILTER_GRAYSCALE = "filter_grayscale";
	const ATTR_FILTER_BRIGHTNESS = "filter_brightness";
	const ATTR_FILTER_CONTRAST = "filter_contrast";
	const ATTR_FILTER_COLORIZE = "filter_colorize";
	const ATTR_FILTER_EDGES = "filter_edges";
	const ATTR_FILTER_EMBOSS = "filter_emboss";
	const ATTR_FILTER_INVERT = "filter_invert";
	const ATTR_FILTER_OPACITY = "filter_opacity";
	const ATTR_FILTER_SEPIA = "filter_sepia";
	const ATTR_FILTER_SKETCH = "filter_sketch";
	const ATTR_FILTER_SMOOTH = "filter_smooth";
	const ATTR_FILTER_PIXELATE = "filter_pixelate";
	const ATTR_FILTER_OVERLAY = "filter_overlay";
	const ATTR_SUPPORT_IMG_CLASS = "imgclass";
	const ATTR_SUPPORT_IMG_ALT = "alt";
	const ATTR_SUPPORT_IMG_TITLE = "title";
	const ATTR_SUPPORT_IMG_WIDTH = "width";
	const ATTR_SUPPORT_IMG_HEIGHT = "height";
	const ATTR_SUPPORT_IMG_CROP_LEFT = "left";
	const ATTR_SUPPORT_IMG_CROP_TOP = "top";
	const ATTR_SUPPORT_IMG_QUALITY = "quality";
	const ATTR_SUPPORT_FIGURE_TEXT = "caption";
	const ATTR_SUPPORT_FIGURE_CLASS = "class";
	const ATTR_SUPPORT_FILTER_BLUR = "blur";
	const ATTR_SUPPORT_LINK_CLASS = "linkclass";
	const ATTR_SUPPORT_LINK_URL = "link";
	const ATTR_SUPPORT_LINK_TARGET = "target";
	const ATTR_SUPPORT_FILTER_GRAYSCALE = "grayscale";
	const ATTR_SUPPORT_FILTER_BRIGHTNESS = "brightness";
	const ATTR_SUPPORT_FILTER_CONTRAST = "contrast";
	const ATTR_SUPPORT_FILTER_COLORIZE = "colorize";
	const ATTR_SUPPORT_FILTER_EDGES = "edges";
	const ATTR_SUPPORT_FILTER_EMBOSS = "emboss";
	const ATTR_SUPPORT_FILTER_INVERT = "invert";
	const ATTR_SUPPORT_FILTER_OPACITY = "opacity";
	const ATTR_SUPPORT_FILTER_SEPIA = "sepia";
	const ATTR_SUPPORT_FILTER_SKETCH = "sketch";
	const ATTR_SUPPORT_FILTER_SMOOTH = "smooth";
	const ATTR_SUPPORT_FILTER_PIXELATE = "pixelate";	
	const ATTR_SUPPORT_FILTER_OVERLAY = "overlay";
	const ATTR_DEPRECATED_MODE = "resize";
	const ATTR_DEPRECATED_IMG_TEXT = "text";
	const ATTR_DEPRECATED_LINK_TARGET = "popup";
	
	const PARA_DRIVER = "driver";
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
	const PARA_IMG_CLASS = "image_class";
	const PARA_IMG_ALT = "image_alt";
	const PARA_IMG_TITLE = "image_title";
	const PARA_IMG_WIDTH = "image_width";
	const PARA_IMG_HEIGHT = "image_height";
	const PARA_IMG_QUALITY = "image_quality";
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

	protected  $para_mapping = [
			self::ATTR_DRIVER => self::PARA_DRIVER,
			self::ATTR_PROFILE => self::PARA_PROFILE,
			self::ATTR_FIGURE_TEXT => self::PARA_FIGURE_CAPTION,
			self::ATTR_FIGURE_CLASS => self::PARA_FIGURE_CLASS,
			self::ATTR_FIGURE_CAPTION_TOP => self::PARA_FIGURE_CAPTION_TOP,
			self::ATTR_FIGURE_CAPTION_FIELD => self::PARA_FIGURE_CAPTION_FIELD,
			self::ATTR_LINK_CLASS => self::PARA_LINK_CLASS,
			self::ATTR_LINK_TARGET => self::PARA_LINK_TARGET,
			self::ATTR_LINK_REL => self::PARA_LINK_REL,
			self::ATTR_LINK_TITLE => self::PARA_LINK_TITLE,
			self::ATTR_LINK_URL => self::PARA_LINK_URL,
			self::ATTR_IMG_SRC => self::PARA_IMG_SOURCE,
			self::ATTR_IMG_CLASS => self::PARA_IMG_CLASS,
			self::ATTR_IMG_ALT => self::PARA_IMG_ALT,
			self::ATTR_IMG_TITLE => self::PARA_IMG_TITLE,
			self::ATTR_IMG_WIDTH => self::PARA_IMG_WIDTH,
			self::ATTR_IMG_HEIGHT => self::PARA_IMG_HEIGHT,
			self::ATTR_IMG_CROP_LEFT => self::PARA_IMG_CROP_LEFT,
			self::ATTR_IMG_CROP_TOP => self::PARA_IMG_CROP_TOP,
			self::ATTR_IMG_QUALITY => self::PARA_IMG_QUALITY,
			self::ATTR_GALLERY_ID => self::PARA_GALLERY_ID,
			self::ATTR_MODE => self::PARA_MODE,
			self::ATTR_UPSCALE => self::PARA_UPSCALE,
			self::ATTR_OVERWRITE => self::PARA_OVERWRITE,
			self::ATTR_FILTER_BLUR => self::PARA_FILTER_BLUR,
			self::ATTR_FILTER_GRAYSCALE => self::PARA_FILTER_GRAYSCALE,
			self::ATTR_FILTER_BRIGHTNESS => self::PARA_FILTER_BRIGHTNESS,
			self::ATTR_FILTER_CONTRAST => self::PARA_FILTER_CONTRAST,
			self::ATTR_FILTER_COLORIZE => self::PARA_FILTER_COLORIZE,
			self::ATTR_FILTER_EDGES => self::PARA_FILTER_EDGES,
			self::ATTR_FILTER_EMBOSS => self::PARA_FILTER_EMBOSS,
			self::ATTR_FILTER_INVERT => self::PARA_FILTER_INVERT,
			self::ATTR_FILTER_OPACITY => self::PARA_FILTER_OPACITY,
			self::ATTR_FILTER_SEPIA => self::PARA_FILTER_SEPIA,
			self::ATTR_FILTER_SKETCH => self::PARA_FILTER_SKETCH,
			self::ATTR_FILTER_SMOOTH => self::PARA_FILTER_SMOOTH,
			self::ATTR_FILTER_PIXELATE => self::PARA_FILTER_PIXELATE,
			self::ATTR_FILTER_OVERLAY => self::PARA_FILTER_OVERLAY,
			self::ATTR_SUPPORT_IMG_CLASS => self::PARA_IMG_CLASS,
			self::ATTR_SUPPORT_IMG_ALT => self::PARA_IMG_ALT,
			self::ATTR_SUPPORT_IMG_TITLE => self::PARA_IMG_TITLE,
			self::ATTR_SUPPORT_IMG_WIDTH => self::PARA_IMG_WIDTH,
			self::ATTR_SUPPORT_IMG_HEIGHT => self::PARA_IMG_HEIGHT,
			self::ATTR_SUPPORT_IMG_CROP_LEFT => self::PARA_IMG_CROP_LEFT,
			self::ATTR_SUPPORT_IMG_CROP_TOP => self::PARA_IMG_CROP_TOP,
			self::ATTR_SUPPORT_IMG_QUALITY => self::PARA_IMG_QUALITY,
			self::ATTR_SUPPORT_FIGURE_TEXT => self::PARA_FIGURE_CAPTION,
			self::ATTR_SUPPORT_FIGURE_CLASS => self::PARA_FIGURE_CLASS,
			self::ATTR_SUPPORT_FILTER_BLUR => self::PARA_FILTER_BLUR,
			self::ATTR_SUPPORT_LINK_CLASS => self::PARA_LINK_CLASS,
			self::ATTR_SUPPORT_LINK_URL => self::PARA_LINK_URL,
			self::ATTR_SUPPORT_LINK_TARGET => self::PARA_LINK_TARGET,
			self::ATTR_SUPPORT_FILTER_GRAYSCALE => self::PARA_FILTER_GRAYSCALE,
			self::ATTR_SUPPORT_FILTER_BRIGHTNESS => self::PARA_FILTER_BRIGHTNESS,
			self::ATTR_SUPPORT_FILTER_CONTRAST => self::PARA_FILTER_CONTRAST,
			self::ATTR_SUPPORT_FILTER_COLORIZE => self::PARA_FILTER_COLORIZE,
			self::ATTR_SUPPORT_FILTER_EDGES => self::PARA_FILTER_EDGES,
			self::ATTR_SUPPORT_FILTER_EMBOSS => self::PARA_FILTER_EMBOSS,
			self::ATTR_SUPPORT_FILTER_INVERT => self::PARA_FILTER_INVERT,
			self::ATTR_SUPPORT_FILTER_OPACITY => self::PARA_FILTER_OPACITY,
			self::ATTR_SUPPORT_FILTER_SEPIA => self::PARA_FILTER_SEPIA,
			self::ATTR_SUPPORT_FILTER_SKETCH => self::PARA_FILTER_SKETCH,
			self::ATTR_SUPPORT_FILTER_SMOOTH => self::PARA_FILTER_SMOOTH,
			self::ATTR_SUPPORT_FILTER_PIXELATE => self::PARA_FILTER_PIXELATE,
			self::ATTR_SUPPORT_FILTER_OVERLAY => self::PARA_FILTER_OVERLAY,
			self::ATTR_DEPRECATED_MODE => self::PARA_MODE,
			self::ATTR_DEPRECATED_IMG_TEXT => self::PARA_IMG_TITLE,
			self::ATTR_DEPRECATED_LINK_TARGET => self::PARA_LINK_TARGET
	];
	
	protected $default = array();
	protected $profiles = array();
	protected $page = null;
	
	public function __construct($page){
		$this->page = $page;
		$this->loadDefaults();
		$this->loadProfiles();
	}
	
	protected function loadDefaults(){
		$this->default[self::PARA_DRIVER] = kirby()->option(self::CONFIG_PARAM_DEFAULT_DRIVER, self::DRIVER_GD);
		$this->default[self::PARA_PROFILE] = kirby()->option(self::CONFIG_PARAM_DEFAULT_PROFILE, self::PROFILE_NONE);
		$this->default[self::PARA_FIGURE_CLASS] = kirby()->option(self::CONFIG_PARAM_DEFAULT_CLASS_FIGURE, "image-figure");
		$this->default[self::PARA_FIGURE_CAPTION] = false;
		$this->default[self::PARA_FIGURE_CAPTION_TOP] = kirby()->option(self::CONFIG_PARAM_DEFAULT_CAPTION_TOP, false);
		$this->default[self::PARA_FIGURE_CAPTION_FIELD] = kirby()->option(self::CONFIG_PARAM_DEFAULT_CAPTION_FIELD, false);
		$this->default[self::PARA_LINK_CLASS] = kirby()->option(self::CONFIG_PARAM_DEFAULT_CLASS_LINK, "image-link");
		$this->default[self::PARA_LINK_TARGET] = kirby()->option(self::CONFIG_PARAM_DEFAULT_TARGET, false);
		$this->default[self::PARA_LINK_REL] = false;
		$this->default[self::PARA_LINK_TITLE] = false;
		$this->default[self::PARA_LINK_URL] = false;
		$this->default[self::PARA_IMG_SOURCE] = false;
		$this->default[self::PARA_IMG_CLASS] = kirby()->option(self::CONFIG_PARAM_DEFAULT_CLASS_IMG, "image");
		$this->default[self::PARA_IMG_ALT] = false;
		$this->default[self::PARA_IMG_TITLE] = false;
		$this->default[self::PARA_IMG_WIDTH] = kirby()->option(self::CONFIG_PARAM_DEFAULT_WIDTH, false);
		$this->default[self::PARA_IMG_HEIGHT] = kirby()->option(self::CONFIG_PARAM_DEFAULT_HEIGHT, false);
		$this->default[self::PARA_IMG_QUALITY] = 90;
		$this->default[self::PARA_IMG_CROP_LEFT] = false;
		$this->default[self::PARA_IMG_CROP_TOP] = false;
		$this->default[self::PARA_IMG_EXTENSION] = false;
		$this->default[self::PARA_IMG_OUTPUT_URL] = kirby()->urls()->thumbs();
		$this->default[self::PARA_IMG_OUTPUT_ROOT] = kirby()->roots()->thumbs();
		$this->default[self::PARA_IMG_OUTPUT_FILENAME] = "{safeName}-{hash}.{extension}";
		$this->default[self::PARA_GALLERY_CONTENT] = "";
		$this->default[self::PARA_GALLERY_CLASS] = kirby()->option(self::CONFIG_PARAM_DEFAULT_GALLERY_CLASS, "image-gallery");
		$this->default[self::PARA_GALLERY_PREFIX] = kirby()->option(self::CONFIG_PARAM_DEFAULT_GALLERY_PREFIX, "gallery-");
		$this->default[self::PARA_GALLERY_ID] = false;
		$this->default[self::PARA_GALLERY_LINK_CLASS] = kirby()->option(self::CONFIG_PARAM_DEFAULT_GALLERY_LINK_CLASS, "fancybox");
		$this->default[self::PARA_GALLERY_LINK_ATTR] = kirby()->option(self::CONFIG_PARAM_DEFAULT_GALLERY_LINK_ATTR, "rel");
		$this->default[self::PARA_MODE] = self::MODE_NONE;
		$this->default[self::PARA_UPSCALE] = false;
		$this->default[self::PARA_OVERWRITE] = false;
		$this->default[self::PARA_FILTER_BLUR] = false;
		$this->default[self::PARA_FILTER_GRAYSCALE] = false;
		$this->default[self::PARA_FILTER_BRIGHTNESS] = false;
		$this->default[self::PARA_FILTER_CONTRAST] = false;
		$this->default[self::PARA_FILTER_COLORIZE] = false;
		$this->default[self::PARA_FILTER_EDGES] = false;
		$this->default[self::PARA_FILTER_EMBOSS] = false;
		$this->default[self::PARA_FILTER_INVERT] = false;
		$this->default[self::PARA_FILTER_OPACITY] = false;
		$this->default[self::PARA_FILTER_SEPIA] = false;
		$this->default[self::PARA_FILTER_SKETCH] = false;
		$this->default[self::PARA_FILTER_SMOOTH] = false;
		$this->default[self::PARA_FILTER_PIXELATE] = false;
		$this->default[self::PARA_FILTER_OVERLAY] = false;
	}
	
	protected function loadProfiles(){
		$this->profiles = kirby()->options(self::CONFIG_PARAM_PROFILES, array());
		if ( array_key_exists(self::CONFIG_PARAM_PROFILES, $this->profiles) ) {
			$this->profiles = $this->profiles[self::CONFIG_PARAM_PROFILES];
		}
	}

	public function execute($value, $attr_template = null){
		// Galaries
		$value = $this->executeGalleries('imageext_gallery', $value);
		if ( kirby()->option(ImageExt::CONFIG_PARAM_SUPPORT_TAG_GALLERY, 'false') === true ){
			$value = $this->executeGalleries('image_gallery', $value);
		}
		
		// Images
		$value = $this->executeImages('imageext', $value, $attr_template);
		if ( kirby()->option(ImageExt::CONFIG_PARAM_SUPPORT_TAG_IMAGE, 'false') === true ){
			$value = $this->executeImages('image', $value, $attr_template);
		}
		
		return $value;
	}
	
	protected function executeImages($tag, $value, $attr_template = null){
		$offset = 0;
		
		while ( ($block = WebHelper::getblock($tag, $value, $offset)) !== false ) {
			$offset = $block[WebHelper::BLOCK_ARRAY_VALUE_ENDPOS];
			
			// Generate Attributes
			$attr = $this->generateAttr($tag, $block, $attr_template);
			
			// Generate content
			$image = new ImageExtImage($attr);
			$image->executeFunctions();
			$image->saveFile();
			$content = $image->toHTML();
			
			// Replace placholder with final content
			$start = $block[WebHelper::BLOCK_ARRAY_VALUE_STARTPOS];
			$length = $block[WebHelper::BLOCK_ARRAY_VALUE_ENDPOS]-$block[WebHelper::BLOCK_ARRAY_VALUE_STARTPOS];
			$value = substr_replace($value, $content, $start, $length);			
		}

		return $value;
	}
	
	protected function executeGalleries($tag, $value, $attr_template = null){
		$offset = 0;
		
		while ( ($block = WebHelper::getblock($tag, $value, $offset)) !== false ) {
			$offset = $block[WebHelper::BLOCK_ARRAY_VALUE_ENDPOS];
			
			// Generate Attributes
			$attr = $this->generateAttr($tag, $block, $attr_template);

			// Generate content
			$attr[self::PARA_GALLERY_CONTENT] = $block[WebHelper::BLOCK_ARRAY_VALUE_CONTENT];
			$attr[self::PARA_GALLERY_CONTENT] = $this->execute($attr[self::PARA_GALLERY_CONTENT], $attr);
			
			$imageGallery = new ImageExtGallery($attr);
			$content = $imageGallery->toHTML();
			
			// Replace placholder with final content
			$start = $block[WebHelper::BLOCK_ARRAY_VALUE_STARTPOS];
			$length = $block[WebHelper::BLOCK_ARRAY_VALUE_ENDPOS]-$block[WebHelper::BLOCK_ARRAY_VALUE_STARTPOS];
			$value = substr_replace($value, $content, $start, $length);
		}
		
		return $value;
	}
	
	protected function generateAttr($tag, $block, $attr_template = null){
		if ( $attr_template === null ) {
			$attr = $this->default;
		} else {
			$attr = $attr_template;
		}
		
		// First look goes to the profile attribute
		if ( is_array( $this->profiles ) && array_key_exists( self::PARA_PROFILE, $block[WebHelper::BLOCK_ARRAY_VALUE_ATTRIBUTES]) === true ) {
			if ( array_key_exists( $block[WebHelper::BLOCK_ARRAY_VALUE_ATTRIBUTES][self::PARA_PROFILE], $this->profiles ) === true  ){
				foreach ( $this->profiles[ $block[WebHelper::BLOCK_ARRAY_VALUE_ATTRIBUTES][self::PARA_PROFILE] ] as $key => $value ) {
					$attr[$key] = $this->checkValue( $key, $value );
				}
			}
		}
		
		// Set the other attributes
		foreach($block[WebHelper::BLOCK_ARRAY_VALUE_ATTRIBUTES] as $key => $value){
			if ( array_key_exists($key, $this->para_mapping) ) {
				$attr[ $this->para_mapping[$key] ] = $this->checkValue( $this->para_mapping[$key], $value );
			}
		}
		
		// Block attributes
		$attr[self::PARA_PAGE_URL] = $this->page->url();
		$attr[self::PARA_PAGE_ROOT] = $this->page->root();
		
		if ( array_key_exists($tag, $block[WebHelper::BLOCK_ARRAY_VALUE_ATTRIBUTES]) ) {
			$source = $block[WebHelper::BLOCK_ARRAY_VALUE_ATTRIBUTES][$tag];
			$source = ( is_object( $source ) )? $source : $this->page->file ( $source );
			if ( $source ) {
				$attr[self::PARA_IMG_SOURCE] = $source->filename();
				$attr[self::PARA_IMG_EXTENSION] = $source->extension();
				$attr[self::PARA_IMG_OUTPUT_FILENAME] = \str::template($attr[self::PARA_IMG_OUTPUT_FILENAME], array(
						'extension'    => $source->extension(),
						'name'         => $source->name(),
						'filename'     => $source->filename(),
						'safeName'     => \f::safeName($source->name()),
						'safeFilename' => \f::safeName($source->name()) . '.' . $attr[self::PARA_IMG_EXTENSION],
						'width'        => $attr[self::PARA_IMG_WIDTH],
						'height'       => $attr[self::PARA_IMG_HEIGHT],
						'hash'         => md5($source->root() . $this->settingsIdentifier($attr)),
				));
				$attr[self::PARA_IMG_OUTPUT_URL]  = $attr[self::PARA_IMG_OUTPUT_URL] . '/' . $attr[self::PARA_IMG_OUTPUT_FILENAME];
				$attr[self::PARA_IMG_OUTPUT_ROOT] = $attr[self::PARA_IMG_OUTPUT_ROOT] . DS . $attr[self::PARA_IMG_OUTPUT_FILENAME];
				
				if ( $attr[self::PARA_GALLERY_ID] !== false && !empty($attr[self::PARA_GALLERY_ID]) ) {
					$attr[self::PARA_LINK_URL] = $source->url();
				}
			}
		}
		
		return $attr;
	}
	
	protected function checkValue($key, $value){
		switch ($key){
			case self::PARA_FIGURE_CAPTION:
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
					$value = $this->default[$key];
				break;
			case self::PARA_FILTER_COLORIZE:
				break;
			case self::PARA_FILTER_BLUR:
				if ( is_string($value) )
					$value = (strtolower($value) === "true")? 1 : false;
				elseif ( $value === true || $value === false )
					$value = ($value === true)? 1 : $value;
				else
					$value = $this->default[$key];
				break;
			case self::PARA_UPSCALE:
			case self::PARA_FILTER_EDGES:
			case self::PARA_FILTER_EMBOSS:
			case self::PARA_FILTER_INVERT:
			case self::PARA_FILTER_SEPIA:
			case self::PARA_FILTER_SKETCH:
				if ( is_string($value) )
					$value = (strtolower($value) === "true")? true: false;
				elseif ( $value === true || $value === false )
					$value = $value;
				else
					$value = $this->default[$key];
				break;
			case self::PARA_FILTER_CONTRAST:
				if ( is_int($value) && $value >= -100 && $value <= 100 )
		  		$value = $value;
				elseif ( is_numeric($value) && intval($value) >= -100 && intval($value) <= 100 )
					$value = intval($value);
				else
					$value = $this->default[$key];
				break;
			case self::PARA_FILTER_BRIGHTNESS:
				if ( is_int($value) && $value >= -255 && $value <= 255 )
		  		$value = $value;
				elseif ( is_numeric($value) && intval($value) >= -255 && intval($value) <= 255 )
					$value = intval($value);
				else
					$value = $this->default[$key];
				break;
			case self::PARA_FILTER_SMOOTH:
				if ( is_int($value) && $value >= -10 && $value <= 10 )
		  		$value = $value;
				elseif ( is_numeric($value) && intval($value) >= -10 && intval($value) <= 10 )
					$value = intval($value);
				else
					$value = $this->default[$key];
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
					$value = $this->default[$key];
				break;
			case self::PARA_IMG_QUALITY:
				if ( is_int($value) && $value >= 0 && $value <= 100 )
		  		$value = $value;
				elseif ( is_numeric($value) && intval($value) >= 0 && intval($value) <= 100 )
					$value = intval($value);
				else
					$value = $this->default[$key];
				break;
			case self::PARA_LINK_URL:
				// Check if it a file of the current page
				if ( $this->page->file($value) )
					$value = $this->page->file($value)->url();
				$value = \Url($value);
				break;
			case self::PARA_FILTER_OVERLAY:
				break;
		}
		return $value;
	}
	
	protected function settingsIdentifier($attr){
		return implode('-', array(
				$attr[self::PARA_MODE],
				$attr[self::PARA_UPSCALE],
				$attr[self::PARA_IMG_WIDTH],
				$attr[self::PARA_IMG_HEIGHT],
				$attr[self::PARA_IMG_CROP_LEFT],
				$attr[self::PARA_IMG_CROP_TOP],
				$attr[self::PARA_FILTER_BLUR],
				$attr[self::PARA_FILTER_BRIGHTNESS],
				$attr[self::PARA_FILTER_COLORIZE],
				$attr[self::PARA_FILTER_CONTRAST],
				$attr[self::PARA_FILTER_EDGES],
				$attr[self::PARA_FILTER_EMBOSS],
				$attr[self::PARA_FILTER_GRAYSCALE],
				$attr[self::PARA_FILTER_INVERT],
				$attr[self::PARA_FILTER_OPACITY],
				$attr[self::PARA_FILTER_SEPIA],
				$attr[self::PARA_FILTER_SKETCH],
				$attr[self::PARA_FILTER_SMOOTH],
				$attr[self::PARA_FILTER_PIXELATE],
				$attr[self::PARA_FILTER_OVERLAY]
		));
	}
}