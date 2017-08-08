<?php
use PHPUnit\Framework\TestCase;
use com\azettl\nano\translation;

final class translationTest extends TestCase
{

  public function testCanSetBasePath() : void
  {
    $oTranslation = new translation();
    $oTranslation->setBasePath('test');

    $this->assertEquals(
      'test/', 
      $oTranslation->getBasePath()
    );
  }

  public function testCanSetFileNamePattern() : void
  {
    $oTranslation = new translation();
    $oTranslation->setFileNamePattern('test');

    $this->assertEquals(
      'test', 
      $oTranslation->getFileNamePattern()
    );
  }

  public function testCanTranslate() : void
  {
    $oTranslation = new translation();
    $oTranslation->setBasePath('tests/translations/');
    $oTranslation->setFileNamePattern('test.%s.json');

    $this->assertEquals(
      'My Value', 
      $oTranslation->translate('MY_KEY', 'en')
    );
  }

  public function testCanTranslateWithConstruct() : void
  {
    $oTranslation = new translation('tests/translations/', 'test.%s.json');

    $this->assertEquals(
      'My Value', 
      $oTranslation->translate('MY_KEY', 'en')
    );
  }

  public function testCanTranslateWrongKey() : void
  {
    $this->expectException(Exception::class);
    $oTranslation = new translation();
    $oTranslation->setBasePath('tests/translations/');
    $oTranslation->setFileNamePattern('test.%s.json');

    $this->assertEquals(
      'My Value', 
      $oTranslation->translate('MY_WRONG_KEY', 'en')
    );
  }

  public function testCanTranslateWithVariableWithoutVendor() : void
  {
    $this->expectException(Exception::class);
    $oTranslation = new translation();
    $oTranslation->setBasePath('tests/translations/');
    $oTranslation->setFileNamePattern('test.%s.json');

    $this->assertEquals(
      'My test Value', 
      $oTranslation->translate('MY_KEY_WITH_VARS', 'en', ['variable' => 'test'])
    );
  }

  public function testCanTranslateWithVariable() : void
  {
    $oTranslation = new translation();
    $oTranslation->setBasePath('tests/translations/');
    $oTranslation->setFileNamePattern('test.%s.json');

    if(is_file('vendor/autoload.php')) {
      require_once 'vendor/autoload.php';
    } else {
      $this->expectException(Exception::class);
    }

    $this->assertEquals(
      'My test Value', 
      $oTranslation->translate('MY_KEY_WITH_VARS', 'en', ['variable' => 'test'])
    );
  }

  public function testCanTranslateWithWrongFilePath() : void
  {
    $this->expectException(Exception::class);
    $oTranslation = new translation();
    $oTranslation->setBasePath('tests/translationsWrong/');
    $oTranslation->setFileNamePattern('test.%s.json');

    $this->assertEquals(
      'My Value', 
      $oTranslation->translate('MY_KEY', 'en')
    );
  }

  public function testCanTranslateWithFilePathWithoutSlash() : void
  {
    $oTranslation = new translation();
    $oTranslation->setBasePath('tests/translations');
    $oTranslation->setFileNamePattern('test.%s.json');

    $this->assertEquals(
      'My Value', 
      $oTranslation->translate('MY_KEY', 'en')
    );
  }

  public function testCanTranslateWithWrongFileName() : void
  {
    $this->expectException(Exception::class);
    $oTranslation = new translation();
    $oTranslation->setBasePath('tests/translations/');
    $oTranslation->setFileNamePattern('test.%s.jsonWrong');

    $this->assertEquals(
      'My Value', 
      $oTranslation->translate('MY_KEY', 'en')
    );
  }

  public function testCanTranslateWithInvalidJSON_ERROR_SYNTAX() : void
  {
    $this->expectException(Exception::class);
    $oTranslation = new translation();
    $oTranslation->setBasePath('tests/translations/');
    $oTranslation->setFileNamePattern('test.%s.json');

    $this->assertEquals(
      'My Value', 
      $oTranslation->translate('MY_KEY', 'enJSON_ERROR_SYNTAX')
    );
  }
}
