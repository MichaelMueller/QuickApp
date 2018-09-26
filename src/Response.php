<?php

namespace Qck;

/**
 *
 * @author muellerm
 */
class Response implements \Qck\Interfaces\App\Response
{

  function __construct( \Qck\Interfaces\App\Output $Output = null,
                        $ExitCode = \Qck\Interfaces\App\Response::EXIT_CODE_OK )
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

  public function setExitCode( $ExitCode )
  {
    $this->ExitCode = $ExitCode;
  }

  public function setOutput( Interfaces\Output $Output )
  {
    $this->Output = $Output;
  }

  /**
   *
   * @var mixed string or Template 
   */
  protected $ExitCode;

  /**
   *
   * @var \Qck\Interfaces\App\Output
   */
  protected $Output;

}
