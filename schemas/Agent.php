<?php

namespace sprint\schemas;

use \sprint\database\schema\Schema;
use \sprint\database\schema\BluePrintSchema;

class Agent extends Schema
{	
    public function upgrade()
    {
        $this->run("agents", function(BluePrintSchema $table)
        {
			$table->int("id")->autoIncreament()->primaryKey();

			$table->varchar("name");

			$table->varchar("photo");
			
			$table->varchar("phone_number");

			$table->varchar("address");

			$table->int("province_id", 3);

			$table->int("district_id", 3);

			$table->int("administrative_post_id", 3);

			$table->int("is_for_all_tv_series", 1, 0);
			
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