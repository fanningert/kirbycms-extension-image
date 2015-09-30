<?php

namespace at\fanninger\kirby\extension\imageext;

require_once 'kirbycms-extension-image-lib-block-object.php';
require_once 'kirbycms-extension-image-lib-block-image.php';
require_once 'kirbycms-extension-image-lib-block-gallery.php';

use at\fanninger\kirby\extension\webhelper\WebHelper;

class ImageExt {
	
	const CONFIG_PARAM_DEBUG = "kirby.extension.imageext.debug";
	const CONFIG_PARAM_SNIPPET_IMAGE = "kirby.extension.imageext.snippet.image";
	const CONFIG_PARAM_SNIPPET_GALLERY = "kirby.extension.imageext.snippet.gallery";
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
	const ATTR_SNIPPET_IMAGE = "snippet_image";
	const ATTR_SNIPPET_GALLERY = "snippet_gallery";
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
	const ATTR_IMG_MIMETYPE = "image_mimetype";
	const ATTR_IMG_MEDIAQUERY = "image_mediaquery";
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
	const ATTR_SUPPORT_IMG_MIMETYPE = "type";
	const ATTR_SUPPORT_IMG_MEDIAQUERY = "media";
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
	
	/**
	 * @var \Page
	 */
	protected $page = null;
	protected $default = array();
	protected $profiles = array();
	
	public function __construct(\Page $page) {
		$this->page = $page;
		$this->loadDefaults();
		$this->loadProfiles();
	}
	
