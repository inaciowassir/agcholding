<?php

namespace sprint\http\controllers;

use sprint\http\core\Controller;
use sprint\srequest\SRequest;
use sprint\sresponse\SResponse;
use sprint\ssession\SSession;

class RoleController extends Controller
{
    private $roleModel;
    private $entityEmployerModel;
    private $data = [];

    public function __construct()
    {
        $this->viewsPath = "views/layouts/Roles/";
        $this->roleModel = new \sprint\models\RoleModel();
        $this->entityEmployerModel = new \sprint\models\EntityEmployerModel();
    }

    public function index()
    {
        $this->data["roles"] = $this->roleModel->roles();
        return $this->view("Index", $this->data);
    }

    public function create()
    {
        $key = $this->roleModel->create();
        echo !is_null($key) || !empty($key)
            ? json_encode(["status" => "success", "key" => $key])
            : json_encode(["status" => "failed"]);
    }

    public function save($key = null)
    {
        if (SRequest::isGet()) {
            if (is_null($key)) {
                SResponse::redirect("roles");
            }

            $this->data["key"] = $key;
            $this->data["role"] = $this->roleModel->getRoleByKey($key);
            $this->data["employersEntity"] = $this->entityEmployerModel->employersEntity();
            return $this->view("Save", $this->data);
        }

        if (SRequest::isPost()) {
            $body = SRequest::body();

            $role = [
                "role" => trim($body["role"]),
                "privileges" => $body["privileges"],
                "application_access" => $body["application_access"],
            ];

            $data = $this->roleModel->saveRole($role, $body["key"]);

            if ($data == true) {
                echo json_encode([
                    "status" => "success",
                ]);
            } else {
                echo json_encode([
                    "status" => "failed",
                ]);
            }
        }
    }

    public function remove()
    {
        $body = SRequest::body();
        $key = $body["node"];
        $result = $this->roleModel->removeRole($key);

        echo $result == true
            ? json_encode(["status" => "success", "key" => $key])
            : json_encode(["status" => "failed"]);
    }
}
