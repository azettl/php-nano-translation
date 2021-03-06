# php-nano-translation - Translation Engine

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/95fe44713833430bb751f807488c0513)](https://www.codacy.com/app/azettl/php-nano-translation?utm_source=github.com&utm_medium=referral&utm_content=azettl/php-nano-translation&utm_campaign=badger)
[![Codacy Badge](https://api.codacy.com/project/badge/Coverage/95fe44713833430bb751f807488c0513)](https://www.codacy.com/app/azettl/php-nano-translation?utm_source=github.com&utm_medium=referral&utm_content=azettl/php-nano-translation&utm_campaign=Badge_Coverage)

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
