<?php
use PHPUnit\Framework\TestCase;

/**
 * @covers nano
 */
final class translationTest extends TestCase
{
  public function testCanSetBasePath() : void
  {
    $oTranslation = new com\azettl\nano\translation();
    $oTranslation->setBasePath('test');

    $this->assertEquals(
      'test', 
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

  public function testCanTranslateWithVariable() : void
  {
    $oTranslation = new com\azettl\nano\translation();
    $oTranslation->setBasePath('tests/translations/');
    $oTranslation->setFileNamePattern('test.%s.json');

    $this->assertEquals(
      'My Value', 
      $oTranslation->translate('MY_KEY_WITH_VARS', 'en', ['variable' => 'test'])
    );
  }
}
