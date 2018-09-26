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

// add Qck\ResponseFactory
$ServiceRepo->addServiceFactory( Qck\App\ResponseFactory::class, function()
{
  return new Qck\App\ResponseFactory();
} );
