<?php

namespace Qck\App;

/**
 * App class is essentially the class to start. It is the basic error handler. No code besides the require statement and initialization should be called in any app before.
 * 
 * @author muellerm
 */
class Starter implements \Qck\App\Interfaces\Starter
{

  function __construct( \Qck\Interfaces\ServiceRepo $ServiceRepo )
  {
    $this->ServiceRepo = $ServiceRepo;
  }

  function exec()
  {
    try
    {
      /* @var $Request \Qck\App\Interfaces\Request */
      $Request = $this->ServiceRepo->get( \Qck\App\Interfaces\Request::class );
      if ( $Request->isCli() )
      {
        ini_set( 'display_errors', 1 );
        ini_set( 'log_errors', 0 );
      }
      /* @var $Router \Qck\App\Interfaces\Router */
      $Router = $this->ServiceRepo->get( \Qck\App\Interfaces\Router::class );
      $Controller = $Router->getController();

      $this->handleController( $Controller );
    }
    catch ( \Exception $exc )
    {
      /* @var $e \Exception */
      $ErrText = strval( $exc );

      /* @var $Request Interfaces\Mail\AdminMailer */
      $AdminMailer = $this->ServiceRepo->getOptional( Interfaces\Mail\AdminMailer::class );
      /* @var $Config \Qck\App\Interfaces\Config */
      $Config = $this->ServiceRepo->getOptional( \Qck\App\Interfaces\Config::class );
      // First step to handle the error: Mail it (if configured)
      if ( $AdminMailer )
        $AdminMailer->sendToAdmin( "Error for App " . $Config->getAppName() . " on " . $Config->getHostName(), $ErrText );
      /* @var $ErrorController \Qck\App\Interfaces\Controller */
      $ErrorController = $this->ServiceRepo->getOptional( \Qck\App\Interfaces\ErrorController::class );
      if ( $ErrorController )
      {
        $ErrorController->setErrorCode( $e->getCode() );
        $this->handleController( $ErrorController );
      }
    }
  }

  protected function handleController( \Qck\App\Interfaces\Controller $Controller )
  {
    $Response = $Controller->run( $this->ServiceRepo );
    $Output = $Response->getOutput();
    if ( $Output !== null )
    {
      /* @var $Request \Qck\App\Interfaces\Request */
      $Request = $this->ServiceRepo->get( \Qck\App\Interfaces\Request::class );
      if ( $Request->isCli() == false )
      {
        http_response_code( $Response->getExitCode() );
        header( sprintf( "Content-Type: %s; charset=%s", $Output->getContentType(), $Output->getCharset() ) );
        foreach ( $Output->getAdditionalHeaders() as $header )
          header( $header );
      }
      echo $Output->render();
    }
    exit( $Response->getExitCode() );
  }

  /**
   *
   * @var \Qck\Interfaces\ServiceRepo
   */
  protected $ServiceRepo;

}
