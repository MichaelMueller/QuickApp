<?php

namespace Qck\App\Html;

/**
 * App class is essentially the class to start. It is the basic error handler. No code besides the require statement and initialization should be called in any app before.
 * 
 * @author muellerm
 */
class TemplateFactory implements \Qck\App\Interfaces\Html\TemplateFactory
{
  public function createLoginForm( $Action,
                                   \Qck\App\Interfaces\Html\Template $UsernameInputField,
                                   \Qck\App\Interfaces\Html\Template $PasswordInputField )
  {
    return null;
  }
}
