<?php

namespace sprint\schemas;

use \sprint\database\schema\Schema;
use \sprint\database\schema\BluePrintSchema;

class Token extends Schema
{	
    public function upgrade()
    {
        $this->run("tokens", function(BluePrintSchema $table)
        {
			$table->int("id")->autoIncreament()->primaryKey();

			$table->varchar("mobile_number");
			
			$table->varchar("transaction_token")->unique();
			
			$table->int("plan_id", 1, 0);
			
			$table->varchar("token")->unique();

			$table->dateTime("created_at","CURRENT_TIMESTAMP");

			$table->dateTime("updated_at");

			$table->create();
		});
    }
    
    public function downgrade()
    {
        
    }
}