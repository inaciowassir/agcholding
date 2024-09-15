<?php

namespace sprint\schemas;

use \sprint\database\schema\Schema;
use \sprint\database\schema\BluePrintSchema;

class Subcategory extends Schema
{	
    public function upgrade()
    {
        $this->run("subcategories", function(BluePrintSchema $table)
        {
			$table->int("id")->autoIncreament()->primaryKey();

			$table->varchar("name");
			
			$table->varchar("slug");
			
			$table->text("description");
			
			$table->varchar("photo");

			$table->int("category_id", 11, 0);
			
			$table->int("status", 1, 0);

			$table->dateTime("created_at","CURRENT_TIMESTAMP");

			$table->dateTime("updated_at");

			$table->create();
		});
    }
}