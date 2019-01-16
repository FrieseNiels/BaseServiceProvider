<?php 

namespace FrieseNiels\Base\Templates;

class Route extends \Illuminate\Support\Facades\Route
{
	/**
	* Get the registered name of the component.
	*
	* @return string
	*/

    public static function crud($baseRoute, $controllerRoute, $prefix, $shield = 'user', array $extra_shield = [])  {

        Route::group(['prefix' => $prefix], function() use ($baseRoute, $controllerRoute, $shield, $extra_shield) {
    		self::get( '/', [
                'as' => $baseRoute . '.index',
                'uses' => $controllerRoute . '@index',
                'shield' => array_merge($extra_shield, [ $shield . '.view' ])
            ]);
         	self::get( '/create', [
                'as' => $baseRoute . '.create',
                'uses' => $controllerRoute . '@create',
                'shield' => array_merge($extra_shield, [  $shield .'.create' ])
            ]);
            self::get( '/search', [
                'as' => $baseRoute . '.search',
                'uses' => $controllerRoute . '@search',
                'shield' => array_merge($extra_shield, [  $shield .'.view' ])
            ]);

            self::post( '/data', [
                'as' => $baseRoute . '.data',
                'uses' => $controllerRoute . '@anyData',
                'shield' => array_merge($extra_shield, [  $shield .'.view' ])
            ]);

            self::post( '/create', [
                'as' => $baseRoute . '.store',
                'uses' => $controllerRoute . '@store',
                'shield' => array_merge($extra_shield, [  $shield .'.create' ])
            ]);
            self::get( '/edit/{id}', [
                'as' => $baseRoute . '.edit',
                'uses' => $controllerRoute . '@edit',
                'shield' => array_merge($extra_shield, [  $shield .'.edit' ])
            ]);
            self::post( '/edit/{id}', [
                'as' => $baseRoute . '.update',
                'uses' => $controllerRoute . '@update',
                'shield' => array_merge($extra_shield, [  $shield .'.edit' ])
            ]);
            self::get( '/delete/{id}', [
                'as' => $baseRoute . '.delete',
                'uses' => $controllerRoute . '@destroy',
                'shield' => array_merge($extra_shield, [  $shield .'.delete' ])
            ]);
    	});
    }

    public static function apiCrud($baseRoute, $controllerRoute, $prefix, $shield = 'user', array $extra_shield = [])  {

        Route::group(['prefix' => $prefix], function() use ($baseRoute, $controllerRoute, $shield, $extra_shield) {

            self::get( '/all', [
                'as' => $baseRoute . '.all',
                'uses' => $controllerRoute . '@all',
                'shield' => array_merge($extra_shield, [  $shield .'.view' ])
            ]);
            self::get( '/search', [
                'as' => $baseRoute . '.search',
                'uses' => $controllerRoute . '@search',
                'shield' => array_merge($extra_shield, [  $shield .'.view' ])
            ]);

            self::post( '/create', [
                'as' => $baseRoute . '.store',
                'uses' => $controllerRoute . '@store',
                'shield' => array_merge($extra_shield, [  $shield .'.create' ])
            ]);
            self::get( '/show/{id}', [
                'as' => $baseRoute . '.show',
                'uses' => $controllerRoute . '@edit',
                'shield' => array_merge($extra_shield, [  $shield .'.edit' ])
            ]);
           
            self::post( '/edit/{id}', [
                'as' => $baseRoute . '.update',
                'uses' => $controllerRoute . '@update',
                'shield' => array_merge($extra_shield, [  $shield .'.edit' ])
            ]);
            self::get( '/delete/{id}', [
                'as' => $baseRoute . '.delete',
                'uses' => $controllerRoute . '@destroy',
                'shield' => array_merge($extra_shield, [  $shield .'.delete' ])
            ]);
        });
    }
}