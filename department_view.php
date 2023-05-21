<?php
require_once 'apis/HRM.class.php';

$obj = new HRM();

$department = json_decode($obj->getDepartmentById($_GET["id"]));
$employees = json_decode($obj->getEmployees());

?>

<form id="edit-dpt-form">
    <div class="card-body">
        <div class="form-group">
            <label>Department Name</label>
            <input type="text" class="form-control" id="department-name" value="<?php echo $department->name ?>">
        </div>
        <div class="form-group">
            <label for="">Head of Department</label>
            <select class="form-control" id="head-of-department">
                <?php
                    foreach($employees as $employee){
                        $name = $employee->firstName . " " . $employee->lastName;
                        if($department->hod == $employee->id){
                            echo '<option value="'.$employee->id.'" selected>'.$name.'</option>';
                        }else{
                            echo '<option value="'.$employee->id.'">'.$name.'</option>';
                        }
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="card-footer" style="background: none;">
        <button type="submit" class="btn btn-primary" style="width: 100%;" id="edit-department-button">Update</button>
    </div>
</form>

<script>
$('#edit-department-button').click(function(event) {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500
    });
    event.preventDefault();
    if (!$("#department-name").val() || !$("#head-of-department").val()) {
        Toast.fire({
            icon: 'error',
            title: 'Please fill in all the fields'
        })
        return;
    }

    var button = $("#edit-department-button")
    button.text("Submitting..")
    button.prop("disabled", true)

    $.ajax({
        type: 'POST',
        url: 'middleware.php',
        data: {
            editDepartment: true,
            id: '<?php echo $department->id ?>',
            name: $("#department-name").val(),
            hod: $("#head-of-department").val()
        },
        success: function(response) {
            button.text("Submit")
            button.prop("disabled", false)

            var response = JSON.parse(response)
            if (response.status == "success") {
                Toast.fire({
                    icon: "success",
                    title: "Successfully updated department"
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