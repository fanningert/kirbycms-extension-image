<?php

namespace at\fanninger\kirby\extension\imageext;

use at\fanninger\kirby\extension\webhelper\WebHelper;

class ImageExtGallery {
	
	protected $imageExt = null;
	protected $parameter = array();
	
	public function __construct($attr, $imageExt) {
		if ( !is_array($attr) )
			throw new \Exception("Missing attribute array");
		
		$this->parameter = $attr;
		$this->imageExt = $imageExt;
	}
	
	public function execute(){
		// Generate content
		$this->parameter[ImageExt::PARA_GALLERY_CONTENT] = $this->imageExt->executeImages($this->parameter[ImageExt::PARA_GALLERY_CONTENT], $this->parameter);
		
		
	}
	
	public function toHTML(){
		$attr = array();
		if ( !empty($this->parameter[ImageExt::PARA_GALLERY_CLASS]) )
			$attr['class'] = $this->parameter[ImageExt::PARA_GALLERY_CLASS];
		return \Html::tag("div", $this->parameter[ImageExt::PARA_GALLERY_CONTENT], $attr);
	}
	
	public function __toString(){
		return $this->toHTML();
	}
}