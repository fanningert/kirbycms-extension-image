# KirbyText Extension - Image

*Version:* 0.7

This extended version of the original KirbyTag image function replace the original.

## ToDos

* Make the overwrite of the original KirbyTag as an Option.
* Upscale function

## Changes

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

## Options for KirbyTag - Image

| Option | Default | Values | Description |
| ------ | ------- | ------ | ----------- |
| width | empty | {number} | Image width for the resize methode |
| height | empty | {number} | Image height for the resize methode |
| width_output | false | true/false | Activate or Deactivate the width attribute output |
| height_output | false | true/false | Activate or Deactivate the height attribute output |
| alt | false | false/{string} | |
| text | false | false/{string} | Fallback for `alt` |
| title | false | false/{string} | |
| class | empty| {string} | Class for the figure element |
| imgclass | empty | {string} | Class for the img element |
| linkclass | empty | {string} | Class for the link element |
| caption | false | true/false/{string} | Caption from file field active (true/false) or a caption string |
| caption_field | false | false/{fieldname} | File field which is used for the caption text |
| caption_top | false | true/false | Position of the caption, top or bottom of the image |
| link | empty | {string} | |
| target | empty | {string} | Same effect like the html target attribute |
| popup | empty | {string} | Fallback for `target` |
| rel | empty | {string} | |
| resize | false | false/resize/crop | Image resize methode |
| quality | 100 | 1-100 | Quality of the result |
| blur | false | true/false | Blurs the image using the Gaussian method |
| upscale | false | true/false | Upscale the image (inprogress) |
| grayscale | false | true/false | Converts the image into grayscale |

## Options for KirbyTag - ImageGallery

| Option | Default | Values | Description |
| ------ | ------- | ------ | ----------- |
| width | empty | {number} | Image width for the resize methode |
| height | empty | {number} | Image height for the resize methode |
| width_output | false | true/false | Activate or Deactivate the width attribute output |
| height_output | false | true/false | Activate or Deactivate the height attribute output |
| galleryclass | empty | {string} | Class for the gallery element |
| imgclass | empty | {string} | Class for the img element |
| linkclass | empty | {string} | Class for the link element |
| caption | false | true/false/{string} | Caption from file field active (true/false) or a caption string |
| caption_field | false | false/{fieldname} | File field which is used for the caption text |
| caption_top | false | true/false | Position of the caption, top or bottom of the image |
| link | empty | {string} | |
| resize | false | false/resize/crop | Image resize methode |
| quality | 100 | 1-100 | Quality of the result |
| blur | false | true/false | Blurs the image using the Gaussian method |
| upscale | false | true/false | Upscale the image (inprogress) |
| grayscale | false | true/false | Converts the image into grayscale |

## Config Options

| Kirby option | Default | Values | Description |
| ------------ | ------- | ------ | ----------- |
| kirbytext.image.width | empty   | {number} | Default width for an image |
| kirbytext.image.height | empty   | {number} | Default height for an image |
| kirbytext.image.width_output | false | true/false | Activate or Deactivate the width attribute outpute |
| kirbytext.image.height_output | false | true/false | Activate or Deactivate the height attribute output |
| kirbytext.image.figureclass | 'image' | {string} | Default class for the figure element |
| kirbytext.image.imgclass | empty | {string} | Default class for the img element |
| kirbytext.image.linkclass | empty | {string} | Default class for the link element |
| kirbytext.image.caption | 'false' | true/false/{string} | Caption active (true/false) or a default caption |
| kirbytext.image.caption_top | 'false' | true/false | Position of the caption, top or bottom of the image |
| kirbytext.image.caption_field | 'false' | false/{fieldname} | File field which is used for the caption text. |
| kirbytext.image.target | empty | {string} | Same effect like the html target attribute |
| kirbytext.image.resize | 'false' | false/resize/crop | Image resize methode |
| kirbytext.image.quality | 100 | 1-100% | Qualitiy of the result |
| kirbytext.image.blur | 'false' | true/false | Blur filter |
| kirbytext.image.upscale | 'false' | true/false | Upscale image |
| kirbytext.image.grayscale | 'false' | true/false | Grayscale filter |

## Examples

### Simple

```
(image: dsc00439.jpg width: 200)
```

### Resize

```
(image: dsc00439.jpg resize: resize width: 200 height: 200)
```

```
(image: dsc00439.jpg resize: resize width: 200)
```

### Crop

```
(image: dsc00439.jpg resize: crop width: 200 height: 200)
```

### Blur

```
(image: dsc00439.jpg resize: resize width: 200 blur: true)
```

### Grayscale

```
(image: dsc00439.jpg resize: resize width: 200 grayscale: true)
```

### Upscale (not working at the moment)

```
(image: dsc00439_small.jpg resize: resize width: 200 upscale: true)
```

### Caption

#### Caption at the bottom

```
(image: dsc00439.jpg resize: resize width: 200 caption: Test)
```

#### Caption at the top

```
(image: dsc00439.jpg resize: resize width: 200 caption: Test caption_top: true)
```