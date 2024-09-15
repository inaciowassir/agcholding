<?php

namespace sprint\schemas;

use \sprint\database\schema\Schema;
use \sprint\database\schema\BluePrintSchema;

class Profile extends Schema
{	
    public function upgrade()
    {
        $this->run("profiles", function(BluePrintSchema $table)
        {
			$table->int("id")->autoIncreament()->primaryKey();

			$table->varchar("name");

			$table->int("manage_reports", 1, 0);

			$table->int("manage_contents", 1, 0);

			$table->int("manage_categories", 1, 0);

			$table->int("manage_subcategories", 1, 0);

			$table->int("manage_users", 1, 0);

			$table->int("manage_agents", 1, 0);

			$table->int("manage_transactions", 1, 0);

			$table->int("manage_configurations", 1, 0);
			
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