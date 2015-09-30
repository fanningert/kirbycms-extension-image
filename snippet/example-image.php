<?php
use at\fanninger\kirby\extension\webhelper\WebHelper;
use at\fanninger\kirby\extension\imageext\ImageExtImage;
?>
<?php if( strlen(WebHelper::snippetAttribute($data, 'figure_caption')) > 0 ): ?>
<figure class="<?php echo $data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_FIGURE_CLASS] ?>">
<?php endif; ?>
	<?php if( strlen($data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_LINK_URL]) > 0 ): ?>
	<a href="<?php echo $data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_LINK_URL] ?>"<?php 
	if( strlen($data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_LINK_CLASS]) > 0 && strlen($data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_GALLERY_LINK_CLASS]) > 0 ){
		echo ' class="'.$data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_LINK_CLASS].' '.$data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_GALLERY_LINK_CLASS].'"';
	}elseif( strlen($data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_LINK_CLASS]) > 0 ){
		echo ' class="'.$data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_LINK_CLASS].'"';
	}elseif( strlen($data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_GALLERY_LINK_CLASS]) > 0 ){
		echo ' class="'.$data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_GALLERY_LINK_CLASS].'"';
	}
	if( strlen($data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_LINK_TARGET]) > 0 ){
		echo ' target="'.$data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_LINK_TARGET].'"';
	}
	if( strlen($data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_LINK_TITLE]) > 0 ){
		echo ' title="'.$data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_LINK_TITLE].'"';
	}
	if( strlen($data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_LINK_REL]) > 0 ){
		echo ' rel="'.$data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_LINK_REL].'"';
	}
	if( strlen($data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_GALLERY_LINK_ATTR]) > 0 ){
		echo ' '.$data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_GALLERY_LINK_ATTR].'="'.$data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_GALLERY_PREFIX].$data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_GALLERY_ID].'"';
	}
	?>>
	<?php endif; ?>
		<img src="<?php echo $data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_IMG_OUTPUT_URL] ?>"<?php 
		 if( strlen($data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_IMG_CLASS]) > 0 ){
			 echo ' class="'.$data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_IMG_CLASS].'"';
		 }
		 if( strlen($data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_IMG_ALT]) > 0 ){
			 echo ' alt="'.$data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_IMG_ALT].'"';
		 }
		 if( strlen($data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_IMG_TITLE]) > 0 ){
			 echo ' title="'.$data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_IMG_TITLE].'"';
		 }
		 ?> />
	<?php if( strlen($data[ImageExtImage::ARRAY_ATTR][ImageExtImage::PARA_LINK_URL]) > 0 ): ?>
	</a>
	<?php endif; ?>
	<?php if( strlen(WebHelper::snippetAttribute($data, 'figure_caption')) > 0 ): ?>
	<figcaption>
		<?php WebHelper::snippetAttribute($data, 'figure_caption') ?>
	</figcaption>
	<?php endif; ?>
<?php if( strlen(WebHelper::snippetAttribute($data, 'figure_caption')) > 0 ): ?>
</figure>
<?php endif; ?>