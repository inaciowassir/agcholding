<?php

namespace sprint\schemas;

use \sprint\database\schema\Schema;
use \sprint\database\schema\BluePrintSchema;

class Location extends Schema
{	
    public function upgrade()
    {
        $this->run("provinces", function(BluePrintSchema $table)
        {
			$table->int("id")->autoIncreament()->primaryKey();

			$table->varchar("name");
			
			$table->int("status", 1, 0);

			$table->dateTime("created_at","CURRENT_TIMESTAMP");

			$table->dateTime("updated_at");

			$table->create();
		});
		
        $this->run("districts", function(BluePrintSchema $table)
        {
			$table->int("id")->autoIncreament()->primaryKey();

			$table->varchar("name");
			
			$table->int("province_id", 1, 0);
			
			$table->int("status", 1, 0);

			$table->dateTime("created_at","CURRENT_TIMESTAMP");

			$table->dateTime("updated_at");

			$table->create();
		});
		
        $this->run("administrative_posts", function(BluePrintSchema $table)
        {
			$table->int("id")->autoIncreament()->primaryKey();

			$table->varchar("name");
			
			$table->int("district_id", 1, 0);
			
			$table->int("status", 1, 0);

			$table->dateTime("created_at","CURRENT_TIMESTAMP");

			$table->dateTime("updated_at");

			$table->create();
		});
    }
    
    public function downgrade()
    {
        
    }
}