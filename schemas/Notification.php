<?php

namespace sprint\schemas;

use \sprint\database\schema\Schema;
use \sprint\database\schema\BluePrintSchema;

class Notification extends Schema
{	
    public function upgrade()
    {
        $this->run("notifications", function(BluePrintSchema $table)
        {
			$table->int("id")->autoIncreament()->primaryKey();

			$table->int("token_transaction", 1, 0);
			
			$table->int("content_availability", 1, 0);

			$table->dateTime("created_at","CURRENT_TIMESTAMP");

			$table->dateTime("updated_at");

			$table->create();
		});
    }
    
    public function downgrade()
    {
        
    }
}