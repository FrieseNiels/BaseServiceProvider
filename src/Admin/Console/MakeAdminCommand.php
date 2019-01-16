<?php 

namespace FrieseNiels\Admin\Console;

use Hash;
use DirectoryIterator;

use Illuminate\Routing\Router;
use Illuminate\Console\Command;

use DB;

use Artesaos\Defender\Facades\Defender;

class MakeAdminCommand extends Command
{
	use InstallPackages, CreatePackage, EditPackage;

	protected $signature = 'packages {action: The action you want to do, [create-package or install]}';

	
	protected $description = 'Use this plugin to make the basics of your application.';

	protected $permissionsTable = 'permissions';
	protected $usersTable = 'users';
	protected $roleUserTable = 'role_user';
	protected $roleTable = 'roles';
	protected $permissionsRoleTable = 'permission_role';
	// SuperRole
	protected $superRole = 'Admin';
	protected $permissionIdentifier = 'name';
	protected $permissionReadableName = 'readable_name';


	protected $usersIdentifier = 'email';
	protected $usersPassword = 'password';

	protected $adminEmail = 'admin@localhost';
	protected $adminPassword = 'admin';

	/**
	* All the pages the admin can access.
	* uses all the options from $options var
	*
	*/ 

	protected $packageInfo = [];

	protected $pages = [];

	protected $custom = [];

	protected $commands = [];




	protected $exclude = ['vendor', 'storage', 'config'];

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire(Router $router)
	{


		if($this->argument('action') == 'create') {
			$this->create();
		}else {
			$this->line('Could not find action, try: create, edit or install');
		}

	}


	public function create()
	{
		\Artisan::call("vendor:publish --provider='Artesaos\Defender\Providers\DefenderServiceProvider'");
	}
}