<?php

/* @var $ServiceRepo Qck\ServiceRepo */
$ServiceRepo = Qck\ServiceRepo::getInstance();

// ADD SERVICES
// add Qck\App
$ServiceRepo->addServiceFactory( Qck\App\Starter::class, function() use($ServiceRepo)
{
  return new Qck\App\Starter( $ServiceRepo );
} );

// add Qck\Request
$ServiceRepo->addServiceFactory( Qck\App\Request::class, function()
{
  return new Qck\App\Request();
} );

// add Qck\Router
$ServiceRepo->addServiceFactory( Qck\App\Router::class, function() use($ServiceRepo)
{
  return new Qck\App\Router( $ServiceRepo->get( Qck\App\Interfaces\Request::class ), $ServiceRepo->get( Qck\App\Interfaces\RouteSource::class ) );
} );

// add Qck\Html\PageFactory
$ServiceRepo->addServiceFactory( Qck\App\Html\PageFactory::class, function()
{
  return new Qck\App\Html\PageFactory();
} );

// add \Qck\App\Response
$ServiceRepo->addServiceFactory( \Qck\App\Response::class, function()
{
  return new \Qck\App\Response();
} );


