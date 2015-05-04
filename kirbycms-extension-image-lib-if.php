<?php

namespace at\fanninger\kirby\extension\imageext;

abstract class ImageExtDriver {
  
	const POSITION_CENTER = "center";
	const POSITION_TOP = "top";
	const POSITION_LEFT = "left";
	const POSITION_BOTTOM = "bottom";
	const POSITION_RIGHT = "right";
	const POSITION_TOP_LEFT = "top left";
	const POSITION_TOP_RIGHT = "top right";
	const POSITION_BOTTOM_LEFT = "bottom left";
	const POSITION_BOTTOM_RIGHT = "bottom right";
	
	public abstract function __construct($filename = null, $width = null, $height = null, $color = null);
	public abstract function __destruct();
	
	public abstract function load($filename);
	public abstract function load_base64($base64string);
	
	public abstract function setQuality($quality=80);
	
	public abstract function adaptiveBlurImage($sigma);
	public abstract function brightness($level);
	public abstract function contrast($level);
	public abstract function colorize($color, $opacity = 100);
	public abstract function desaturate($percentage = 100);
	public abstract function invert();
	public abstract function edges();
	public abstract function emboss();
	public abstract function fill($color = '#000000');
	public abstract function opacity($opacity);
	public abstract function pixelate($block_size = 10);
	public abstract function sepia();
	public abstract function sketch();
	public abstract function smooth($level);
	public abstract function overlay($overlay, $position = ImageExtDriver::POSITION_CENTER, $opacity = 1, $x_offset = 0, $y_offset = 0);
	
	public abstract function auto_orient();
	public abstract function best_fit($max_width, $max_height, $upscale = false);
	public abstract function fit_to_height($height, $upscale = false);
	public abstract function fit_to_width($width, $upscale = false);
	public abstract function flip($direction);
	public abstract function crop($x1, $y1, $x2, $y2);
	public abstract function crop_dimension($width, $height, $top, $left);
	public abstract function resize($width, $height, $upscale = false);
	public abstract function rotate($angle, $bg_color = '#000000');
	public abstract function thumbnail($width, $height = null, $upscale = false);
	
	public abstract function getExtension();
	
	public abstract function output($format = null, $quality = null);
	public abstract function output_base64($format = null, $quality = null);
	public abstract function save($filename = null, $quality = null, $format = null);
	
}