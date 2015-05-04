<?php

namespace at\fanninger\kirby\extension\imageext;

use at\fanninger\kirby\extension\webhelper\WebHelper;

class ImageExtGallery {
	
	protected $parameter = array();
	
	public function __construct($attr) {
		if ( !is_array($attr) )
			throw new \Exception("Missing attribute array");
		
		$this->parameter = $attr;
	}
	
	public function toHTML(){
		$attr = array();
		if ( !empty($this->parameter[ImageExt::PARA_GALLERY_CLASS]) )
			$attr['class'] = $this->parameter[ImageExt::PARA_GALLERY_CLASS];
		$content = \Html::tag("div", $this->parameter[ImageExt::PARA_GALLERY_CONTENT], $attr);
		
		return $content;
	}
	
	public function __toString(){
		return $this->toHTML();
	}
}