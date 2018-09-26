<?php

namespace Qck\App;

/**
 *
 * @author muellerm
 */
class ResponseFactory implements \Qck\Interfaces\App\ResponseFactory
{

  public function create( \Qck\Interfaces\App\Output $Output = null,
                          $ExitCode = \Qck\Interfaces\App\Response::EXIT_CODE_OK )
  {
    return new Response( $Output, $ExitCode );
  }
}
