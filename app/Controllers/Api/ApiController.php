<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Model\StudentModel;

class ApiController extends ResourceController
{
    // POST
    public function addStudent()
    {
        // formData
        $rules = [
            "name" => "required",
            "email" => "required|valid_email|is_unique[students.email]",
        ];

        if(!$this->validate($rules))
        {
            $response = [
                "status" => false,
                "message" => $this->validator->getErrors(),
                "data" => []            
            ];
        } else {

            $imageFile = $this->request->getFile("profile_image");

            if (isset($imageFile) && !empty($imageFile))
            {
                $imageName = $imageFile->getName();

            $tempArray = explode(".", $imageName);

            $newImageName = round(microtime(true)."".end($tempArray));

            if ($imageFile->move("images/".$newImageName)) {

                $studentObject = new StudentModel();

                $data = [
                    "name" => $this->request->getVar("name"),
                    "email" => $this->request->getVar("email"),
                    "phone" => $this->request->getVar("phone"),
                    "profile_image" => "images/" . $newImageName,
                ];

                if ($studentObject->insert($data)) {
                    $response = [
                        "status" => true,
                        "message" => "Student added.",
                        "data" => []
                    ];

                } else {
                    $response = [
                        "status" => false,
                        "message" => "Faild to add student.",
                        "data" => []
                    ];
                }
            } else {
                $studentObject = new StudentModel();

                $data = [
                    "name" => $this->request->getVar("name"),
                    "email" => $this->request->getVar("email"),
                    "phone" => $this->request->getVar("phone"),
                ];

                if ($studentObject->insert($data)) {
                    $response = [
                        "status" => true,
                        "message" => "Student added.",
                        "data" => []
                    ];

                } else {
                    $response = [
                        "status" => false,
                        "message" => "Faild to add student.",
                        "data" => []
                    ];
                }
            }

            } else {
                $response = [
                    "status" => false,
                    "message" => "Faild to upload image.",
                    "data" => []
                ];
            }
        }

        return $this->respondCreated($response);
    }

    // GET
    public function listStudents()
    {

    }

    // GET
    public function singleStudent($student_id)
    {

    }

    // PUT
    public function updateStudent($student_id, $student_data)
    {
        // formData
    }

    // Delete
    public function deleteStudent($student_id)
    {

    }
}
