<?php 

namespace FrieseNiels\Base;

use Illuminate\Support\Facades\Validator;

use Illuminate\Routing\Router;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\BaseServiceProvider;

class BaseServiceProvider extends BaseServiceProvider
{
	protected $commands = [
		'FrieseNiels\Base\Admin\Console\MakeAdminCommand',
		'FrieseNiels\Base\Admin\Console\RolesSeeder'
	];

	public function boot( Router $router)
	{
		$this->loadRoutesFrom(__DIR__.'/router.php');
		$router->middleware(
			'auth.admin',
			'App\Http\Middleware\AuthenticateAdmin'
		);
	}

	public function register()
	{
		$this->commands( $this->commands );

		$this->app->register(\Artesoas\Defender\Providers\DefenderServiceProvider::class);

		//Create aliases
		$loader = AliasLoader::getInstance();
		$loader->alias('Defender', 
			\Artesoas\Defender\Facades\Defender::class
		);
	}

	public function provides()
	{
		return ['laravel-admin'];
	}
}
