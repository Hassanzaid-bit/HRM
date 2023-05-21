<?php
require_once 'apis/HRM.class.php';
$obj = new HRM();
$employee = json_decode($obj->getEmployeeById($_GET["id"]));
$departments = json_decode($obj->getDepartments());
$roles = json_decode($obj->getRoles());
$employees = json_decode($obj->getEmployees());


$badge = "";
if($employee->status == "Active"){
    $badge = "right badge badge-success";
}else{
    $badge = "right badge badge-danger";
}

?>

<div class="row">
    <div class="col-12">
        <!-- Main content -->
        <div class="invoice p-3 mb-3">
            <form>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">First Name</label>
                            <input type="text" class="form-control" placeholder="First Name" name="firstName"
                                id="firstName" value="<?php echo $employee->firstName ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Last Name</label>
                            <input type="text" class="form-control" placeholder="Last Name" name="lastName"
                                id="lastName" value="<?php echo $employee->lastName ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email Address</label>
                            <input type="email" class="form-control" placeholder="Email" name="email" id="email"
                                value="<?php echo $employee->email ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">ID Number</label>
                            <input type="number" class="form-control" placeholder="ID number" name="id-number"
                                id="idNumber" value="<?php echo $employee->idNumber ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Department</label>
                            <select class="form-control" id="department">
                                <?php
                                    foreach($departments as $department){
                                        if($department->id == $employee->department){
                                            echo '<option selected value="'.$department->id.'">'.$department->name .'</option>';
                                        }else{
                                            echo '<option value="'.$department->id.'">'.$department->name .'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Role</label>
                            <select class="form-control" id="role">
                                <?php
                                    foreach($roles as $role){
                                        if($role->id == $employee->role){
                                            echo '<option selected value="'.$role->id.'">'.$role->name .'</option>';
                                        }else{
                                            echo '<option value="'.$role->id.'">'.$role->name .'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row d-none">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Manager</label>
                            <?php
                                $disable = "";
                                if($employee->role == 3  || $employee->role == 4 ){
                                    $disable = "disabled";
                                }
                            ?>
                            <select <?php echo  $disable ?> class="form-control" id="manager">
                                <?php
                                    foreach($employees as $employee2){
                                        if($disable == "disabled"){
                                            if($employee2->role == 4){
                                                echo '<option selected value="'.$employee2->id.'">'.$employee2->firstName .'</option>';
                                            }else{
                                                echo '<option selected value=""></option>';
                                            }
                                        }                                        
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Supervisor</label>
                            <select <?php echo  $disable ?> class="form-control" id="supervisor">
                                <?php
                                    foreach($employees as $employee2){
                                         if($disable == "disabled"){
                                            if($employee2->role == 3){
                                                echo '<option selected value="'.$employee2->id.'">'.$employee2->firstName .'</option>';
                                            }else{
                                                echo '<option selected value=""></option>';
                                            }
                                        }       
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="">Status</label>
                        <select class="form-control" id="status">
                            <?php
                                $status = array("Active", "Retired");
                                foreach($status as $stat){
                                    if($stat == $employee->status){
                                        echo '<option selected value="'.$employee->status.'">'.$employee->status .'</option>';
                                    }else{
                                        echo '<option value="'.$stat.'">'.$stat .'</option>';
                                    }
                                }
                                ?>
                        </select>
                    </div>
                </div>

                <input type="hidden" id="employeeId" , value="<?php echo $employee->id ?>">

                <div class="row ">
                    <div class="col-12">
                        <button class="btn btn-primary btn-block" id="updateButton">Update</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.invoice -->
    </div><!-- /.col -->
</div>

<script>
$('#updateButton').click(function(event) {
    event.preventDefault();
    console.log("Clicked")

    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500
    });

    if (!$("#firstName").val() || !$("#lastName").val() || !$("#idNumber")
        .val() || !$("#department").val() || !$("#role").val()) {
        Toast.fire({
            icon: 'error',
            title: 'Please fill in all the fields'
        })
        return;
    }


    var button = $("#updateButton")
    button.text("Submitting..")
    button.prop("disabled", true)

    $.ajax({
        type: 'POST',
        url: 'middleware.php',
        data: {
            updateEmployee: true,
            employeeId: $("#employeeId").val(),
            firstName: $("#firstName").val(),
            lastName: $("#lastName").val(),
            email: $("#email").val(),
            idNumber: $("#idNumber").val(),
            department: $("#department").val(),
            role: $("#role").val(),
            status: $("#status").val(),
            supervisor: "",
            manager: ""
        },
        success: function(response) {
            button.text("Submit")
            button.prop("disabled", false)
            console.log(response);

            var response = JSON.parse(response)
            if (response.status == "success") {
                Toast.fire({
                    icon: "success",
                    title: "Successfully updated employee"
                })
                location.reload();
            } else {
                button.text("Submit")
                button.prop("disabled", false)
                Toast.fire({
                    icon: 'error',
                    title: response.message
                })
            }
        }
    })
});
</script>