<?php

namespace Qck\App;

/**
 *
 * @author muellerm
 */
class Response implements \Qck\App\Interfaces\Response
{

  function __construct( \Qck\App\Interfaces\Output $Output = null,
                        $ExitCode = \Qck\App\Interfaces\Response::EXIT_CODE_OK )
  {
    $this->ExitCode = $ExitCode;
    $this->Output = $Output;
  }

  function getExitCode()
  {
    return $this->ExitCode;
  }

  function getOutput()
  {
    return $this->Output;
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
