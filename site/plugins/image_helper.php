<?php

/**
 * @version: 0.7
 */

class ImageHelper {
  /**
   * Create/Get a Thumb of an image and return the HTML-Tag
   */
  public static function getThumb($page, $image_url, $image_param = array()){

    $defaults = array(
      'url'           => '',
      'url_thumb'     => '',
      'width_output'  => kirby()->option('kirbytext.image.width_output', 'false'),
      'height_output' => kirby()->option('kirbytext.image.height_output', 'false'),
      'width'         => kirby()->option('kirbytext.image.width', ''),
      'height'        => kirby()->option('kirbytext.image.height', ''),
      'alt'           => 'false',
      'title'         => 'false',
      'class'         => kirby()->option('kirbytext.image.figureclass', 'image'),
      'imgclass'      => kirby()->option('kirbytext.image.imgclass', ''),
      'linkclass'     => kirby()->option('kirbytext.image.linkclass', ''),
      'caption'       => kirby()->option('kirbytext.image.caption', 'false'),
      'caption_top'   => kirby()->option('kirbytext.image.caption_top', 'false'),
      'caption_field' => kirby()->option('kirbytext.image.caption_field', 'false'),
      'link'          => '',
      'target'        => kirby()->option('kirbytext.image.target', ''),
      'rel'           => '',
      'resize'        => kirby()->option('kirbytext.image.resize', 'false'),
      'quality'       => kirby()->option('kirbytext.image.quality', 100),
      'blur'          => kirby()->option('kirbytext.image.blur', 'false'),
      'upscale'       => kirby()->option('kirbytext.image.upscale', 'false'),
      'grayscale'     => kirby()->option('kirbytext.image.grayscale', 'false')
    );
    
    $param = array();
    foreach($defaults as $key => $value){
      $param[$key] = $value;
      if( array_key_exists($key, $image_param) and !empty($image_param[$key]))
        $param[$key] = (String)$image_param[$key];
    }
    
    //Type correction
    $param['width_output'] = ($param['width_output'] === 'true')? true : false;
    $param['height_output'] = ($param['height_output'] === 'true')? true : false;
    $param['caption_top'] = ($param['caption_top'] === 'true')? true : false;
    $param['caption_field'] = ($param['caption_field'] === 'false')? false : $param['caption_field'];
    $param['blur'] = ($param['blur'] === 'true')? true : false;
    $param['upscale'] = ($param['upscale'] === 'true')? true : false;
    $param['grayscale'] = ($param['grayscale'] === 'true')? true : false;
    
    $param['alt'] = ($param['alt'] === 'false')? false : $param['alt'];
    $param['title'] = ($param['title'] === 'false')? false : $param['title'];
    $param['caption'] = ($param['caption'] === 'false')? false : $param['caption'];
    $param['caption'] = ($param['caption'] === 'true')? true : $param['caption'];

    //Check if $image is an internal image or a url
    $file = $page->file($image_url);
    $param['url'] = $file ? (String)$file->url() : (String)url($image_url);
    $param['url_thumb'] = $param['url'];

    if(empty($param['url']))
      return;  

    //If resize == resize/crop use thumb
    if($param['resize'] or $param['resize'] == 'resize' or $param['resize'] == 'crop' or $param['blur'] or $param['upscale'] or $param['grayscale']){
      $thumb_options = array();
      if( !empty($param['width']) or !empty($param['height']) )
        $thumb_options['crop'] = ($param['resize'] == 'crop')?true:false;
      if( !empty($param['width']) )
        $thumb_options['width'] = $param['width'];
      if( !empty($param['height']) )
        $thumb_options['height'] = $param['height'];
      $thumb_options['quality'] = $param['quality'];
      $thumb_options['blur'] = $param['blur'];
      $thumb_options['upscale'] = $param['upscale'];
      $thumb_options['grayscale'] = $param['grayscale'];
      $thumb = thumb($file,$thumb_options,true);
      
      $thumb_dimension = $thumb->result->dimensions();
      $param['width'] = $thumb_dimension->width();
      $param['height'] = $thumb_dimension->height();
      $param['url_thumb'] = (String)$thumb->url();
    }else{
      if($file){
        $file_dimension = $file->dimensions();
        if(empty($param['width']))
          $param['width'] = $file_dimension->width();
        if(empty($param['height']))
          $param['height'] = $file_dimension->height();
      }
    }

    // try to get some infos from the image object, when the attr are empty
    if($file) {
      if( ($param['alt'] === true or empty($param['alt'])) and !empty($file->alt()) ) {
        $param['alt'] = $file->alt();
      }
      if( ($param['title'] === true or empty($param['title'])) and !empty($file->title()) ) {
        $param['title'] = $file->title();
      }
      if( $param['caption'] !== false and ( $param['caption'] === true or empty($param['caption'])) and $param['caption_field'] !== false and !empty($param['caption_field']) and !empty($file->$param['caption_field']())){
        $param['caption'] = $file->$param['caption_field']();
      }
    }
    if(empty($param['alt'])) 
      $param['alt'] = pathinfo($param['url'] , PATHINFO_FILENAME);

    if(!$param['width_output'])
      $param['width'] = '';
    if(!$param['height_output'])
      $param['height'] = '';

    // build image tag
    $image = html::img($param['url_thumb'], array(
      'width'  => $param['width'],
      'height' => $param['height'],
      'class'  => $param['imgclass'],
      'title'  => html($param['title']),
      'alt'    => html($param['alt'])
    ));
    
    if($param['link']) {
      // build the href for the link
      if($param['link'] == 'self') {
        $href = $param['url'] ;
      } else if($file and $param['link'] == $file->filename()) {
        $href = $file->url();
      } else {
        $href = $param['link'];
      }
      $image = html::a(url($href), $image, array(
        'rel'    => $param['rel'],
        'class'  => $param['linkclass'],
        'title'  => html($param['title']),
        'target' => $param['target']
      ));
    }

    if($param['caption'] !== false and !empty($param['caption'])) {
      $figure = new Brick('figure');
      $figure->addClass($param['class']);
      if($param['caption'] !== false and $param['caption'] !== true){
        if($param['caption_top'] === true)
          $figure->append('<figcaption>' . html($param['caption']) . '</figcaption>');
        $figure->append($image);
        if($param['caption_top'] === false)
          $figure->append('<figcaption>' . html($param['caption']) . '</figcaption>');
      }else{
        $figure->append($image);
      }
      return $figure;
    }else{
      return $image; 
    }
  }

