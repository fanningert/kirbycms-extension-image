<?php

/**
 * @version: 0.7
 */

kirbytext::$tags['image'] = array(
  'attr' => array(
    'width',
    'height',
    'alt',
    'text',
    'title',
    'class',
    'imgclass',
    'linkclass',
    'caption',
    'caption_field',
    'caption_top',
    'link',
    'target',
    'popup',
    'rel',
    'resize',
    'quality',
    'blur',
    'upscale',
    'grayscale',
    'width_output',
    'height_output'
  ),
  'html' => function($tag) {
    $image_options = array();
    $image = $tag->attr('image');

    foreach(kirbytext::$tags['image']['attr'] as $name) {
      $value = $tag->attr($name);
      if( !empty($value) )
        $image_options[$name] = $value;
    }
    unset($image_options['target']);
    unset($image_options['popup']);
    if(!empty($tag->target()))
      $image_options['target'] = $tag->target();

    if(array_key_exists('alt', $image_options) and !$image_options['alt'] and empty($image_options['alt']) and array_key_exists('text', $image_options) and !$image_options['text'] and !empty($image_options['text'])){
      $image_options['alt'] = $image_options['text'];
      unset($image_options['text']);
    }

    return ImageHelper::getThumb($tag->page(), $image, $image_options);
  }
);

kirbytext::$tags['image_gallery'] = array(
  'attr' => array(
    'width',
    'height',
    'class',
    'galleryclass',
    'imgclass',
    'linkclass',
    'caption',
    'caption_field',
    'caption_top',
    'link',
    'resize',
    'quality',
    'blur',
    'upscale',
    'grayscale',
    'width_output',
    'height_output'
  ),
  'html' => function($tag) {
    $image_options = array();

    if(!$tag->attr('image_gallery')) return;

    $images = explode(",", $tag->attr('image_gallery'));

    foreach(kirbytext::$tags['image_gallery']['attr'] as $name) {
      if( !empty($value = $tag->attr($name)) )
        $image_options[$name] = $value;
    }
    
    return ImageHelper::getGallery($tag->page(), $images, $image_options);
  }
);