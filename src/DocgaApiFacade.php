<?php
namespace Oniti\DocgaApi;

class DocgaApiFacade extends \Illuminate\Support\Facades\Facade
{
  protected static function getFacadeAccessor()
  {
    return 'CellarS3';
  }
}
