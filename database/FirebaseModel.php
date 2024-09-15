<?php
namespace sprint\database;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Database;

class FirebaseModel{
	private $factory;
	private $database;
	private $reference;
	private $storage;
	
	public function __construct() {
		$this->factory = (new Factory)
			->withServiceAccount(__DIR__.'/../mobipal-loan-firebase-credentials.json')
			->withDatabaseUri('https://mobipal-loan-default-rtdb.firebaseio.com/');	

		$this->database = $this->factory->createDatabase();	
		$this->storage = $this->factory->createStorage();
	}
	
	protected function getConnection() {
		return $this->database;
	}
	
	protected function getStorageBucket() {
	    return $this->storage->getBucket();
	}
	
	protected function select($table = null) {
		$this->validate($table);
		$this->reference = $this->database->getReference($table);		
		return $this;
	}
	
	protected function results() {
		return $this->reference->getSnapshot()->getValue();
	}
	
	protected function filterSnapshotByColumn($table, $column, $value) {
		return $this->database->getReference($table)->orderByChild($column)->equalTo($value)->getSnapshot();
	}
	
	protected function where($table, $column, $value) {	
		$snapshot = $this->filterSnapshotByColumn($table, $column, $value);	
		return $snapshot->exists() ? $snapshot->getValue() : null;
	}
	
	protected function insert($table) {
	    return $this->database->getReference($table)->push()->getKey();
	}
	
	protected function save($table = null, $data = [], $key = null) {
		$this->validate($table);
		try {
			$this->database->getReference()->update([$table.'/'.$key => $data]);
			return true;
		} catch (\Exception $e) {
			return false;
		}
	}
	
	protected function updateColumn($table, $key, $column, $value) {
		$this->validate($table);
		try {
			$this->database->getReference()->update([$table .'/'. $key .'/'. $column => $value]);
			return true;
		} catch (\Exception $e) {
			return false;
		}
	}
	
	protected function getValueByKey($table, $key) {
	    $this->validate($table);
	    $snapshot = $this->database->getReference($table)->orderByKey()->equalTo($key)->getSnapshot();
	    return $snapshot->exists() ? $snapshot->getValue() : null;
	}
	
	protected function remove($table, $key) {
	    $this->validate($table);
		try {
		    	$this->database->getReference($table . '/'. $key)->remove();
			return true;
	        } catch (\Exception $e) {
	            return false;
	        }
	}
	
	protected function numRows() {
		return $this->reference->getSnapshot()->numChildren();
	}
	
	protected function hasValues() {
		return $this->reference->getSnapshot()->exists();
	}
	
	private function validate($table) {
	    if(is_null($table)) throw new \Exception("Please provide the table name or valid table name");
	}
}