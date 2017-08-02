# php-nano-translation - Translation Engine

The php-nano-translation class gives you the correct translation from the requested JSON file.

## Installation

```cmd
composer require azettl/php-nano-translation
```

## Usage

```php
require __DIR__ . '/vendor/autoload.php';

$oTranslation = new com\azettl\nano\translation();
$oTranslation->setBasePath('vendor/azettl/php-nano-translation/tests/translations/');
$oTranslation->setFileNamePattern('test.%s.json');

echo $oTranslation->translate('MY_KEY_WITH_VARS', 'en', ['variable' => 'test']);
```

Translation Key Value: "My {variable} Value" Returns: "My test Value"