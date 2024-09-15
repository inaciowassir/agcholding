<?php

namespace sprint;

use \sprint\database\Model;
use \sprint\database\schema\BluePrintSchema;

class Schema extends Model
{
    private $schemaTableName = "schema_version";
    
    public function __construct()
    {
        parent::__construct();
        
        $dir = __DIR__."/schemas/";
        
        $files = scandir($dir);
        
        $this->schemaTable();
        
        $savedSchema = $this->select($this->schemaTableName)->results();
        
        $savedSchema = array_column($savedSchema, "schema_name");
        
        $toBeSavedSchema = array_diff($files, $savedSchema);
        
        foreach($toBeSavedSchema as $schema)
        {
            if($schema == "." || $schema == "..")
            {
                continue;
            }
            
            $this->insert($this->schemaTableName)->values(array(
                "schema_name" => $schema
            ));
            
            if($this->insert_id() > 0)
            {
                $schema = pathinfo($schema, PATHINFO_FILENAME);
            
                $className = "\\sprint\\schemas\\{$schema}";
                
                $newSchema = new $className;
                
                $newSchema->upgrade();
            }
        }
    }
    
    public function schemaTable()
    {
        $schema = new \sprint\database\schema\Schema();
        
        $schema->run($this->schemaTableName, function(BluePrintSchema $table)
        {
            $table->int("schema_id")->autoIncreament()->primaryKey();
            $table->varchar("schema_name")->notNull(true);
            $table->int("schema_version", 11, $_SERVER['SCHEMA_VERSION']);
            $table->dateTime("schema_created_at", "CURRENT_TIMESTAMP")->notNull(false);
            
            $table->create();
        });
    }
}