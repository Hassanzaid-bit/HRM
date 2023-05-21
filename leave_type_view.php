<?php
require_once '../apis/HRM.class.php';

$obj = new HRM();
$leaveType = json_decode($obj->getLeaveTypeById($_GET["id"]));

?>

<form id="add-plan-form">
    <div class="card-body">
        <div class="form-group">
            <label>Leave Name</label>
            <input type="text" class="form-control" id="leave-type-name" placeholder="Enter leave name"
                value="<?php echo  $leaveType->name ?>">
        </div>
        <div class="form-group">
            <label>Duration(days)</label>
            <input type="number" class="form-control" id="duration" placeholder="Enter leave days . e.g 21"
                value="<?php echo $leaveType->duration ?>">
        </div>
    </div>
    <div class="card-footer" style="background: none;">
        <button type="submit" class="btn btn-primary" style="width: 100%;" id="edit-leave-button">Update</button>
    </div>
</form>

<script>
$('#edit-leave-button').click(function(event) {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500
    });
    event.preventDefault();
    if (!$("#leave-type-name").val() || !$("#duration").val()) {
        Toast.fire({
            icon: 'error',
            title: 'Please fill in all the fields'
        })
        return;
    }

    var button = $("#edit-leave-button")
    button.text("Submitting..")
    button.prop("disabled", true)

    $.ajax({
        type: 'POST',
        url: 'middleware.php',
        data: {
            editLeaveType: true,
            id: '<?php echo $leaveType->id ?>',
            name: $("#leave-type-name").val(),
            duration: $("#duration").val()
        },
        success: function(response) {
            button.text("Submit")
            button.prop("disabled", false)

            var response = JSON.parse(response)
            if (response.status == "success") {
                Toast.fire({
                    icon: "success",
                    title: "Successfully updated leave type"
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