  public static function getGallery($page, $images, $image_param = array()){

    $defaults = array(
      'width_output'  => 'false',
      'height_output' => 'false',
      'width'         => '',
      'height'        => '',
      'alt'           => 'false',
      'title'         => 'false',
      'class'         => kirby()->option('kirbytext.gallery.figureclass', 'image'),
      'galleryclass'  => kirby()->option('kirbytext.gallery.galleryclass', 'gallery'),
      'imgclass'      => kirby()->option('kirbytext.gallery.imgclass', ''),
      'linkclass'     => kirby()->option('kirbytext.gallery.linkclass', ''),
      'caption'       => kirby()->option('kirbytext.gallery.caption', 'false'),
      'caption_top'   => kirby()->option('kirbytext.gallery.caption_top', 'false'),
      'caption_field' => kirby()->option('kirbytext.gallery.caption_field', 'false'),
      'target'        => '',
      'resize'        => 'false',
      'quality'       => 100,
      'blur'          => 'false',
      'upscale'       => 'false',
      'grayscale'     => 'false'
    );

    $param = array();
    foreach($defaults as $key => $value){
      $param[$key] = $value;
      if(array_key_exists($key, $image_param) and !empty($image_param[$key]))
        $param[$key] = (String)$image_param[$key];
    }

    $param['caption'] = ($param['caption'] === 'true')?'true':'false';

    $gallery = new Brick('div');
    $gallery->addClass($param['galleryclass']);
     
    foreach($images as $image){
      $file = $page->file($image);
      if($file){
        $param['link'] = $file->url();
      }else{
        unset($param['link']);
      }

      $gallery->append(ImageHelper::getThumb($page, $image, $param));
    }

    return $gallery;
  }
}