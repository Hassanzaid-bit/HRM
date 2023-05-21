<?php

require_once 'apis/HRM.class.php';

session_start();

$obj = new HRM();

if(isset($_POST["addDepartment"])){
    echo $obj->addDepartment($_POST["name"], $_POST["hod"]);
}

if(isset($_POST["editDepartment"])){
    echo $obj->editDepartment($_POST["id"],$_POST["name"], $_POST["hod"]);
}

if(isset($_POST["addLeaveType"])){
    echo $obj->addLeaveType($_POST["name"], $_POST["duration"]);
}

if(isset($_POST["editLeaveType"])){
    echo $obj->editLeaveType($_POST["id"], $_POST["name"], $_POST["duration"]);
}

if(isset($_POST["addLeaveApplication"])){
    $result = json_decode($obj->getEmployeeLeaveBalance($_POST["leaveType"], $_POST["employeeId"]));
    if(!$result){
        echo $obj->addLeaveApplication($_POST["leaveType"], $_POST["employeeId"], $_POST["startDate"], $_POST["endDate"], $_POST["duration"], $_POST["comment"]);
    }else{
        $takenleaveDays = 0;
        $leaveMaxDays = 0;
        foreach($result as $leaveApp){
            if($leaveApp->leaveType == $_POST["leaveType"]){
                $leaveMaxDays = $leaveApp->duration;
                $takenleaveDays += $leaveApp->days;
            }
        }
        $allowedDays = $leaveMaxDays - $takenleaveDays;
        if($_POST["duration"] >  $allowedDays){
            echo json_encode(array("status" => "failed", "message" => "Your leave balance is " . $allowedDays . " days"));
        }else{
            echo $obj->addLeaveApplication($_POST["leaveType"], $_POST["employeeId"], $_POST["startDate"], $_POST["endDate"], $_POST["duration"], $_POST["comment"]);
        }
    }
}

if(isset($_POST["approveLeave"])){
    echo $obj->approveLeave($_POST["id"], $_POST["userId"]);
}

if(isset($_POST["rejectLeave"])){
    echo $obj->rejectLeave($_POST["id"], $_POST["userId"]);
}

if(isset($_POST["addRole"])){
    echo $obj->addRole($_POST["roleName"]);
} 

if(isset($_POST["addEmployee"])){
    $emailExists = $obj->checkIfEmailExists($_POST["email"]);
    // if($emailExists == 1){
    if(false){
        echo json_encode(array("status" => "failed", "message" => "Provided email already exists"));
        return;
    }
    if($_POST["role"] == 2){
        $res = json_decode($obj->checkRoleValidity($_POST["role"], $_POST["department"]));
        if($res){
            echo json_encode(array("status" => "failed", "message" => "Can't add employee as HOD"));
            return;
        }
    }
    
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    echo $obj->registerAccountFromBackend($_POST["firstName"] , $_POST["lastName"], $_POST["email"], $password, $_POST["idNumber"], $_POST["department"], $_POST["role"], $_POST["supervisor"], $_POST["manager"]);
}

if(isset($_POST["updateEmployee"])){
    echo $obj->updateEmployeeDetails($_POST["firstName"] , $_POST["lastName"], $_POST["email"], $_POST["idNumber"], $_POST["department"], $_POST["role"], $_POST["status"], $_POST["employeeId"], $_POST["supervisor"], $_POST["manager"]);
}

if(isset($_POST["addTask"])){
    echo $obj->addTask($_POST["taskName"], $_POST["createdBy"], $_POST["employee"], $_POST["supervisor"],  $_POST["manager"],  $_POST["startDate"], $_POST["endDate"], $_POST["taskDetails"]);
}

if(isset($_POST["completeTask"])){
    echo $obj->completeTask($_POST["id"]);
}

if(isset($_POST["markNotCompleted"])){
    echo $obj->notCompleted($_POST["id"]);
}


if(isset($_POST["addTaskProgress"])){
    echo $obj->addTaskProgress($_POST["id"], $_POST["description"]);
}

if(isset($_POST["login"])){
    $result = json_decode($obj->logIn($_POST["email"]));
    if($result->status == "success"){
        $data = $result->data;
        if (password_verify($_POST["password"], $data->password)){
            $_SESSION["userId"] = $data->id;
            $_SESSION["userName"] = $data->firstName . " " . $data->lastName;
            $_SESSION["role"] = $data->role;
            $_SESSION["department"] = $data->department;
            
            echo json_encode($result) ;
        } else {
            echo "Invalid password.";
        }
    }else{
        echo json_encode($result);
    }
}

// if(isset($_POST["addTask"])){
//     echo $obj->addTask($_POST["taskName"], $_POST["createdBy"], $_POST["employee"], $_POST["supervisor"],  $_POST["manager"],  $_POST["startDate"], $_POST["endDate"]);
// }

// if(isset($_POST["completeTask"])){
//     echo $obj->completeTask($_POST["id"]);
// }

// if(isset($_POST["addLeaveApplication"])){
//     $result = json_decode($obj->getEmployeeLeaveBalance($_POST["leaveType"], $_POST["employeeId"]));
//     if(!$result){
//         echo $obj->addLeaveApplication($_POST["leaveType"], $_POST["employeeId"], $_POST["startDate"], $_POST["endDate"], $_POST["duration"], $_POST["comment"]);
//     }else{
//         $takenleaveDays = 0;
//         $leaveMaxDays = 0;
//         foreach($result as $leaveApp){
//             if($leaveApp->leaveType == $_POST["leaveType"]){
//                 $leaveMaxDays = $leaveApp->duration;
//                 $takenleaveDays += $leaveApp->days;
//             }
//         }
//         $allowedDays = $leaveMaxDays - $takenleaveDays;
//         if($_POST["duration"] >  $allowedDays){
//             echo json_encode(array("status" => "failed", "message" => "Your leave balance is " . $allowedDays . " days"));
//         }else{
//             echo $obj->addLeaveApplication($_POST["leaveType"], $_POST["employeeId"], $_POST["startDate"], $_POST["endDate"], $_POST["duration"], $_POST["comment"]);
//         }
//     }
// }