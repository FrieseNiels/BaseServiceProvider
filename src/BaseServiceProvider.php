<?php 

namespace FrieseNiels\Base;

use Illuminate\Support\Facades\Validator;

use Illuminate\Routing\Router;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Provider;

class BaseServiceProvider extends Provider
{
	protected $commands = [
		'FrieseNiels\Base\Admin\Console\MakeAdminCommand',
		'FrieseNiels\Base\Admin\Console\RolesSeeder'
	];

	public function boot( Router $router)
	{
		//$this->loadRoutesFrom(__DIR__.'/router.php');
		$router->middleware(
			'auth.admin',
			'App\Http\Middleware\AuthenticateAdmin'
		);
	}

	public function register()
	{
		$this->commands( $this->commands );

		$this->app->register(\Artesaos\Defender\Providers\DefenderServiceProvider::class);

		//Create aliases
		$loader = AliasLoader::getInstance();
		$loader->alias('Defender', 
			\Artesaos\Defender\Facades\Defender::class
		);
	}

	public function provides()
	{
		return ['laravel-admin'];
	}
}
