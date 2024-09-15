<?php

namespace sprint\schemas;

use \sprint\database\schema\Schema;
use \sprint\database\schema\BluePrintSchema;

class Content extends Schema
{	
    public function upgrade()
    {
        $this->run("contents", function(BluePrintSchema $table)
        {
			$table->int("id")->autoIncreament()->primaryKey();

			$table->varchar("name");
			
			$table->varchar("slug");
			
			$table->text("description");
			
			$table->varchar("photo");

			$table->int("subcategory_id", 11, 0);

			$table->int("category_id", 11, 0);

			$table->int("launch_year", 11, 0);

			$table->int("duration", 11, 0);

			$table->varchar("authors");

			$table->varchar("trailer_link");

			$table->int("is_for_all_agents", 1, 1);

			$table->int("is_for_all_tv_series", 1, 1);
			
			$table->int("status", 1, 0);

			$table->dateTime("created_at","CURRENT_TIMESTAMP");

			$table->dateTime("updated_at");

			$table->create();
		});
    }
}