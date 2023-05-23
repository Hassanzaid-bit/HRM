<?php
require_once 'apis/HRM.class.php';
$obj = new HRM();

if(isset($_GET["id"])){
    $task = json_decode($obj->getTaskById($_GET["id"]));
    $emp = json_decode($obj->getEmployeeById($task->supervisor));
    $supervisor = $emp->firstName . " " . $emp->lastName;

    $taskProgress = json_decode($obj->getTaskProgress($task->id));
}

?>

<p style="margin-bottom: 5px">Task Name : <?php echo $task->name ?></p>
<p style="margin-bottom: 5px">Description : <?php echo $task->details ?></p>
<p style="margin-bottom: 5px">Status : <?php echo $task->status ?></p>
<p style="margin-bottom: 5px">Start End : <?php echo $task->startDate ?></p>
<p style="margin-bottom: 5px">End Date : <?php echo $task->endDate ?></p>
<p style="margin-bottom: 5px">Supervisper : <?php echo $supervisor ?></p>

<h2>Task Progress</h2>

<?php 
    $table = "";
    if(!empty($taskProgress)){
        $table = "<table><thead><th>Date</th><th></th><th>Progress</></thead><tbody>";
        foreach($taskProgress as $progress){
            // $date = date("d-M-Y H:i A", strtotime($progress->createdAt));
            $date = date("d-M-Y H:i A", strtotime($progress->createdAt));
            $message = $progress->message;
            $table .= "<tr><td>$date</td><td></td><td>$message</td></tr>";
        }
        $table .= "</tbody></table>";
    }else{
        $table = "No progress";
    }
    echo $table;
?>
<?php if($task->status == "Pending"){ ?>

<form id="add-plan-form" style="margin-top : 10px">
    <input type="hidden" value="<?php echo $task->id ?>" class="form-control" id="taskId">
    <div class="row ">
        <div class="col-12 mt-2">
            <button type="submit" class="btn btn-primary btn-block" id="approve">Mark as Completed</button>
        </div>
        <div class="col-12 mt-2">
            <button type="submit" class="btn btn-secondary btn-block" id="reject">Mark as Incomplete</button>
        </div>
    </div>
</form>

<?php } ?>

<script>
var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3500
});
$("#registerButton").click(function(e) {
    e.preventDefault();
    $("#progressDescription").val();
    $("#taskId").val();
    if (!$("#progressDescription").val()) {
        Toast.fire({
            icon: "error",
            title: "Please input all fields"
        });
        return
    }
    $(this).text("Submitting..")
    $(this).prop("disabled", true)

    $.ajax({
        type: 'POST',
        url: 'middleware.php',
        data: {
            addTaskProgress: true,
            id: $("#taskId").val(),
            description: $("#progressDescription").val()
        },
        success: function(response) {

            var parsedResponse = JSON.parse(response);
            if (parsedResponse.status == "success") {
                Toast.fire({
                    icon: "success",
                    title: "Successfully added task description"
                });
                location.reload();
            } else {
                $(this).text("Submit")
                $(this).prop("disabled", false)
                Toast.fire({
                    icon: "error",
                    title: parsedResponse.message
                });
            }
        }
    });
})

$("#approve").click(function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'middleware.php',
        data: {
            completeTask: true,
            id: $("#taskId").val()
        },
        success: function(response) {
            console.log(response);
            var parsedResponse = JSON.parse(response);
            if (parsedResponse.status == "success") {
                Toast.fire({
                    icon: "success",
                    title: "Successfully"
                });
                location.reload();
            } else {
                Toast.fire({
                    icon: "error",
                    title: parsedResponse.message
                });
            }
        }
    });
})
$("#reject").click(function(e) {
    e.preventDefault();
    $.ajax({
        type: 'POST',
        url: 'middleware.php',
        data: {
            markNotCompleted: true,
            id: $("#taskId").val()
        },
        success: function(response) {
            console.log(response);
            var parsedResponse = JSON.parse(response);
            if (parsedResponse.status == "success") {
                Toast.fire({
                    icon: "success",
                    title: "Successfully"
                });
                location.reload();
            } else {
                Toast.fire({
                    icon: "error",
                    title: parsedResponse.message
                });
            }
        }
    });
})
</script>