<?php

namespace Qck\App;

/**
 * App class is essentially the class to start. It is the basic error handler. No code besides the require statement and initialization should be called in any app before.
 * 
 * @author muellerm
 */
class Starter implements \Qck\Interfaces\App\Starter
{

  function __construct( \Qck\Interfaces\ServiceRepo $ServiceRepo )
  {
    $this->ServiceRepo = $ServiceRepo;
  }

  function run()
  {
    try
    {
      /* @var $Request \Qck\Interfaces\App\Request */
      $Request = $this->ServiceRepo->get( \Qck\Interfaces\App\Request::class );
      if ( $Request->isCli() )
      {
        ini_set( 'display_errors', 1 );
        ini_set( 'log_errors', 0 );
      }
      /* @var $Router \Qck\Interfaces\App\Router */
      $Router = $this->ServiceRepo->get( \Qck\Interfaces\App\Router::class );
      $Controller = $Router->getController();

      $this->handleController( $Controller );
    }
    catch ( \Exception $exc )
    {
      /* @var $e \Exception */
      $ErrText = strval( $exc );

      /* @var $Request Interfaces\Mail\AdminMailer */
      $AdminMailer = $this->ServiceRepo->getOptional( Interfaces\Mail\AdminMailer::class );
      /* @var $Config \Qck\Interfaces\App\Config */
      $Config = $this->ServiceRepo->getOptional( \Qck\Interfaces\App\Config::class );
      // First step to handle the error: Mail it (if configured)
      if ( $AdminMailer )
        $AdminMailer->sendToAdmin( "Error for App " . $Config->getAppName() . " on " . $Config->getHostName(), $ErrText );
      /* @var $ErrorController \Qck\Interfaces\App\Controller */
      $ErrorController = $this->ServiceRepo->getOptional( \Qck\Interfaces\App\ErrorController::class );
      if ( $ErrorController )
      {
        $ErrorController->setErrorCode( $e->getCode() );
        $this->handleController( $ErrorController );
      }
    }
  }

  protected function handleController( \Qck\Interfaces\App\Controller $Controller )
  {
    $Response = $Controller->run( $this->ServiceRepo );
    $Output = $Response->getOutput();
    if ( $Output !== null )
    {
      /* @var $Request \Qck\Interfaces\App\Request */
      $Request = $this->ServiceRepo->get( \Qck\Interfaces\App\Request::class );
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
