<?php

namespace SimpleCom\AppMaker\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\DB;

class MySqlDbCommand extends Command
{
    protected $files;
	
    protected $signature = 'mysql:createdb
	                        {dbname : Database name}
                            ';
    
    protected $description = 'Create a new database';
    
    public function __construct()
    {
        parent::__construct();
    }
	
	public function handle()
    {
		//destination path
		$schemaName = strtolower($this->argument('dbname'));
		
        $charset = config("database.connections.mysql.charset",'utf8mb4');
        $collation = config("database.connections.mysql.collation",'utf8mb4_unicode_ci');
		
		$query = "CREATE DATABASE IF NOT EXISTS $schemaName CHARACTER SET $charset COLLATE $collation;";

        DB::statement($query);
		
        $this->info('Database created successfully.');
    }
	
}
