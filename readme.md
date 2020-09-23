# Extension to render lazy images in markdown

This adds support to prepend image path/routes to the [league/commonmark](https://github.com/thephpleague/commonmark) package.

## Install

``` bash
composer require eberdna/commonmark-ext-prepend-image
```

## Example

``` php
use League\CommonMark\Environment;
use AndreBering\CommonMarkExtension\PrependImageExtension;

$this->environment = Environment::createCommonMarkEnvironment();
$this->environment->addExtension(new PrependImageExtension('/path/to/files/'));

$converter = new CommonMarkConverter([], $this->environment);
$html = $converter->convertToHtml('![alt text](image.jpg)');
```

This creates the following HTML

```html
<p><img src="/path/to/files/image.jpg" alt="alt text" /></p>
```

**Please note that the path is only prepended if the markdown picture path does not start with `'/'`, `'//'` or `'http'`.**

## Options

There are no options for this extension. Only base path can set when creating the instance of `PrependImageExtension`.


