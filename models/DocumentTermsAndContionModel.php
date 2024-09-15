<?php
namespace sprint\models;

use sprint\database\FirebaseModel;

class DocumentTermsAndContionModel extends FirebaseModel {
	private $table = "configurations/documents/terms_and_conditions";
	
	public function filterTermsAndContion($column, $status) {
		return $this->where($this->table, $column, $status);		
	}
	
	public function getTermsAndContionByKey($key) {
	    return $this->getValueByKey($this->table, $key);
	}
	
	public function documents() {
		return $this->select($this->table)->results();		
	}
	
	public function create() {
	    return $this->insert($this->table);
	}
	
	public function saveTermsAndContion($data, $key = null) {
		return $this->save($this->table, $data, $key);		
	}
	
	public function removeTermsAndContion() {
	    return $this->remove($this->table, null);
	}
	
	public function upload($file) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $bucket = $this->getStorageBucket();
            
            $tmpFilePath = $file['tmp_name'];
            
            // Check if the file is a PDF
            $fileType = pathinfo($file['name'], PATHINFO_EXTENSION);
            if (strtolower($fileType) !== 'pdf') {
                throw new \Exception('Invalid file type. Please upload a PDF file.');
            }
        
            // Upload the file to Firebase Storage
            $fileName = $this->table.'/' . uniqid() . time() . '.pdf';
                
            $bucket->upload(file_get_contents($tmpFilePath), [
                'name' => $fileName,
            ]);
        
            // Get the download URL
            $object = $bucket->object($fileName);
            
            $expiration = time() + (365 * 5 * 24 * 60 * 60);
            $downloadUrl = $object->signedUrl($expiration);
            $fileSize = $object->info()['size'];
            
            return [
                    "download_url" => $downloadUrl,
                    "file_size" => $fileSize
                ];
                
        } else {
            return [];
        }
	}
}