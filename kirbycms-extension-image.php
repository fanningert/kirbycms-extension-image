<?php

use at\fanninger\kirby\extension\webhelper\WebHelper;
use at\fanninger\kirby\extension\imageext\ImageExt;

require_once 'kirbycms-extension-image-lib.php';

kirbytext::$pre[] = function($kirbytext, $value) {
	$imageExt = new ImageExt($kirbytext->field->page);
	$value = $imageExt->parseAndConvertTags( $value );
	
	return $value;
};

if ( kirby()->option(ImageExt::CONFIG_PARAM_SUPPORT_TAG_IMAGE, 'false') === true ){
	unset(kirbytext::$tags['image']);
}
if ( kirby()->option(ImageExt::CONFIG_PARAM_SUPPORT_TAG_GALLERY, 'false') === true ){
	unset(kirbytext::$tags['image_gallery']);
}