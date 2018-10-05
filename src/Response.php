<?php

namespace Qck\App;

/**
 *
 * @author muellerm
 */
class Response implements \Qck\App\Interfaces\Response, Interfaces\ResponseGuard
{

  function getExitCode()
  {
    return $this->ExitCode;
  }

  function getOutput()
  {
    return $this->Output;
  }

  public function getResponse( \Qck\App\Interfaces\Output $Output = null,
                               $ExitCode = \Qck\App\Interfaces\Response::EXIT_CODE_OK )
  {
    $this->ExitCode = $ExitCode;
    $this->Output = $Output;
    return $this;
  }

  /**
   *
   * @var mixed string or Template 
   */
  protected $ExitCode;

  /**
   *
   * @var \Qck\App\Interfaces\Output
   */
  protected $Output;

}
