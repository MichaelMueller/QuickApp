<?php

namespace Qck\App;

/**
 * App class is essentially the class to start. It is the basic error handler. No code besides the require statement and initialization should be called in any app before.
 * 
 * @author muellerm
 */
class RouteSource implements \Qck\App\Interfaces\RouteSource
{

  function __construct( array $Routes, array $ProtectedRoutes = [] )
  {
    $this->Routes = $Routes;
    $this->ProtectedRoutes = $ProtectedRoutes;
  }

  public function get()
  {
    return array_keys( $this->Routes );
  }

  public function getFqcn( $Route )
  {
    return isset( $this->Routes[ $Route ] ) ? $this->Routes[ $Route ] : null;
  }

  public function isProtected( $Route )
  {
    return in_array( $Route, $this->ProtectedRoutes );
  }

  public function getRoute( $Fqcn )
  {
    $key = array_search( $Fqcn, $this->Routes );
    return $key !== false ? $key : null;
  }

  /**
   *
   * @var array 
   */
  protected $Routes;

  /**
   *
   * @var array
   */
  protected $ProtectedRoutes;

}
