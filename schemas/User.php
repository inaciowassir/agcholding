<?php

namespace sprint\schemas;

use \sprint\database\schema\Schema;
use \sprint\database\schema\BluePrintSchema;

class User extends Schema
{	
    public function upgrade()
    {
        $this->run("users", function(BluePrintSchema $table)
        {
			$table->int("id")->autoIncreament()->primaryKey();

			$table->varchar("name");
			
			$table->varchar("username");

			$table->varchar("email");
			
			$table->varchar("phone_number");

			$table->text("password");
			
			$table->int("profile_id", 2, 0);
			
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