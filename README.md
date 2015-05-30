# KirbyText Extension - Image

This extended version of the original KirbyTag image function. You can replace the default `image` with set the config parameter. A gallery tag is also included.

Examples can you see in action here: [Kirby Extension - Image Extended](https://www.fanninger.at/thomas/works/kirbycms-extension-image)

## Installation

### GIT

Go into the `{kirby_installation}/site/plugins` directory and execute following command.

```bash
$ git clone https://github.com/fanningert/kirbycms-extension-webhelper.git
$ git clone https://github.com/fanningert/kirbycms-extension-image.git
```

### GIT submodule

Go in the root directory of your git repository and execute following command to add the repository as submodule to your GIT repository.

```bash
$ git submodule add https://github.com/fanningert/kirbycms-extension-webhelper.git ./site/plugins/kirbycms-extension-webhelper
$ git submodule add https://github.com/fanningert/kirbycms-extension-image.git ./site/plugins/kirbycms-extension-image
$ git submodule init
$ git submodule update
```

### Manuell

## Update

### GIT

Go into the `{kirby_installation}/site/plugins/kirbycms-extension-image` directory and execute following command.

```bash
$ git pull
```
Don't forget to update the requirement `kirbycms-extension-webhelper`.

### GIT submodule

Go in the root directory of your git repository and execute following command to update the submodule of this extension.

```bash
$ git submodule update
```

## Upgrade from version lower then 0.9

Delete following files and then use the install instruction.

* {kirby-install}/site/tags/image.php
* {kirby-install}/site/plugins/image_helper.php

## ToDos

* Add water stamp support (`kirby.extension.imageext.watermark`) or you can use the overlay filter (`overlay`) to overlay the image with a other image
* Add ImageMagick support
* Reactivate the support for caption field as image title
* Default profile parameter `kirby.extension.imageext.default_profile`
* Documentation, Wiki ...

## Documentation

### Kirby configuration values

| Kirby option | Default | Values | Description |
| ------------ | ------- | ------ | ----------- |
| `kirby.extension.imageext.debug` | false | true/false | Print the internal used array for debug |
| `kirby.extension.imageext.driver` | 'gd' | 'gd','im' | Used driver for image manipulation |
| `kirby.extension.imageext.support.tag.image` | false | true/false | Activate/Deactivate the tag `image` |
| `kirby.extension.imageext.support.tag.image_gallery` | false | true/false | Activate/Deactivate the tag `image_gallery` |
| `kirby.extension.imageext.profiles` | false | {array} | Array of profiles |
| `kirby.extension.imageext.default_profile` | "none" | {string} | (not implemented) Default used profile for image manipulation |
| `kirby.extension.imageext.watermark` | false | false/{string} | (not implemented) |
| `kirby.extension.imageext.width` | false | {number} | Image width for the resize methode |
| `kirby.extension.imageext.height` | false | {number} | Image height for the resize methode |
| `kirby.extension.imageext.quality` | 90 | {number 0-100} | Output quality for the created image |
| `kirby.extension.imageext.caption_field` | false | false/{string} | File field which is used for the caption text |
| `kirby.extension.imageext.caption_top` | false | true/false | Position of the caption, top or bottom of the image |
| `kirby.extension.imageext.linkclass` | 'image-link' | {string} | Class for the link element |
| `kirby.extension.imageext.imgclass` | 'image' | {string} | Class for the img element |
| `kirby.extension.imageext.figureclass` | 'image-figure' | {string} | Class for the figure element |
| `kirby.extension.imageext.gallery.class` | 'image-gallery' | {string} | Class for the gallery element |
| `kirby.extension.imageext.gallery.prefix` | 'gallery-' | {string} |  |
| `kirby.extension.imageext.gallery.link.class` | 'fancybox' | {string} |  |
| `kirby.extension.imageext.gallery.link.attr` | 'rel' | {string} |  |
| `kirby.extension.imageext.target` | false | false/{string} | Same effect like the html target attribute |

### KirbyTag attributes

#### Image

| Option | Default | Values | Description |
| ------ | ------- | ------ | ----------- |
| driver | `gd` | {string} | You can define the used converter class. see `kirby.extension.imageext.driver` |
| profile | `none` | {string} | |
| caption_text | false | false/{string} | |
| caption_class | `image-figure` | {string} | |
| caption_top | false | true/false | |
| caption_field | false | false/{string} | |
| link_class | `image-link` | {string} | Class for the link element |
| link_target | false | false/{string} | |
| link_rel | false | | |
| link_title | false | | |
| link_url | false | | |
| image_source | false | false/{string} | |
| image_class | `image` | {string} | Class for the img element |
| image_alt | false | | |
| image_title | false | | |
| image_width | false | false/{number} | Image width for the resize methode |
| image_height | false | false/{number} | Image height for the resize methode |
| image_left | false | | |
| image_top | false | | |
| image_quality | 90 | {number 0=>100} | |
| mode | none | none/resize/crop | |
| upscale | false | true/false | |
| overwrite | false | true/false | |
| filter_blur | false | true/false/{number >0} | true = 1 pass |
| filter_grayscale | false | true/false/{number 0=>100} | true = 100, when number is used is the value of opacity |
| filter_brightness | false | false/{numerb -255=>255} | |
| filter_contrast | false | false/{numerb -100=>100} | |
| filter_colorize | false | | |
| filter_edges | false | true/false | |
| filter_emboss | false | true/false | |
| filter_invert | false | true/false | |
| filter_opacity | false | false/{number 0=>100} | |
| filter_sepia | false | true/false | |
| filter_sketch | false | true/false | |
| filter_smooth | false | false/{numerb -10=>10} | |
| filter_pixelate | false | false/{number >0} | |
| filter_overlay | false | | |
| imgclass | | | view `image_class` |
| alt | | | view `image_alt` |
| title | | | view `` |
| width | | | view `image_width` |
| height | | | view `image_height` |
| left | | | view `image_left` |
| top | | | view `image_top` |
| quality | | | view `image_quality` |
| caption | | | view `caption_text` |
| class | | | view `caption_class` |
| blur | | | view `filter_blur` |
| linkclass | | | view `link_class` |
| link | | | view `link_url` |
| target | | | view `link_target` |
| grayscale | | | view `filter_grayscale` |
| brightness | | | view `filter_brightness` |
| contrast | | | view `filter_contrast` |
| colorize | | | view `filter_colorize` |
| edges | | | view `filter_edges` |
| emboss | | | view `filter_emboss` |
| invert | | | view `filter_invert` |
| opacity | | | view `filter_opacity` |
| sepia | | | view `filter_sepia` |
| sketch | | | view `filter_sketch` |
| smooth | | | view `filter_smooth` |
| pixelate | | | view `filter_picelate` |  
| overlay | | | view `filter_overlay` |
| resize | | | (deprecated) view `mode` |
| text | | | (deprecated) view `image_alt` |
| popup | | | (deprecated) view `link_target` |

#### Gallery

On the gallery tag can you use every attribute from the image tag and the following attributes.

| Option | Default | Values | Description |
| ------ | ------- | ------ | ----------- |
| gallery | false | false/{string} | It is used as suffix for the gallery-ID. When active it will be automatic create a link to the original image. So you can use a javascript zoom library. | 

## Examples

### Simple image

```
(imageext: image.jpg [attr_name: attr_value])
```

*Output:*
```html
<img src="image01.jpg" class="image">
```

### Complex image (TODO: not working at the moment)

```
(image: image01.jpg [attr_name: attr_value])
  (srcset: image01.webp [type: {mimetype}] [media: {mediaquery}] [attr_name: attr_value])
(/image)
```

*Output:*
```html
<picture>
  <source srcset="image01.webp" type="image/webp">
  <img src="image01.jpg" class="image">
</picture>
```

### Simple gallery

```
(image_gallery: image01.jpg,image02.jpg,image03.jpg [attr_name: attr_value])
```

### Compley gallery

```
(image_gallery [attr_name: attr_value] gallery: 1)
  (image: dsc00439.jpg [attr_name: attr_value])
  (image: dsc00439.png [attr_name: attr_value])
(/image_gallery)
```

*Output:*
```html
<div class="image-gallery">
  <figure class="image-figure figcaption-bottom">
    <a href="http://{server}/{content-url}/dsc00439.jpg" class="image-link fancybox" rel="gallery-1">
      <img src="http://{server}/thumbs/dsc00439-2789dbdbbf034039f537d46f8ecb623c.jpg" class="image">
    </a>
  </figure>
  <figure class="image-figure figcaption-bottom">
    <a href="http://{server}/{content-url}/dsc00439.png" class="image-link fancybox" rel="gallery-1">
      <img src="http://{server}/thumbs/dsc00439-9c18f1a4d771b71c6b82d2d7f584c367.png" class="image">
    </a>
  </figure>
</div>
```
