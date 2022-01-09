<?php

require_once '../vendor/autoload.php';
require_once '../vendor/altorouter/altorouter/AltoRouter.php';
use App\Entity\Users;
use App\Controller\HomeController;
use App\Controller\UsersController;
use App\Controller\Administrator\AdminHomeController;
use App\Controller\Administrator\AdminPostsController;
use App\Controller\BlogsPostsController;

/**
 * @author Amidou Roukoumanou <roukoumanouamidou@gmail.com>
 * Cette page sert de routeur pour tout le site
 * On n'y retrouve les routes de l'application
 */

$router = new AltoRouter();

// map homepage
$router->map('GET', '/', function() {
    (new HomeController())->index();
}, 'home');

// map registerpage
$router->map('GET|POST', '/registration', function() {
    (new UsersController())->registration();
}, 'registration');

$router->map('GET', '/blogs', function(){
    (new BlogsPostsController())->posts();
}, 'blogs');

$router->map('GET', '/post-[i:id]', function($id){
    (new BlogsPostsController())->showPost($id);
}, 'view_post');

// map user Connect Page
$router->map('GET|POST', '/login', function() {
    (new UsersController())->login();
}, 'login');

// map user DesConnect Page
$router->map('GET', '/logout', function() {
    (new UsersController())->logout();
}, 'logout');

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];

    // map user update account Page
    $router->map('GET', '/profil', function(){
        (new UsersController())->profil();
    }, 'profil');
    
    // map user update account Page
    $router->map('GET|POST', '/account-update', function(){
        (new UsersController())->updateAccount();
    }, 'account_update');

    $router->map('GET|POST', '/password-update', function(){
        (new UsersController())->updatePassword();
    }, 'password_update');

    if ($user['role'] === Users::ROLE_ADMIN) {
        // map admin homepage
        $router->map('GET', '/admin', function() {
            (new AdminHomeController())->adminIndex();
        }, 'admin_home');

        $router->map('GET|POST', '/admin-new-post', function(){
            (new AdminPostsController())->newPost();
        }, 'new_post');

        $router->map('GET|POST', '/admin-update-post-[i:id]', function($id){
            (new AdminPostsController())->updatePost($id);
        }, 'update_post');

        $router->map('GET', '/admin-delete-post-[i:id]', function($id){
            (new AdminPostsController())->deletePost($id);
        }, 'admin_delete_post');

        $router->map('GET', '/admin-posts', function(){
            (new AdminPostsController())->postList();
        }, 'posts_list');
    }
}
