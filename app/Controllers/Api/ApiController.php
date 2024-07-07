<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\StudentModel;

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

                $newImageName = round(microtime(true)) . "." . end($tempArray);

                if ($imageFile->move("images", $newImageName))
                {
                    $studentObject = new StudentModel();

                    $data = [
                        "name" => $this->request->getVar("name"),
                        "email" => $this->request->getVar("email"), 
                        "phone" => $this->request->getVar("phone"), 
                        "profile_image" => "images/" . $newImageName
                    ];

                    if ($studentObject->insert($data)) {

                        $response = [
                            "status" => true,
                            "message" => "Student added!",
                            "data" => []            
                        ];

                    } else {

                        $response = [
                        "status" => false,
                        "message" => "Failed to add student!",
                        "data" => []            
                    ];

                    }

                } else {

                    $response = [
                        "status" => false,
                        "message" => "Failed to upload image.",
                        "data" => []            
                    ];
                }

                
            } else {

                $studentObject = new StudentModel();

                $data = [
                    "name" => $this->request->getVar("name"),
                    "email" => $this->request->getVar("email"),
                    "phone" => $this->request->getVar("phone")
                ];

                if($studentObject->insert($data)) {

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
        }

        return $this->respondCreated($response);
    }

    // GET
    public function listStudents()
    {
        $studentObject = new StudentModel();

        $students = $studentObject->findAll();

        if (!empty($students))
        {
            $response = [
                "status" => true,
                "message" => "Students found",
                "data" => $students
            ];

        } else {

             $response = [
                "status" => false,
                "message" => "No students found",
                "data" => []
            ];

        }

        return $this->respondCreated($response);
    }

    // GET
    public function singleStudent($student_id)
    {
        $studentObject = new StudentModel();

        $student = $studentObject->find($student_id);

        if (!empty($student)) {

            $response = [
                "status" => true,
                "message" => "Student data found",
                "data" => $student
            ];

        } else {

            $response = [
                "status" => false,
                "message" => "No student data found!",
                "data" => []
            ];
        }

        return $this->respondCreated($response);
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
