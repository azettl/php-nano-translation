<?php

namespace com\azettl\nano;

/**
 * The php-nano-translation class gives you the correct translation from the requested JSON file.
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
    if(strrpos($sBaseTranslationPath, '/') != strlen($sBaseTranslationPath)) {
      $sBaseTranslationPath .= '/';
    }

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
    $this->checkJSON();

    if(!$oTranslations->$sKey){
      throw new \Exception('Translation for "' . $sKey. '" not found.');
    }
    
    if(count($aData) > 0) {
      if (!class_exists('\com\azettl\nano\template')) {
        throw new \Exception('The class \com\azettl\nano\template is missing.');
      }
      $oTemplate = new \com\azettl\nano\template();
      $oTemplate->setTemplate($oTranslations->$sKey);
      $oTemplate->setData($aData);

      return $oTemplate->render();
    }

    return $oTranslations->$sKey;
  }

  private function checkJSON()
  {
    switch(json_last_error()) {
      case JSON_ERROR_NONE:
        // Valid JSON
        break;
      case JSON_ERROR_DEPTH:
        throw new \Exception('JSON: Maximum stack depth exceeded');
      case JSON_ERROR_STATE_MISMATCH:
        throw new \Exception('JSON: Underflow or the modes mismatch');
      case JSON_ERROR_CTRL_CHAR:
        throw new \Exception('JSON: Unexpected control character found');
      case JSON_ERROR_SYNTAX:
        throw new \Exception('JSON: Syntax error, malformed JSON');
      case JSON_ERROR_UTF8:
        throw new \Exception('JSON: Malformed UTF-8 characters, possibly incorrectly encoded');
      default:
        throw new \Exception('JSON: Unknown error');
    }
  }
}