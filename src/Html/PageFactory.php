<?php

namespace Qck\App\Html;

/**
 * App class is essentially the class to start. It is the basic error handler. No code besides the require statement and initialization should be called in any app before.
 * 
 * @author muellerm
 */
class PageFactory implements \Qck\App\Interfaces\Html\PageFactory
{

  public function create( $Title, $BodyTemplateOrText,
                          \Qck\App\Interfaces\LanguageProvider $LanguageProvider = null )
  {
    return new Page( $Title, $BodyTemplateOrText, $LanguageProvider );
  }
}
