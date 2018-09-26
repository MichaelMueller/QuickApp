<?php

/* @var $ServiceRepo Qck\ServiceRepo */
$ServiceRepo = Qck\ServiceRepo::getInstance();

// ADD SERVICES
// add Qck\App
$ServiceRepo->addServiceFactory( Qck\App::class, function() use($ServiceRepo)
{
  return new Qck\App( $ServiceRepo );
} );

// add Qck\Request
$ServiceRepo->addServiceFactory( Qck\Request::class, function()
{
  return new Qck\Request();
} );

// add Qck\ResponseFactory
$ServiceRepo->addServiceFactory( Qck\ResponseFactory::class, function()
{
  return new Qck\ResponseFactory();
} );
