<?php
include 'header.php';
?>
<?php
$actual_link = "http://$_SERVER[HTTP_HOST]";
$time = $_SERVER['REQUEST_TIME'];
$timeout_duration = 1800;
?>
<body>
    <div class="top-panel">
        <div class="row">
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-4 block-sort">
                        <div>User Name</div>
                        <div class="icons-block">
                            <a class="sort" column="user_name" order="ASC"><i class="fa fa-caret-up"></i></a>
                            <a class="sort" column="user_name" order="DESC"><i class="fa fa-caret-down"></i></a>
                        </div>
                    </div>
                    <div class="col-md-4 block-sort">
                        <div>User Email</div>
                        <div class="icons-block">
                             <a class="sort" column="user_email" order="ASC"><i class="fa fa-caret-up"></i></a>
                             <a class="sort" column="user_email" order="DESC"><i class="fa fa-caret-down"></i></a>
                        </div>
                    </div>
                    <div class="col-md-4 block-sort">
                        <div>Description</div>
                        <div class="icons-block">
                            <a class="sort" column="description" order="ASC"><i class="fa fa-caret-up"></i></a>
                            <a class="sort" column="description" order="DESC"><i class="fa fa-caret-down"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
                <button class="add-task" data-toggle="modal" data-target="#modal-add-task">New Task</button>
            </div>
            <div class="col-md-1">
                <button class="login" data-toggle="modal" data-target="#modal-window">Login</button>
            </div>
        </div>
    </div>

<!--modal window for login-->
    <div class="modal fade" id="modal-window"  data-toggle="modal" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-login">
                        <div class="form-group">
                           <label for="login">Login</label>
                           <input class="form-control" name="login" id="login" type="text">
                        </div>
                        <div class="form-group">
                            <label for="login">Password</label>
                            <input class="form-control" name="password" id="password" type="text">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" value="Login" id="modal-login">Send</button>
                </div>
            </div>
        </div>
    </div>

<!--modal window for adding new task-->
    <div class="modal fade" id="modal-add-task"  data-toggle="modal" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Add New Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-new-task" method="post" action="<?php echo $actual_link."/create-task" ; ?>">
                        <div class="form-group">
                            <label for="user_name">User Name</label>
                            <input class="form-control" name="user_name" id="user_name" type="text">
                        </div>
                        <div class="form-group">
                            <label for="user_email">Email</label>
                            <input class="form-control" name="user_email" id="user_email" type="text">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description"></textarea>
                        </div>
                        <input class="form-control" name="current_url" type="text" value="<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>" hidden>
                         <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="new-task">Save</button>
                         </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="title">Tasks List</div>
    <div class="container">
     <?php if($_COOKIE['response-status'] == "OK") : ?>
     <div class="success-msg"><?php echo $_COOKIE['response-message']; ?></div>
     <?php elseif($_COOKIE['response-status'] == "ERROR"):?>
     <div class="error-msg"><?php echo $_COOKIE['response-message']; ?></div>
    <?php endif;?>
<?php

foreach ($data as $task) {
    ?>
    <div class="row item">
        <div class="col-md-8 mx-auto">
            <?php echo $task["edited"] ? "<div class='block-mark'>Edited by admin</div>": ""; ?>
            <div class="item-title">Author name</div>
            <div><?php echo $task["user_name"]; ?></div>
            <div class="item-title">Author email</div>
            <div><?php echo $task["user_email"]; ?></div>
            <div class="item-title">Task description</div>
            <div><?php echo $task["description"]; ?></div>
            <label class="item-title">Done</label>
            <input type="checkbox" class="check-done" task_id="<?php echo $task["id"]; ?>" <?php echo $task["done"] == 1 ? "checked": ""?> >
        </div>
    </div>
<?php
}

