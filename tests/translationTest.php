<?php
use PHPUnit\Framework\TestCase;

/**
 * @covers \com\azettl\nano\translation
 */
final class translationTest extends TestCase
{

  public function testCanSetBasePath() : void
  {
    $oTranslation = new com\azettl\nano\translation();
    $oTranslation->setBasePath('test');

    $this->assertEquals(
      'test/', 
      $oTranslation->getBasePath()
    );
  }

  public function testCanSetFileNamePattern() : void
  {
    $oTranslation = new com\azettl\nano\translation();
    $oTranslation->setFileNamePattern('test');

    $this->assertEquals(
      'test', 
      $oTranslation->getFileNamePattern()
    );
  }

  public function testCanTranslate() : void
  {
    $oTranslation = new com\azettl\nano\translation();
    $oTranslation->setBasePath('tests/translations/');
    $oTranslation->setFileNamePattern('test.%s.json');

    $this->assertEquals(
      'My Value', 
      $oTranslation->translate('MY_KEY', 'en')
    );
  }

  public function testCanTranslateWrongKey() : void
  {
    $this->expectException(Exception::class);
    $oTranslation = new com\azettl\nano\translation();
    $oTranslation->setBasePath('tests/translations/');
    $oTranslation->setFileNamePattern('test.%s.json');

    $this->assertEquals(
      'My Value', 
      $oTranslation->translate('MY_WRONG_KEY', 'en')
    );
  }

  public function testCanTranslateWithVariable() : void
  {
    $this->expectException(Exception::class);
    $oTranslation = new com\azettl\nano\translation();
    $oTranslation->setBasePath('tests/translations/');
    $oTranslation->setFileNamePattern('test.%s.json');

    $this->assertEquals(
      'My Value', 
      $oTranslation->translate('MY_KEY_WITH_VARS', 'en', ['variable' => 'test'])
    );
  }

  public function testCanTranslateWithWrongFilePath() : void
  {
    $this->expectException(Exception::class);
    $oTranslation = new com\azettl\nano\translation();
    $oTranslation->setBasePath('tests/translationsWrong/');
    $oTranslation->setFileNamePattern('test.%s.json');

    $this->assertEquals(
      'My Value', 
      $oTranslation->translate('MY_KEY', 'en')
    );
  }

  public function testCanTranslateWithFilePathWithoutSlash() : void
  {
    $oTranslation = new com\azettl\nano\translation();
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
    $oTranslation = new com\azettl\nano\translation();
    $oTranslation->setBasePath('tests/translations/');
    $oTranslation->setFileNamePattern('test.%s.jsonWrong');

    $this->assertEquals(
      'My Value', 
      $oTranslation->translate('MY_KEY', 'en')
    );
  }

  public function testCanTranslateWithInvalidJSON() : void
  {
    $this->expectException(Exception::class);
    $oTranslation = new com\azettl\nano\translation();
    $oTranslation->setBasePath('tests/translations/');
    $oTranslation->setFileNamePattern('test.%s.json');

    $this->assertEquals(
      'My Value', 
      $oTranslation->translate('MY_KEY', 'enInvalidJSON')
    );
  }
}
