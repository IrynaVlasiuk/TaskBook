<?php
include 'header.php';
?>

<?php

if(isset($_COOKIE['jwt'])): ?>

<div class="top-panel">
    <button class="logout"><a href="/logout">Logout</a></button>
</div>
<div class="title">Tasks List</div>

    <div id="edit-window" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Edit Task</h5>
                    <button type="button" class="close-modal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-edit-task">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-edit">Save</button>
                    <span class="span-hidden" hidden></span>
                </div>
            </div>
        </div>
    </div>

<div class="container">
    <?php
    foreach ($data as $task) {
        ?>
        <div class="row item">
            <div class="col-md-8 mx-auto">
                <div class="item-title">Author name</div>
                <div><?php echo $task["user_name"]; ?></div>
                <div class="item-title">Author email</div>
                <div><?php echo $task["user_email"]; ?></div>
                <div class="item-title">Task description</div>
                <div class="description"><?php echo $task["description"]; ?></div>
                <label class="item-title">Done</label>
                <input type="checkbox" class="check-done" <?php echo $task["done"] == 1 ? "checked": ""?> >
                <button type="button" class="edit-task" task_id="<?php echo $task["id"]; ?>">Edit</button>
            </div>
        </div>
        <?php } ?>
</div>

<?php else: ?>
    <div>You don`t have permission</div>
<?php endif; ?>

<script type="text/javascript">
    $(document).ready(function () {
        //open modal window for editing task
        $('.edit-task').on('click', function () {
            let description = $(this).siblings('.description').text();
            let id = $(this).attr('task_id');
            $('#edit-window').show();
            $('#edit-window #description').text(description);
            $('#edit-window .span-hidden').text(id);
        });

        //change status 'done' of task
        $('.check-done').on('click', function () {
            let id = $(this).siblings('.edit-task').attr('task_id');
            let done = $(this).is(":checked") ? 1: 0 ;
            let data = { task_id:id, done: done };
            ajaxHandler('POST', 'change-status', data);
        });

        //edit task
        $('#modal-edit').on('click', function () {
            let context = $(this);
            //check validation
            if ($('#form-edit-task').valid()) {
                let id = context.siblings('.span-hidden').text();
                let description = $('#description').val();
                let data = {task_id: id, description: description};
                let jwt = $.cookie("jwt");
                $.ajax({
                    type: "POST", //GET, POST, PUT
                    url: 'edit-task',  //the url to call
                    data: data,     //Data sent to server
                    beforeSend: function (xhr) {   //Include the bearer token in header
                        xhr.setRequestHeader("Authorization", 'Bearer '+ jwt);
                    }
                }).done(function (response) {
                    successEditTask(response);
                }).fail(function ()  {
                    alert('You aren`t authorization');
                    window.location.replace('index.php');
                });
            }
        });

        //callback for success editing task
        function successEditTask(response) {
            let data =  JSON.parse(response);
            if(data.status == "OK") {
                alert('Task was successfully updated!');
                //close modal window
                $('#edit-window').hide();
                //render new description
                $(".edit-task[task_id='"+data.data[0].id+"']").siblings('.description').text(data.data[0].description);
            }
        }

        //close modal window
        $('.close-modal').on('click', function () {
            $('#edit-window').hide();
        });

        $('#form-edit-task').validate({ // initialize the plugin
            rules: {
                description: {
                    required: true,
                },
            }
        });
    })
</script>