?>
</div>
<!--<!--start pagination-->-->
<!--    <div class="block-pagination">-->
<!--        <ul class="pagination justify-content-center">-->
<!--            <li class="page-item">-->
<!--                <a class="page-link" href="--><?php //if($page == 1){ echo "?page=".$page;  } else { echo "?page=".($page - 1); } ?><!--" aria-label="Previous">-->
<!--                    <span aria-hidden="true">&laquo;</span>-->
<!--                    <span class="sr-only">Previous</span>-->
<!--                </a>-->
<!--            </li>-->
<!--            --><?php //$i = 1; while ($total_pages >= $i) :?>
<!--                <li class="page-item"><a class="page-link" href="?page=--><?php //echo $i;?><!--">--><?php //echo $i;?><!--</a></li>-->
<!--                --><?php //$i++;?>
<!--            --><?php //endwhile;?>
<!--            <li class="page-item">-->
<!--                <a class="page-link" href="--><?php //if($page == $total_pages){ echo "?page=".$page; } else { echo "?page=".($page + 1); } ?><!--" aria-label="Next">-->
<!--                    <span aria-hidden="true">&raquo;</span>-->
<!--                    <span class="sr-only">Next</span>-->
<!--                </a>-->
<!--            </li>-->
<!--        </ul>-->
<!--    </div>-->
<!--<!--end pagination-->-->

<!--start pagination-->
    <div class="block-pagination">
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a class="page-link" page="<?php if($page == 1){ echo $page;  } else { echo ($page - 1); } ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            <?php $i = 1; while ($total_pages >= $i) :?>
                <li class="page-item"><a class="page-link" page="<?php echo $i;?>"><?php echo $i;?></a></li>
                <?php $i++;?>
            <?php endwhile;?>
            <li class="page-item">
                <a class="page-link" page="<?php if($page == $total_pages){ echo $page; } else { echo ($page + 1); } ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </div>
<!--end pagination-->
</body>
<script type="text/javascript">
    $(document).ready(function () {
        // open modal window for authorization
        $('#btn-login').on('click', function () {
            $('.modal-window').show();
        });

        //send login form
        $('#modal-login').on('click', function () {
            //check validation
            if($('#form-login').valid()) {
                let data = $('#form-login').serialize();
                ajaxHandler('POST', 'login', data, msgLogin);
            }
        });

        //callback login function
        function msgLogin(response) {
            //if response has error
            if(response) {
                alert(JSON.parse(response));
            } else {
                window.location.replace("/admin"); //if login is success
            }
        }

        //change status 'done' of task
        $('.check-done').on('click', function () {
            let id = $(this).attr('task_id');
            let done = $(this).is(":checked") ? 1: 0 ;
            let data = { task_id:id, done: done };
            ajaxHandler('POST', 'change-status', data);
        });

        $('.sort').on('click', function() {
            let column = $(this).attr('column');
            let order = $(this).attr('order');
            let parameters = "?";
            let page = getParameterFromCurrentUrl("page");

            if(page != null) {
                parameters += "page=" + page + "&";
            }

            parameters += "column=" + column + "&order=" + order;

            let urlToRedirect =  "/index.php" + parameters;

            window.location.replace(urlToRedirect);
        });

        $('.page-link').on('click', function() {
            let page = $(this).attr('page');
            let searchParams= new URLSearchParams(window.location.search);
            let parameters = "?";
            let current_page = getParameterFromCurrentUrl("page");
            let urlToRedirect = "";
            if(current_page == null) {
                parameters += "page=" + page + "&" + searchParams;
                urlToRedirect =  "/index.php" + parameters;
            } else {
                let url = window.location.href;
                urlToRedirect = url.replace(/(page=).*?(&)/,'$1' + page + '$2');
            }
             window.location.replace(urlToRedirect);
        });

         function getParameterFromCurrentUrl(parameter) {
             let url = new URL(window.location.href);
             let query_string = url.search;
             let search_params = new URLSearchParams(query_string);
             return search_params.get(parameter);
         }

        $('#form-login').validate({ // initialize the plugin validation for form
            rules: {
                login: {
                    required: true,
                },
                password: {
                    required: true,
                    minlength: 3
                }
            }
        });

         $('#form-new-task').validate({ // initialize the plugin validation for form
            rules: {
                user_name: {
                    required: true,
                },
                user_email: {
                    required: true,
                    email: true
                },
                description: {
                    required: true,
                }
            }
        });
    })
</script>