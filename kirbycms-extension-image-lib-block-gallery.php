<?php

namespace at\fanninger\kirby\extension\imageext;

use at\fanninger\kirby\extension\webhelper\WebHelper;

class ImageExtGallery extends ImageExtObject {
	
	public function parse($tag, array $block, array $attr_template = null){
		$this->data[self::ARRAY_TYPE] = self::TYPE_GALLERY;
		
		parent::parse($tag, $block, $attr_template);
		
		if ( !empty($block[WebHelper::BLOCK_ARRAY_VALUE_CONTENT]) ) {
			$content = $block[WebHelper::BLOCK_ARRAY_VALUE_CONTENT];			
			
			if ( kirby()->option(ImageExt::CONFIG_PARAM_SUPPORT_TAG_IMAGE, 'false') === true ){
				$this->parseSubImages( ImageExtObject::TAG_IMAGE, $block[WebHelper::BLOCK_ARRAY_VALUE_CONTENT], $this->data[self::ARRAY_ATTR] );
			}
			$this->parseSubImages( ImageExtObject::TAG_IMAGEEXT, $block[WebHelper::BLOCK_ARRAY_VALUE_CONTENT], $this->data[self::ARRAY_ATTR] );
			$this->parseSubImages( ImageExtObject::TAG_PICTURE, $block[WebHelper::BLOCK_ARRAY_VALUE_CONTENT], $this->data[self::ARRAY_ATTR] );
		}
		
		// Image bearbeiten die über das Gallery-Element geliefert werden.
		if ( array_key_exists(self::PARA_IMG_SOURCE, $this->data[self::ARRAY_ATTR]) && $this->data[self::ARRAY_ATTR][self::PARA_IMG_SOURCE] !== false && !empty($this->data[self::ARRAY_ATTR][self::PARA_IMG_SOURCE]) ) {
			if ( $this->data[self::ARRAY_ATTR][self::PARA_IMG_SOURCE] === '*' ) {
				$this->imageExt->getPage()->images();
				foreach ( $this->imageExt->getPage()->images() as $image  ) {
					$attr = array();
					$attr[WebHelper::BLOCK_ARRAY_VALUE_ATTRIBUTES][self::PARA_IMG_SOURCE] = $image->filename();
					$this->data[ImageExtObject::ARRAY_IMAGES][] = $this->getImageArray(ImageExtObject::TAG_IMAGE, $attr, $this->data[self::ARRAY_ATTR]);
				}
			}else{
				$images = explode(",", $this->data[self::ARRAY_ATTR][self::PARA_IMG_SOURCE]);
				
				foreach ( $images as $image ) {
					$attr = array();
					$attr[WebHelper::BLOCK_ARRAY_VALUE_ATTRIBUTES][self::PARA_IMG_SOURCE] = trim( $image );
					$this->data[ImageExtObject::ARRAY_IMAGES][] = $this->getImageArray(ImageExtObject::TAG_IMAGE, $attr, $this->data[self::ARRAY_ATTR]);
				}
			}
		}
	}
	
	protected function parseSubImages($tag, $value, array $attr_template = null){
		$offset = 0;
		while ( ($block = WebHelper::getblock($tag, $value, $offset)) !== false ) {
			$offset = $block[WebHelper::BLOCK_ARRAY_VALUE_ENDPOS];
				
			$this->data[ImageExtObject::ARRAY_IMAGES][] = $this->getImageArray($tag, $block, $attr_template);
		}
	}
	
	protected function getImageArray($tag, $block, array $attr_template = null){
		switch ($tag) {
			case ImageExtObject::TAG_IMAGEEXT:
			case ImageExtObject::TAG_IMAGE:
				$image = new ImageExtImage( $this->imageExt );
				$image->parse($tag, $block, $attr_template);
				$image->parseFileAttributes();
				return $image->toArray();
			break;
		}
		
		return null;
	}
	
	public function toHTML(){
		$content = "";
		
		foreach ( $this->data[self::ARRAY_IMAGES] as $image ){
			$imageExt = new ImageExtImage($this->imageExt, $image);
			$imageExt->generate();
			$imageExt->optimizeOutput();
			$content .= $imageExt->toHTML();
		}	
		
		if( $this->data[self::ARRAY_ATTR][self::PARA_SNIPPET_GALLERY] !== false && file_exists( kirby()->roots->snippets ().'/'.$this->data[self::ARRAY_ATTR][self::PARA_SNIPPET_GALLERY].'.php' ) ){
			$attr = array();
			if ( !empty($this->data[self::ARRAY_ATTR][self::PARA_GALLERY_CLASS]) )
				$attr['class'] = $this->data[self::ARRAY_ATTR][self::PARA_GALLERY_CLASS];
			$attr['images'] = $content;
			return ( string ) snippet( $this->data[self::ARRAY_ATTR][self::PARA_SNIPPET_GALLERY], array( 'data' => $attr), true );
		}else{
			$attr = array();
			if ( !empty($this->data[self::ARRAY_ATTR][self::PARA_GALLERY_CLASS]) )
				$attr['class'] = $this->data[self::ARRAY_ATTR][self::PARA_GALLERY_CLASS];
			return \Html::tag("div", $content, $attr);
		}
	}
}