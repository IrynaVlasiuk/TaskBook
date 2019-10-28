<?php

if($_GET['url'] == 'index.php') {
    if(isset($_GET['column']) && isset($_GET['order'])) {
         HomeController::index($_GET['page'], $_GET['column'], $_GET['order']);
    } else {
        HomeController::index($_GET['page'], '', '');
    }
}

Route::set('create-task', function()
{
    TaskController::create($_POST);
});

Route::set('change-status', function()
{
    TaskController::changeStatusTask($_POST);
});

Route::set('login', function()
{
    AuthController::loginUser($_POST);
});

Route::set('admin', function()
{
    AdminController::index();
});

Route::set('edit-task', function()
{
    AdminController::editTask($_POST);
});

Route::set('logout', function()
{
    AuthController::logout();
});

//test route for inserting data in database
Route::set('registration-admin', function()
{
    AuthController::registerUser();
});




