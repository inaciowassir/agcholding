<?php

namespace sprint\schemas;

use \sprint\database\schema\Schema;
use \sprint\database\schema\BluePrintSchema;

class Language extends Schema
{	
    public function upgrade()
    {
        $this->run("languages", function(BluePrintSchema $table)
        {
			$table->int("id")->autoIncreament()->primaryKey();
			
			$table->enum("language_code", ["en", "pt"]);

			$table->dateTime("created_at","CURRENT_TIMESTAMP");

			$table->dateTime("updated_at");

			$table->create();
		});
    }
    
    public function downgrade()
    {
        
    }
}