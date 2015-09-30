# 1.0.0

* Figure caption, link title, img title, img alt can have a field of file or page as source. `{file-field}` as content to the attributes. In the next release it will be possible to use `{page-field}`. And you can use this placeholder with static text.
* Add support for `gallery` and `image` snippet. Example snippet are in the subdirectory of this plugin.
* Add licence file

# 0.9.3

* Bugfix: Correct blur bug
* Bugfix: Upscale issue

# 0.9.2

* Bugfixes
* Add ImageExt::getThumb method to easy create images

# 0.9.1

* Moved documentation from GitHub wiki to README.md
* Moved Changelog from README.md to CHANGELOG.md
* Bugfix: #8 ImageExt create on every request for a image, a new image
* Support javascript zoom gallery feature
* Reactivate the support for the simple gallery tag

# 0.9

* Complete new written (integrate support for complex image tags like `picture`)
* New project structure for easier integration and update via git
* Default tags are `imageext` and `imageext_gallery`, but you can reactivate the support for the other tags (`kirby.extension.imageext.support.tag.image`, `kirby.extension.imageext.support.tag.image_gallery`)
* Attribute `resize` is deprecated (currently it is working), please use in the future `mode`.
* Add new Filter (`brightness`, `contrast`, `colorize`, `edges`, `emboss`, `invert`, `opacity`, `sepia`, `sketch`, `smooth`, `pixelate`)
* Add new config parameter for gallery and Javascript zoom libraries
* Add image profile support
* Currently only support for GD-Library is included. ImageMagick support will come in a later release.

# 0.7

* Add a new KirbyText tag to insert a gallery, with the same function like from the image KirbyText tag. (Initial and not complete)

# 0.6

* Option to disable `width` and `height` attribute. Good for responsive Layout design.

# 0.5

* Bugfix
* Add the new config option 'kirbytext.image.caption_field'. With this config option you can define a custom file field, what will be read for the caption of an image. Only when the config parmeter 'kirbytext.image.caption' or the parameter `caption` is 'true'. When the config parameter is true, you can selectiv deactivate it for an image. Just set the parameter `caption` to 'false'. When you write a different text into the `caption` parameter, this will be used. 

# 0.4

* Move the logic into to a plugin (static method). So you can use the function every where in Kirby (template, other KirbyTag, ...)
* Add many possible Kirby config options (I know this is not perfect, because I am using the kirby namespace. But when anyone have a idea for a better namespace. Please tell your idea. As ABAP developer I would change it to zkirbytext....)
* Optimize the logic

# 0.3

* Initial version