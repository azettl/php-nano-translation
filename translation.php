<?php

namespace com\azettl\nano;

/**
 * The php-nano-translation class replaces placeholders in a string with values from an array.
 *
 * @package  php-nano-translation
 * @author   Andreas Zettl <info@azettl.net>
 * @see      https://github.com/azettl/php-nano-translation
 */
final class translation{

  private $sBaseTranslationPath = 'translations/';
  private $sFileNamePattern     = 'translations.%s.json';


  public function __construct(string $sBaseTranslationPath = '', string $sFileNamePattern = '')
  {
    if($sBaseTranslationPath){
      $this->setBasePath($sBaseTranslationPath);
    }

    if($sFileNamePattern){
      $this->setFileNamePattern($sFileNamePattern);
    }
  }


  public function __destruct()
  {
    $this->sBaseTranslationPath = null;
    $this->sFileNamePattern     = null;
  }


  public function setBasePath(string $sBaseTranslationPath) : void
  {
    $this->sBaseTranslationPath = $sBaseTranslationPath;
  }


  public function getBasePath() : string
  {
    return $this->sBaseTranslationPath;
  }


  public function setFileNamePattern(string $sFileNamePattern) : void
  {
    $this->sFileNamePattern = $sFileNamePattern;
  }


  public function getFileNamePattern() : string
  {
    return $this->sFileNamePattern;
  }

  public function translate(string $sKey, string $sLanguage, array $aData = []) : string
  {
    $sFormattedFileName = sprintf($this->getFileNamePattern(), $sLanguage);
    $sFullFilePath      = $this->getBasePath() . $sFormattedFileName;
    
    if(!is_file($sFullFilePath)) {
      throw new \Exception('Translation file not found.');
    }

    $sTranslations = file_get_contents($sFullFilePath);
    $oTranslations = json_decode($sTranslations);

    if(!$oTranslations->$sKey){
      throw new \Exception('Translation for "' . $sKey. '" not found.');
    }
    
    if(count($aData) > 0) {
      $oTemplate = new \com\azettl\nano\template();
      $oTemplate->setTemplate($oTranslations->$sKey);
      $oTemplate->setData($aData);

      return $oTemplate->render();
    }

    return $oTranslations->$sKey;
  }
}
