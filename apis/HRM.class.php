<?php
require_once __DIR__ . '/master/db.php';

class HRM extends DB {
    public function checkIfEmailExists($email){
        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT * FROM `employees` WHERE `email`= ? ");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if($result){
            return true;
        }
        return false;
    }

    public function registerAccount($firstName, $lastName, $email, $password){
        $conn = $this->conn;
        $stmt = $conn->prepare("INSERT INTO `employees` (firstName, lastName, email, password) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);
        $stmt->execute();
        if($stmt->insert_id > 0){
            $output = array("status" => "success");
        }else{
            $output = array("status" => "failed", "message" => $stmt->error);
        }
        return json_encode($output);
    }

    public function registerAccountFromBackend($firstName, $lastName, $email, $password, $idNumber, $department, $role, $supervisor, $manager){
        $conn = $this->conn;
        $stmt = $conn->prepare("INSERT INTO `employees` (firstName, lastName, email, password, idNumber, department, role, supervisorId, managerId) VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("ssssssiii", $firstName, $lastName, $email, $password, $idNumber, $department, $role, $supervisor, $manager);
        $stmt->execute();
        if($stmt->insert_id > 0){
            $output = array("status" => "success");
        }else{
            $output = array("status" => "failed", "message" => $stmt->error);
        }
        return json_encode($output);
    }

    public function updateEmployeeDetails($firstName, $lastName, $email, $idNumber, $department, $role, $status, $id, $supervisor, $manager){
        $conn = $this->conn;
        $stmt = $conn->prepare("UPDATE `employees` SET firstName = ?, lastName = ?, email = ?, idNumber = ?, department = ?, role = ? , status = ? WHERE id = ?");
        $stmt->bind_param("ssssiisi", $firstName, $lastName, $email, $idNumber, $department, $role, $status, $id);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            $output = array("status" => "success");
        }else{
            $output = array("status" => "failed", "message" => $stmt->error);
        }
        return json_encode($output);
    }

    public function logIn($email){
        $output = [];
        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT * FROM `employees` WHERE `email`= ? ");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        if($result){
            $output = array("status" => "success", "data" => $result);
        }else{
            $output = array("status" => "failed", "message" => "No email address found matching the provided one");
        }
        return json_encode($output);
    }

    public function addDepartment($name, $hod){
        $output = [];
        $conn = $this->conn;
        $stmt = $conn->prepare("INSERT INTO `departments` (name, hod) VALUES (?,?)");
        $stmt->bind_param("si", $name, $hod);
        $stmt->execute();
        if($stmt->insert_id > 0){
            $output = array("status" => "success");
        }else{
            $output = array("status" => "failed", "message" => $stmt->error);
        }
        return json_encode($output);
    }

    public function editDepartment($id, $name, $hod){
        $conn = $this->conn;
        $stmt = $conn->prepare("UPDATE `departments` SET name = ?, hod = ? WHERE id = ?");
        $stmt->bind_param("sii", $name, $hod, $id);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            $output = array("status" => "success");
        }else{
            $output = array("status" => "success", "message" => $stmt->error);
        }
        return json_encode($output);
    }

    public function getDepartments(){
        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT a.*, CONCAT(b.firstName, ' ' ,b.lastName) as hodName FROM `departments` a LEFT JOIN `employees` b ON (a.hod = b.id)");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return json_encode($result);
    }

    public function getDepartmentById($id){
        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT a.*, CONCAT(b.firstName, ' ' ,b.lastName) as hodName FROM `departments` a LEFT JOIN `employees` b ON (a.hod = b.id) WHERE a.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return json_encode($result);
    }

    public function getLeaveTypes(){
        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT * FROM `leave_types`");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return json_encode($result);
    }

    public function getLeaveTypeById($id){
        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT * FROM `leave_types` WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return json_encode($result);
    }

    public function addLeaveType($name, $duration){
        $output = [];
        $conn = $this->conn;
        $stmt = $conn->prepare("INSERT INTO `leave_types` (name, duration) VALUES (?,?)");
        $stmt->bind_param("si", $name, $duration);
        $stmt->execute();
        if($stmt->insert_id > 0){
            $output = array("status" => "success");
        }else{
            $output = array("status" => "failed", "message" => $stmt->error);
        }
        return json_encode($output);
    }

    public function editLeaveType($id, $name, $duration){
        $conn = $this->conn;
        $stmt = $conn->prepare("UPDATE `leave_types` SET name = ?, duration = ? WHERE id = ?");
        $stmt->bind_param("sii", $name, $duration, $id);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            $output = array("status" => "success");
        }else{
            $output = array("status" => "success", "message" => $stmt->error);
        }
        return json_encode($output);
    }

    public function getLeaveApplications(){
        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT a.*, CONCAT(b.firstName, ' ' ,b.lastName) as employeeName, c.name as leaveTypeName FROM `leave_applications` a LEFT JOIN `employees` b ON (a.employeeId = b.id) LEFT JOIN `leave_types` c ON (a.leaveType = c.id)");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return json_encode($result);
    }
    public function getEmployeeLeaveApplications($id){
        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT a.*, CONCAT(b.firstName, ' ' ,b.lastName) as employeeName, c.name as leaveTypeName FROM `leave_applications` a LEFT JOIN `employees` b ON (a.employeeId = b.id) LEFT JOIN `leave_types` c ON (a.leaveType = c.id) WHERE b.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return json_encode($result);
    }

    public function getLeaveApplicationsByDept($id){
        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT a.*, CONCAT(b.firstName, ' ' ,b.lastName) as employeeName, c.name as leaveTypeName FROM `leave_applications` a LEFT JOIN `employees` b ON (a.employeeId = b.id) LEFT JOIN `leave_types` c ON (a.leaveType = c.id) WHERE b.department = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return json_encode($result);
    }

    public function approveLeave($id, $userId){
        $status = "Approved";
        $conn = $this->conn;
        $stmt = $conn->prepare("UPDATE `leave_applications` SET status = ? , updatedBy = ?, updatedAt = CURRENT_TIME WHERE id = ?");
        $stmt->bind_param("sii", $status, $userId, $id);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            $output = array("status" => "success");
        }else{
            $output = array("status" => "failed", "message" => $stmt->error);
        }
        return json_encode($output);
    }

    public function rejectLeave($id, $userId){
        $status = "Rejected";
        $conn = $this->conn;
        $stmt = $conn->prepare("UPDATE `leave_applications` SET status = ? , updatedBy = ?, updatedAt = CURRENT_TIME WHERE id = ?");
        $stmt->bind_param("sii", $status, $userId, $id);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            $output = array("status" => "success");
        }else{
            $output = array("status" => "failed", "message" => $stmt->error);
        }
        return json_encode($output);
    }

    public function getEmployeeLeaveBalance($leaveTypeId, $employeeId){
        $status = "Approved";
        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT a.*, b.duration FROM `leave_applications` a LEFT JOIN `leave_types` b ON(a.leaveType = b.id) WHERE a.leaveType = ? AND a.employeeId = ? AND a.status = ?");
        $stmt->bind_param("iis", $leaveTypeId, $employeeId, $status);
        $stmt->execute();
        $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return json_encode($results);
    }

    public function addLeaveApplication($leaveTypeId, $employeeId, $startDate, $endDate, $duration, $comment){
        $conn = $this->conn;
        $stmt = $conn->prepare("INSERT INTO `leave_applications` (leaveType, employeeId, startDate, endDate, days, comment) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("iissis", $leaveTypeId, $employeeId, $startDate, $endDate, $duration, $comment);
        $stmt->execute();
        if($stmt->insert_id > 0){
            $output = array("status" => "success");
        }else{
            $output = array("status" => "failed", "message" => $stmt->error);
        }
        return json_encode($output);
    }
  
    public function getEmployees(){
        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT a.*, CONCAT(a.firstName, ' ', a.lastName) as employeeName , b.name as departmentName, c.name as roleName FROM `employees` a LEFT JOIN `departments` b ON (a.department = b.id) LEFT JOIN `roles` c ON (a.role = c.id)");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return json_encode($result);
    }

    public function getEmployeeById($id){
        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT a.* , b.name as departmentName, c.name as roleName FROM `employees` a LEFT JOIN `departments` b ON (a.department = b.id) LEFT JOIN `roles` c ON (a.role = c.id) WHERE a.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return json_encode($result);
    }

    public function getRoles(){
        $x = 0;
        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT * FROM `roles` WHERE isDeleted = ?");
        $stmt->bind_param("i", $x);
        $stmt->execute();
        $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return json_encode($results);
    }
    public function getRoleById($id){
        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT * FROM `roles` WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $results = $stmt->get_result()->fetch_assoc();
        return json_encode($results);
    }

    public function addRole($name){
        $conn = $this->conn;
        $stmt = $conn->prepare("INSERT INTO `roles` (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        if($stmt->insert_id > 0){
            $output = array("status" => "success");
        }else{
            $output = array("status" => "failed", "message" => $stmt->error);
        }
        return json_encode($output);
    }

    public function addFeature($featureName,$token){
        $conn = $this->conn;
        $stmt = $conn->prepare("INSERT INTO `features` (`feature_name`, `token`) VALUES (?, ?)");
        $stmt->bind_param('si', $featureName, $token);
        $stmt->execute();
        $featureId = $stmt->insert_id;
        if($stmt->error){
            $output["message"] = $stmt->error;
        }
        $output["featureId"] = $featureId;
        $stmt->close();
        return json_encode($output);
    }

    public function addTask($taskName, $createdBy, $employee, $supervisor, $manager, $startDate, $endDate, $taskDetails){
        $conn = $this->conn;
        $stmt = $conn->prepare("INSERT INTO `employee_tasks` (name, createdBy, assignedTo, supervisor, manager, startDate, endDate, details) VALUES (?,?,?,?,?,?,?,?)");
        $stmt->bind_param("siiiisss", $taskName, $createdBy, $employee, $supervisor, $manager, $startDate, $endDate, $taskDetails);
        $stmt->execute();
        if($stmt->insert_id > 0){
            $output = array("status" => "success");
        }else{
            $output = array("status" => "failed", "message" => $stmt->error);
        }
        return json_encode($output);
    }

    public function getTasks(){
        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT a.*, CONCAT(b.firstName, ' ', b.lastName) as employeeName FROM `employee_tasks` a JOIN `employees` b ON (a.assignedTo = b.id)");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return json_encode($result);
    }

    public function getTaskById($id){
        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT a.*, CONCAT(b.firstName, ' ', b.lastName) as employeeName FROM `employee_tasks` a JOIN `employees` b ON (a.assignedTo = b.id) WHERE a.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return json_encode($result);
    }

    public function addTaskProgress($id, $description){
        $conn = $this->conn;
        $stmt = $conn->prepare("INSERT INTO `task_updates` (taskId, message) VALUES (?,?)");
        $stmt->bind_param("is", $id, $description);
        $stmt->execute();
        if($stmt->insert_id > 0){
            $output = array("status" => "success");
        }else{
            $output = array("status" => "failed", ",message" => $stmt->error);
        }
        return json_encode($output);
    }

    public function getTaskProgress($id){
        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT * FROM `task_updates` WHERE taskId = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return json_encode($result);
    }

    public function getTasksByDpt($id){
        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT a.*, CONCAT(b.firstName, ' ', b.lastName) as employeeName FROM `employee_tasks` a JOIN `employees` b ON (a.assignedTo = b.id) WHERE b.department = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return json_encode($result);
    }
    public function getTasksByEmpId($id){
        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT a.*, CONCAT(b.firstName, ' ', b.lastName) as employeeName FROM `employee_tasks` a JOIN `employees` b ON (a.assignedTo = b.id) WHERE b.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return json_encode($result);
    }

    public function getEmName($id){
        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT CONCAT(firstName, ' ', lastName) as employeeName FROM `employees` WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return json_encode($result);
    }

    public function completeTask($id){
        $status = "Completed";
        $conn = $this->conn;
        $stmt = $conn->prepare("UPDATE `employee_tasks` SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            $output = array("status" => "success");
        }else{
            $output = array("status" => "failed", "message" => $stmt->error);
        }

        return json_encode($output);
    }
    public function notCompleted($id){
        $status = "Not Completed";
        $conn = $this->conn;
        $stmt = $conn->prepare("UPDATE `employee_tasks` SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            $output = array("status" => "success");
        }else{
            $output = array("status" => "failed", "message" => $stmt->error);
        }

        return json_encode($output);
    }

    public function getEmployeesByDpt($id){
        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT a.*, CONCAT(a.firstName, ' ', a.lastName) as employeeName , b.name as departmentName, c.name as roleName FROM `employees` a LEFT JOIN `departments` b ON (a.department = b.id) LEFT JOIN `roles` c ON (a.role = c.id) WHERE a.department = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return json_encode($results);
    }

    public function checkRoleValidity($roleId, $dept){
        $conn = $this->conn;
        $stmt = $conn->prepare("SELECT * FROM `employees` WHERE role = ? AND department = ?");
        $stmt->bind_param("ii", $roleId, $dept);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return json_encode($result);
    }
}

?>