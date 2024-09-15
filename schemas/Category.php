<?php

namespace sprint\schemas;

use \sprint\database\schema\Schema;
use \sprint\database\schema\BluePrintSchema;

class Category extends Schema
{	
    public function upgrade()
    {
        $this->run("categories", function(BluePrintSchema $table)
        {
			$table->int("id")->autoIncreament()->primaryKey();

			$table->varchar("name");
			
			$table->varchar("slug");
			
			$table->text("description");
			
			$table->varchar("photo");
			
			$table->int("status", 1, 0);

			$table->dateTime("created_at","CURRENT_TIMESTAMP");

			$table->dateTime("updated_at");

			$table->create();
		});
    }
}