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

## Documentation

Look at the GitHub Wiki.

## ToDos

* Add water stamp support (`kirby.extension.imageext.watermark`) or you can use the overlay filter (`overlay`) to overlay the image with a other image
* Add ImageMagick support
* Reactivate the support for the simple gallery tag
* Upscale support
* Reactivate the support for caption field as image title
* Default profile parameter `kirby.extension.imageext.default_profile`
* Documentation, Wiki ...

## Changes

### 0.9

* Complete new written (integrate support for complex image tags like `picture`)
* New project structure for easier integration and update via git
* Default tags are `imageext` and `imageext_gallery`, but you can reactivate the support for the other tags (`kirby.extension.imageext.support.tag.image`, `kirby.extension.imageext.support.tag.image_gallery`)
* Attribute `resize` is deprecated (currently it is working), please use in the future `mode`.
* Add new Filter (`brightness`, `contrast`, `colorize`, `edges`, `emboss`, `invert`, `opacity`, `sepia`, `sketch`, `smooth`, `pixelate`)
* Add new config parameter for gallery and Javascript zoom libraries
* Add image profile support
* Currently only support for GD-Library is included. ImageMagick support will come in a later release.

### 0.7

* Add a new KirbyText tag to insert a gallery, with the same function like from the image KirbyText tag. (Initial and not complete)

### 0.6

* Option to disable `width` and `height` attribute. Good for responsive Layout design.

### 0.5

* Bugfix
* Add the new config option 'kirbytext.image.caption_field'. With this config option you can define a custom file field, what will be read for the caption of an image. Only when the config parmeter 'kirbytext.image.caption' or the parameter `caption` is 'true'. When the config parameter is true, you can selectiv deactivate it for an image. Just set the parameter `caption` to 'false'. When you write a different text into the `caption` parameter, this will be used. 

### 0.4

* Move the logic into to a plugin (static method). So you can use the function every where in Kirby (template, other KirbyTag, ...)
* Add many possible Kirby config options (I know this is not perfect, because I am using the kirby namespace. But when anyone have a idea for a better namespace. Please tell your idea. As ABAP developer I would change it to zkirbytext....)
* Optimize the logic

### 0.3

* Initial version