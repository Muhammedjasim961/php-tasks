<?php

namespace OneHRMS\Model;


require('BaseModel.php');
require_once 'interface/CrudeInterface.php';
require_once 'Trait/ValidateTrait.php';

use OneHRMS\interface\CrudeInterface;
use OneHRMS\Trait\ValidateTrait;


class Employee extends BaseModel implements CrudeInterface
{

    use ValidateTrait;

    private $table = 'employees';
    public $firstName;
    public $lastName;
    public $Email;
    public $Salary;
    public $Department;

    public function __construct($db)
    {
        parent::__construct($db);
    }

    public function add()
    {
        $query = "INSERT INTO " . $this->table . " (firstName, lastName, Email, Salary, Department) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $this->firstName = htmlspecialchars(strip_tags($this->firstName));
        $this->lastName = htmlspecialchars(strip_tags($this->lastName));
        $this->Email = htmlspecialchars(strip_tags($this->Email));
        $this->Salary = htmlspecialchars(strip_tags($this->Salary));
        $this->Department = htmlspecialchars(strip_tags($this->Department));

        $stmt->bind_param("sssis", $this->firstName, $this->lastName, $this->Email, $this->Salary, $this->Department);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function listAll()
    {

        $query = "SELECT * FROM " . $this->table;

        return $this->conn->query($query);
    }

    public function findOne($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE id=  ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function update($id)
    {
        $query = "UPDATE " . $this->table . " SET firstName = ?, lastName = ?, Email = ?, Salary = ?, Department = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);

        $this->firstName = htmlspecialchars(strip_tags($this->firstName));
        $this->lastName = htmlspecialchars(strip_tags($this->lastName));
        $this->Email = htmlspecialchars(strip_tags($this->Email));
        $this->Salary = htmlspecialchars(strip_tags($this->Salary));
        $this->Department = htmlspecialchars(strip_tags($this->Department));

        $stmt->bind_param("sssisi", $this->firstName, $this->lastName, $this->Email, $this->Salary, $this->Department, $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
        // echo "hello";

    }

    public function delete($id)
    {
        $query = "DELETE FROM ". $this->table . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);

        if($stmt->execute()){
            return true;
        }else {
            return false;
        }

    }

    public function validate($data)
    {
        $errors = [];

        $this->validateRequired('firstName', $data['firstName'], $errors);
        $this->validateRequired('lastName', $data['lastName'], $errors);
        $this->validateEmail('Email', $data['Email'], $errors);
        $this->validateRequired('Email', $data['Email'], $errors);

        return $errors;
    }
}
