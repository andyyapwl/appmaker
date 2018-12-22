<?php

namespace SimpleCom\AppMaker\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;

class AppWebapiCommand extends Command
{
    protected $files;
    protected $signature = 'app:webapi
	                        {vendor : Vendor code}
                            {code : The code of the app.}
                            {--db-name= : Database Name.}
                            {--db-server= : Database Server}
                            {--db-admin-id= : Database Admin Id}
                            {--db-admin-password=id : Database Admin Password}
                            ';
    
    protected $description = 'Create a new backend web api.';
    
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }
	
	public function handle()
    {

		//Copy the template folder
		$source = $this->getTemplate();
		
		//destination path
		$vendor = strtolower($this->argument('vendor'));
		$code = strtolower ($this->argument('code'));
		
		$webfolder = $vendor . '.' . $code . '.' . 'backend';
		$destination = base_path() . '\\../../' . $webfolder;
		$this->makeDirectory($destination);
		
		$this->files->copyDirectory($source,$destination);
		
		//Update the .env file
		$env_path  = $destination . '\\application\\.env';
		$env_content = file_get_contents($env_path);
		$db_name = $this->option('db-name');
		$db_server = $this->option('db-server');
		$db_admin_id = $this->option('db-admin-id');
		$db_admin_password = $this->option('db-admin-password');
		
        $env_content = str_replace('DB_HOST=', 'DB_HOST=' . $db_server, $env_content);
		$env_content = str_replace('DB_DATABASE=', 'DB_DATABASE=' . $db_name, $env_content);
		$env_content = str_replace('DB_USERNAME=', 'DB_USERNAME=' . $db_admin_id, $env_content);
		$env_content = str_replace('DB_PASSWORD=', 'DB_PASSWORD=' . $db_admin_password, $env_content);
		file_put_contents($env_path, $env_content);
		
		//Create the database
		$this->appendDBConnectionNameConfig($db_server,$db_name,$db_admin_id,$db_admin_password);
		$this->call('mysql:createdb', ['dbname' => $db_name]);
		$this->call('migrate',['--database' => $db_name, '--path' => '../../' . $webfolder . '/application/database/migrations' ]);
		$this->info('App webapi created successfully.');
    }
	
	private function appendDBConnectionNameConfig($database_server,$database_name,$database_username,$database_password) {
		config(["database.connections.$database_name" => [
			"driver" => "mysql",
			"host" => $database_server,
			"port" => "3306",
			"database" => $database_name,
			"username" => $database_username,
			"password" => $database_password,
			"charset" => "utf8",
			"collation" => "utf8_unicode_ci",
			"prefix" => "",
			"strict" => true,
			"engine" => null
		]]);
	}
	
	 protected function getTemplate()
    {
        return config('appgenerator.template.webapi')
        ? config('appgenerator.path') . '/webapi'
        : __DIR__ . '/../templates/webapi';
    }
	
	protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }
        return $path;
    }
	
	#archived code
	private function writeDBConnectionNameConfig($database_server,$database_name,$database_username,$database_password) {
			$db_config_path = 'application/config/database.php';
			$db_config_content = file_get_contents($db_config_path);
			$start_block = '#appconnection';
			$end_block = '#endappconnection';
			
			//Compute the content to be appended
			$start_pos = strpos($db_config_content, $start_block) + strlen($start_block);
			$end_pos = strpos($db_config_content, $end_block) - 1;
			$config_len = $end_pos - $start_pos;
			$am_db_content = trim(substr($db_config_content,$start_pos,$config_len));
			
			//Append the new content
			$am_db_content_last_char = substr($am_db_content,-1);
			$am_db_content_start = '';
			if($am_db_content_last_char == ']')
				$am_db_content_start = ',';
			
			$new_am_db_content = $start_block . 
								$am_db_content . $am_db_content_start .
								"\n\t\t".
								'\'' . $database_name . '\' => [
								\'driver\' => \'mysql\',
								\'host\' => \'' . $database_server . '\',
								\'port\' => \'3306\',
								\'database\' => \''. $database_name . '\',
								\'username\' => \''. $database_username . '\',
								\'password\' => \''. $database_password . '\',
								\'unix_socket\' => \'\',
								\'charset\' => \'utf8mb4\',
								\'collation\' => \'utf8mb4_unicode_ci\',
								\'prefix\' => \'\',
								\'strict\' => true,
								\'engine\' => null,
							]' . "\r\n" .
							$end_block
							;
							
			//Compute the content to be replaced
			$start_am_db_to_be_replaced = strpos($db_config_content, $start_block);
			$end_am_db_to_be_replaced = strpos($db_config_content, $end_block) + strlen($end_block);
			$len_am_db = $end_am_db_to_be_replaced - $start_am_db_to_be_replaced;
			$am_db_to_be_replaced = substr($db_config_content,$start_am_db_to_be_replaced,$len_am_db);
			
			$new_db_config_content = str_replace($am_db_to_be_replaced, $new_am_db_content, $db_config_content);
			
			$myfile = fopen($db_config_path, "w");
			fwrite($myfile, $new_db_config_content);
			fclose($myfile);
	}
	#endarchivedcode

}
