<?php

namespace Qck\App;

/**
 * The Router gets the currently selected controller of the application
 *
 * @author muellerm
 */
class Router implements \Qck\App\Interfaces\Router
{

  const DEFAULT_QUERY = "Start";
  const DEFAULT_QUERY_KEY = "q";

  function __construct( \Qck\App\Interfaces\Request $Request,
                        \Qck\App\Interfaces\RouteSource $RouteSource )
  {
    $this->Request = $Request;
    $this->RouteSource = $RouteSource;

    $this->DefaultQuery = self::DEFAULT_QUERY;
    $this->QueryKey = self::DEFAULT_QUERY_KEY;
  }

  function addController( $Query, $ControllerFqcn )
  {
    $this->ControllerFqcns[ $Query ] = $ControllerFqcn;
  }

  function setQueryKey( $QueryKey )
  {
    $this->QueryKey = $QueryKey;
  }

  function getDefaultQuery()
  {
    return $this->DefaultQuery;
  }

  function setDefaultQuery( $DefaultQuery )
  {
    $this->DefaultQuery = $DefaultQuery;
  }

  public function getController()
  {
    static $controller = null;
    if ( is_null( $controller ) )
    {
      $fqcn = $this->getCurrentControllerFqcn();
      if ( $fqcn )
        $controller = new $fqcn;
    }
    return $controller;
  }

  public function getCurrentControllerFqcn()
  {
    static $controllerFqcn = null;
    if ( is_null( $controllerFqcn ) )
    {
      /* @var $Request Interfaces\Request */
      $Request = $this->Request;
      $className = $Request->get( $this->QueryKey, $this->DefaultQuery );
      $controllerFqcn = isset( $this->ControllerFqcns[ $className ] ) ? $this->ControllerFqcns[ $className ] : null;
    }
    return $controllerFqcn;
  }

  public function getLink( $ControllerFqcn, $args = array () )
  {
    $query = $this->RouteSource->getRoute( $ControllerFqcn );

    $link = "?" . $this->QueryKey . "=" . $query;

    if ( is_array( $args ) )
    {
      foreach ( $args as $key => $value )
        $link .= "&" . $key . "=" . (urlencode( $value ));
    }
    return $link;
  }

  public function redirect( $ControllerFqcn, $args = array () )
  {
    $Link = $this->getLink( $ControllerFqcn, $args );
    header( "Location: " . $Link );
  }

  public function getCurrentRoute()
  {
    static $CurrentRoute = null;
    if ( !$CurrentRoute )
      $CurrentRoute = $this->Request->get( $this->QueryKey, $this->DefaultQuery );
    return $CurrentRoute;
  }

  public function setDefaultRoute( $DefaultRoute = self::DEFAULT_ROUTE )
  {
    $this->DefaultQuery = $DefaultRoute;
  }

  public function setRouteKey( $RouteKey )
  {
    $this->QueryKey = $RouteKey;
  }

  /**
   *
   * @var \Qck\App\Interfaces\Request
   */
  protected $Request;

  /**
   *
   * @var \Qck\App\Interfaces\RouteSource
   */
  protected $RouteSource;

  /**
   *
   * @var array 
   */
  protected $ControllerFqcns;

  /**
   *
   * @var string
   */
  protected $QueryKey = "q";

  /**
   *
   * @var string
   */
  protected $DefaultQuery = "Start";

}
