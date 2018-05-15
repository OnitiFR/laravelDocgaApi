<?php 

namespace Oniti\DocgaApi;

use Illuminate\Support\ServiceProvider;
use App;
use Illuminate\Foundation\AliasLoader;

class DocgaApiServiceProvider extends ServiceProvider{
 
 
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
 
    public function boot(){
        $loader = AliasLoader::getInstance();
        $loader->alias('DocgaApi', \Oniti\DocgaApi\DocgaApiFacade::class);
    }
 
    public function register() {
        App::bind('DocgaApi', function()
        {
            return new \Oniti\DocgaApi\DocgaApi;
        });
    }
 
}