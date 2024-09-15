<?php

namespace sprint\schemas;

use \sprint\database\schema\Schema;
use \sprint\database\schema\BluePrintSchema;

class Transaction extends Schema
{	
    public function upgrade()
    {
        $this->run("transactions", function(BluePrintSchema $table)
        {
			$table->int("id")->autoIncreament()->primaryKey();
			
			$table->varchar("transaction_token")->unique();

			$table->decimal("paid", [10, 2]);
			
			$table->enum("payment_gateway", ["mpesa", "emola"]);
			
			$table->int("token_id", 1, 0);
			
			$table->enum("status", ["success", "pending", "failed"]);

			$table->dateTime("created_at","CURRENT_TIMESTAMP");

			$table->dateTime("updated_at");

			$table->create();
		});
    }
    
    public function downgrade()
    {
        
    }
}