	protected function loadDefaults(){
		$this->default[ImageExtObject::PARA_DRIVER] = kirby()->option(self::CONFIG_PARAM_DEFAULT_DRIVER, ImageExtObject::DRIVER_GD);
		$this->default[ImageExtObject::PARA_PROFILE] = kirby()->option(self::CONFIG_PARAM_DEFAULT_PROFILE, ImageExtObject::PROFILE_NONE);
		$this->default[ImageExtObject::PARA_SNIPPET_IMAGE] = kirby()->option(self::CONFIG_PARAM_SNIPPET_IMAGE, false);
		$this->default[ImageExtObject::PARA_SNIPPET_GALLERY] = kirby()->option(self::CONFIG_PARAM_SNIPPET_GALLERY, false);
		$this->default[ImageExtObject::PARA_FIGURE_CLASS] = kirby()->option(self::CONFIG_PARAM_DEFAULT_CLASS_FIGURE, "image-figure");
		$this->default[ImageExtObject::PARA_FIGURE_CAPTION] = false;
		$this->default[ImageExtObject::PARA_FIGURE_CAPTION_TOP] = kirby()->option(self::CONFIG_PARAM_DEFAULT_CAPTION_TOP, false);
		$this->default[ImageExtObject::PARA_FIGURE_CAPTION_FIELD] = kirby()->option(self::CONFIG_PARAM_DEFAULT_CAPTION_FIELD, false);
		$this->default[ImageExtObject::PARA_LINK_CLASS] = kirby()->option(self::CONFIG_PARAM_DEFAULT_CLASS_LINK, "image-link");
		$this->default[ImageExtObject::PARA_LINK_TARGET] = kirby()->option(self::CONFIG_PARAM_DEFAULT_TARGET, false);
		$this->default[ImageExtObject::PARA_LINK_REL] = false;
		$this->default[ImageExtObject::PARA_LINK_TITLE] = false;
		$this->default[ImageExtObject::PARA_LINK_URL] = false;
		$this->default[ImageExtObject::PARA_IMG_SOURCE] = false;
		$this->default[ImageExtObject::PARA_IMG_SOURCE_MODIFIED] = false;
		$this->default[ImageExtObject::PARA_IMG_CLASS] = kirby()->option(self::CONFIG_PARAM_DEFAULT_CLASS_IMG, "image");
		$this->default[ImageExtObject::PARA_IMG_ALT] = false;
		$this->default[ImageExtObject::PARA_IMG_TITLE] = false;
		$this->default[ImageExtObject::PARA_IMG_WIDTH] = kirby()->option(self::CONFIG_PARAM_DEFAULT_WIDTH, false);
		$this->default[ImageExtObject::PARA_IMG_HEIGHT] = kirby()->option(self::CONFIG_PARAM_DEFAULT_HEIGHT, false);
		$this->default[ImageExtObject::PARA_IMG_QUALITY] = kirby()->option(self::CONFIG_PARAM_DEFAULT_QUALITY, 90);
		$this->default[ImageExtObject::PARA_IMG_MIMETYPE] = false;
		$this->default[ImageExtObject::PARA_IMG_MEDIAQUERY] = false;
		$this->default[ImageExtObject::PARA_IMG_CROP_LEFT] = false;
		$this->default[ImageExtObject::PARA_IMG_CROP_TOP] = false;
		$this->default[ImageExtObject::PARA_IMG_EXTENSION] = false;
		$this->default[ImageExtObject::PARA_IMG_OUTPUT_URL] = kirby()->urls()->thumbs();
		$this->default[ImageExtObject::PARA_IMG_OUTPUT_ROOT] = kirby()->roots()->thumbs();
		$this->default[ImageExtObject::PARA_IMG_OUTPUT_FILENAME] = "{safeName}-{hash}.{extension}";
		$this->default[ImageExtObject::PARA_GALLERY_CONTENT] = "";
		$this->default[ImageExtObject::PARA_GALLERY_CLASS] = kirby()->option(self::CONFIG_PARAM_DEFAULT_GALLERY_CLASS, "image-gallery");
		$this->default[ImageExtObject::PARA_GALLERY_PREFIX] = kirby()->option(self::CONFIG_PARAM_DEFAULT_GALLERY_PREFIX, "gallery-");
		$this->default[ImageExtObject::PARA_GALLERY_ID] = false;
		$this->default[ImageExtObject::PARA_GALLERY_LINK_CLASS] = kirby()->option(self::CONFIG_PARAM_DEFAULT_GALLERY_LINK_CLASS, "fancybox");
		$this->default[ImageExtObject::PARA_GALLERY_LINK_ATTR] = kirby()->option(self::CONFIG_PARAM_DEFAULT_GALLERY_LINK_ATTR, "rel");
		$this->default[ImageExtObject::PARA_MODE] = ImageExtObject::MODE_NONE;
		$this->default[ImageExtObject::PARA_UPSCALE] = false;
		$this->default[ImageExtObject::PARA_OVERWRITE] = false;
		$this->default[ImageExtObject::PARA_FILTER_BLUR] = false;
		$this->default[ImageExtObject::PARA_FILTER_GRAYSCALE] = false;
		$this->default[ImageExtObject::PARA_FILTER_BRIGHTNESS] = false;
		$this->default[ImageExtObject::PARA_FILTER_CONTRAST] = false;
		$this->default[ImageExtObject::PARA_FILTER_COLORIZE] = false;
		$this->default[ImageExtObject::PARA_FILTER_EDGES] = false;
		$this->default[ImageExtObject::PARA_FILTER_EMBOSS] = false;
		$this->default[ImageExtObject::PARA_FILTER_INVERT] = false;
		$this->default[ImageExtObject::PARA_FILTER_OPACITY] = false;
		$this->default[ImageExtObject::PARA_FILTER_SEPIA] = false;
		$this->default[ImageExtObject::PARA_FILTER_SKETCH] = false;
		$this->default[ImageExtObject::PARA_FILTER_SMOOTH] = false;
		$this->default[ImageExtObject::PARA_FILTER_PIXELATE] = false;
		$this->default[ImageExtObject::PARA_FILTER_OVERLAY] = false;
	}
	
	protected function loadProfiles(){
		$this->profiles = kirby()->options(self::CONFIG_PARAM_PROFILES, array());
		if ( array_key_exists(self::CONFIG_PARAM_PROFILES, $this->profiles) ) {
			$this->profiles = $this->profiles[self::CONFIG_PARAM_PROFILES];
		}
	}
	
	public function getDefaults(){
		return $this->default;
	}
	
