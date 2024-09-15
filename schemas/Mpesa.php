<?php

namespace sprint\schemas;

use \sprint\database\schema\Schema;
use \sprint\database\schema\BluePrintSchema;

class Mpesa extends Schema
{	
    public function upgrade()
    {
        $this->run("mpesa", function(BluePrintSchema $table)
        {
			$table->int("id")->autoIncreament()->primaryKey();

			$table->varchar("api_key")->unique();

			$table->varchar("public_key")->unique();
			
			$table->int("production_mode", 1, 0);

			$table->dateTime("created_at","CURRENT_TIMESTAMP");

			$table->dateTime("updated_at");

			$table->create();
		});
    }
    
    public function downgrade()
    {
        
    }
}