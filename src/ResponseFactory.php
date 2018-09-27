<?php

namespace Qck\App;

/**
 *
 * @author muellerm
 */
class ResponseFactory implements \Qck\App\Interfaces\ResponseFactory
{

  public function create( \Qck\App\Interfaces\Output $Output = null,
                          $ExitCode = \Qck\App\Interfaces\Response::EXIT_CODE_OK )
  {
    return new Response( $Output, $ExitCode );
  }
}