	public function getProfiles(){
		return $this->profiles;
	}
	
	public function getPage(){
		return $this->page;
	}
	
	public function isDebug(){
		return kirby()->option(self::CONFIG_PARAM_DEBUG, false);
	}
	
	/**
	 * Parse the content for an picture, image or gallery tag
	 */
	public function parseAndConvertTags($value, array $attr_template = null){
		//Galleries
		$value = $this->parseAndConvertGalleryTags($value, $attr_template);
		
		//Images
		$value = $this->parseAndConvertImageTags($value, $attr_template);
		
		return $value;
	}
	
	public function parseAndConvertImageTags($value, array $attr_template = null){
		//Images
		$value = $this->parseAndConvertTag( ImageExtObject::TAG_PICTURE, $value, $attr_template);
		$value = $this->parseAndConvertTag( ImageExtObject::TAG_IMAGEEXT, $value, $attr_template);
		if ( kirby()->option(ImageExt::CONFIG_PARAM_SUPPORT_TAG_IMAGE, 'false') === true ){
			$value = $this->parseAndConvertTag( ImageExtObject::TAG_IMAGE, $value, $attr_template);
		}
		return $value;
	}
	
	public function parseAndConvertGalleryTags($value, array $attr_template = null){
		//Galleries
		$value = $this->parseAndConvertTag( ImageExtObject::TAG_IMAGEEXT_GALLERY, $value, $attr_template);
		if ( kirby()->option(ImageExt::CONFIG_PARAM_SUPPORT_TAG_GALLERY, 'false') === true ){
			$value = $this->parseAndConvertTag( ImageExtObject::TAG_IMAGE_GALLERY, $value, $attr_template);
		}
		return $value;
	}
	
	protected function parseAndConvertTag($tag, $value, array $attr_template = null){
		$offset = 0;
		while ( ($block = WebHelper::getblock($tag, $value, $offset)) !== false ) {
			$content = "";
			$offset = $block[WebHelper::BLOCK_ARRAY_VALUE_ENDPOS];
			$start = $block[WebHelper::BLOCK_ARRAY_VALUE_STARTPOS];
			$length = $block[WebHelper::BLOCK_ARRAY_VALUE_ENDPOS]-$block[WebHelper::BLOCK_ARRAY_VALUE_STARTPOS];
			
			switch ($tag) {
				case ImageExtObject::TAG_IMAGEEXT_GALLERY:
				case ImageExtObject::TAG_IMAGE_GALLERY:
					$gallery = new ImageExtGallery( $this );
					$gallery->parse( $tag, $block, $attr_template );
					$gallery->optimizeOutput();
					if ( $this->isDebug() )
						$content = $gallery->getDebug();
					else
						$content = $gallery->toHTML();
					break;
				case ImageExtObject::TAG_IMAGEEXT:
				case ImageExtObject::TAG_IMAGE:
					$image = new ImageExtImage( $this );
					$image->parse( $tag, $block, $attr_template );	
					$image->parseFileAttributes();
					$image->optimizeOutput();
					if ( $this->isDebug() ) {
						$content = $image->getDebug();
					} else {
						$image->generate();
						$content = $image->toHTML();
					}
					break;
			}
			
			// Replace placholder with final content
			$value = substr_replace($value, $content, $start, $length);
			$offset = $start + strlen($content);
		}
		
		return $value;
	}
	
	public static function getTumb($page, $attr = array()){
		if ( !is_array($attr) && count($attr) == 0 )
			return "";
		
		$imageExt = new ImageExt($page);
		$imageExtImage = new ImageExtImage( $imageExt );
		$imageExtImage->parse( ImageExtImage::TAG_IMAGE, array(), $attr );
		$imageExtImage->parseFileAttributes();
		$imageExtImage->optimizeOutput();
		if ( $imageExt->isDebug() ) {
			return $imageExtImage->getDebug();
		} else {
			$imageExtImage->generate();
			return $imageExtImage->toHTML();
		}
	}
	
	public static function getGallery($page, $attr = array()){
		
	}
}