<?php

namespace at\fanninger\kirby\extension\imageext;

use abeautifulsite\SimpleImage;

require_once 'kirbycms-extension-image-lib-if.php';

class ImageExtDriverGD extends ImageExtDriver {
	
	/**
	 * @var SimpleImage
	 */
	protected $image_class;
	protected $quality;
	
	public function __construct($filename = null, $width = null, $height = null, $color = null) {
		$this->image_class = new SimpleImage($filename, $width, $height, $color);
		return $this;
	}
	
	public function __destruct() {
		
	}
	
	public function load($filename) {
		$this->image_class->load($filename);
		return $this;
	}
	
	public function load_base64($base64string){
		$this->image_class->load_base64($base64string);
		return $this;
	}
	
	public function setQuality($quality=80){
		$this->image_class->quality = $quality;
		return $this;
	}
	
/*
 * Filter functions
 */
	
	public function adaptiveBlurImage($sigma = 1){
		$this->image_class->blur('gaussian', $sigma);
		return $this;
	}
	
	public function brightness($level){
		$this->image_class->brightness($level);
		return $this;
	}
	
	public function contrast($level){
		$this->image_class->contrast($level);
		return $this;
	}
	
	public function colorize($color, $opacity = 100){
		$opacity = $opacity / 100;
		$this->image_class->colorize($color, $opacity);
		return $this;
	}
	
	public function desaturate($percentage = 100){
		$this->image_class->desaturate($percentage);
		return $this;
	}
	
	public function invert(){
		$this->image_class->invert();
		return $this;
	}
	
	public function edges(){
		$this->image_class->edges();
		return $this;
	}
	
	public function emboss(){
		$this->image_class->emboss();
		return $this;
	}
	
	public function fill($color = '#000000'){
		$this->image_class->fill($color);
		return $this;
	}
	
	public function opacity($opacity){
		$opacity = $opacity / 100;
		$this->image_class->opacity($opacity);
		return $this;
	}
	
	public function pixelate($block_size = 10){
		$this->image_class->pixelate($block_size);
		return $this;
	}
	
	public function sepia(){
		$this->image_class->sepia();
		return $this;
	}
	
	public function sketch(){
		$this->image_class->sketch();
		return $this;
	}
	
	public function smooth($level){
		$this->image_class->smooth($level);
		return $this;
	}
	
	public function overlay($overlay, $position = 'center', $opacity = 1, $x_offset = 0, $y_offset = 0){
		$this->image_class->overlay($overlay, $position, $opacity, $x_offset, $y_offset);
		return $this;
	}

/*
 * Sizing functions
 */
	
	public function auto_orient(){
		$this->image_class->auto_orient();
		return $this;
	}
	
	public function best_fit($max_width, $max_height, $upscale = false){
		if ( $upscale === false && ( $width >= $this->image_class->get_width() || $height >= $this->image_class->get_height() ) ){
			return $this;
		}
		$this->image_class->best_fit($max_width, $max_height);
		return $this;
	}
	
	public function fit_to_height($height, $upscale = false){
		if ( $upscale === false && $height >= $this->image_class->get_height() ){
			return $this;
		}
		$this->image_class->fit_to_height($height);
		return $this;
	}
	
	public function fit_to_width($width, $upscale = false){
		if ( $upscale === false && $width >= $this->image_class->get_width() ){
			return $this;
		}
		$this->image_class->fit_to_width($width);
		return $this;
	}
	
	public function flip($direction){
		$this->image_class->flip($direction);
		return $this;
	}
	
	public function crop($x1, $y1, $x2, $y2){
		$this->image_class->crop($x1, $y1, $x2, $y2);
		return $this;
	}
	
	public function crop_dimension($width, $height, $top, $left){
		
		return $this;
	}
	
	public function resize($width, $height, $upscale = false){
		if ( $upscale === false && ( $width >= $this->image_class->get_width() || $height >= $this->image_class->get_height() ) ){
			return $this;
		}
		$this->image_class->resize($width, $height);
		return $this;
	}
	
	public function rotate($angle, $bg_color = '#000000'){
		$this->image_class->rotate($angle, $bg_color);
		return $this;
	}
	
	public function thumbnail($width, $height = null, $upscale = false){
		if ( $upscale === false && ( $width >= $this->image_class->get_width() || $height >= $this->image_class->get_height() ) ){
			return $this;
		}
		$this->image_class->thumbnail($width, $height);
		return $this;
	}
	
	public function getExtension() {
		return $this->image_class->getExtension();
	}
	
/*
 * Output functions
 */
	
	public function output($format = null, $quality = null){
		$this->image_class->output($format, $quality);
	}
	
	public function output_base64($format = null, $quality = null){
		return $this->image_class->output_base64($format, $quality);
	}
	
	public function save($filename = null, $quality = null, $format = null){
		$this->image_class->save($filename, $quality, $format);
	}
}