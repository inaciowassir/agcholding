<?php
namespace sprint\models;

use sprint\database\FirebaseModel;

class DocumentApplicationModel extends FirebaseModel {
	private $table = "configurations/documents/application";
	
	public function filterApplicationDocument($column, $status) {
		return $this->where($this->table, $column, $status);		
	}
	
	public function getApplicationDocumentByKey($key) {
	    return $this->getValueByKey($this->table, $key);
	}
	
	public function applicationDocuments() {
		return $this->select($this->table)->results();		
	}
	
	public function create() {
	    return $this->insert($this->table);
	}
	
	public function saveApplicationDocument($data, $key = null) {
		return $this->save($this->table, $data, $key);		
	}
	
	public function removeApplicationDocument($key) {
	    return $this->remove($this->table, $key);
	}
	
	public function getBucket() {
	    return $this->getStorageBucket();
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