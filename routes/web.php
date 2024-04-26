<?php


use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\SubSubCategoryController;
use Illuminate\Support\Facades\Route;

//use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('admin/index');
// });



Route::get('/',[HomeController::class, 'index']);
Route::get('/detail/{slug}/{id}',[HomeController::class, 'blog_show'])->name('blog_show');
Route::get('/show-image/{id}',[HomeController::class, 'show_image'])->name('show-image');
Route::get('/remember-me',[HomeController::class, 'remember_me'])->name('remember-me');
Route::post('/login-post',[AuthController::class,'login_post'])->name('admin-login-post');
Route::get('/login',[AuthController::class,'login']);
//Route::get('/admin-panel',[DashboardController::class, 'index'])->name('admin-index');
//Route::post('/register',[AuthController::class,'register'])->name('register');

Route::post('/test',[HomeController::class,'login_post'])->name('test');

Route::group(['prefix'=>'admin-panel','middleware'=>\App\Http\Middleware\checkAdmin::class],function (){

    Route::get('/',[DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile',[AdminController::class, 'profile'])->name('profile');
    Route::get('/notifications',[AdminController::class, 'notifications'])->name('notifications');
    Route::get('/admin-settings',[AdminController::class, 'admin_settings'])->name('admin-settings');
    Route::get('/check-email/{email}/{id?}',[AdminController::class, 'check_email'])->name('check-email');
    Route::get('/check-old-pw/{pw}',[AdminController::class, 'check_old_pw'])->name('check-old-pw');
    
    Route::post('/logout',[AuthController::class,'logout'])->name('logout');
    Route::post('/profile-post',[AdminController::class,'profile_post'])->name('profile-post');
    Route::post('/password-post',[AdminController::class,'password_post'])->name('password-post');


 
    Route::resource('users', UserController::class);
    Route::resource('blogs', BlogController::class);

    Route::group(['prefix'=>'blogs'],function(){
        Route::post('/update',[BlogController::class,'update'])->name('blogs-update');
        Route::get('/show-image/{type}/{id}',[BlogController::class,'show_image'])->name('show-image');
        Route::post('/delete',[BlogController::class,'destroy'])->name('blogs-delete');
        Route::get('/check-slug/{slug}/{id?}',[BlogController::class, 'check_slug'])->name('check-slug');
        Route::get('/show-blog-images/{blog_id}/{image_id?}/{rank?}',[BlogController::class, 'show_blog_images'])->name('show-blog-images');
        Route::get('/delete-blog-image/{image_id}',[BlogController::class, 'delete_blog_image'])->name('delete-blog-images');
      
    });


    Route::group(['prefix'=>'users'],function(){
        Route::post('/update',[UserController::class,'update'])->name('users-update');
        Route::post('/delete',[UserController::class,'destroy'])->name('users-delete');
    });
    Route::resource('categories', CategoryController::class);
    Route::group(['prefix'=>'categories'],function(){
    Route::post('/update',[CategoryController::class,'update'])->name('category-update');
    Route::post('/delete',[CategoryController::class,'destroy'])->name('category-delete');
    Route::get('/check-slug/{slug}/{id?}',[CategoryController::class, 'check_slug'])->name('check-slug');
    Route::get('/select-categories/{cat_id}',[CategoryController::class,'select_categories'])->name('select-categories');
    Route::get('/show-up-categories/{cat_id}',[CategoryController::class, 'show_up_categories'])->name('show-up-categories');
    Route::get('/show-sub-categories/{cat_id}',[CategoryController::class, 'show_sub_categories'])->name('show-sub-categories');
    Route::get('/show-category-images/{cat_id}/{image_id?}/{rank?}',[CategoryController::class, 'show_category_images'])->name('show-category-images');
    Route::get('/delete-category-image/{image_id}',[CategoryController::class, 'delete_category_image'])->name('delete-category-images');
    Route::get('/show-image/{type}/{id}',[CategoryController::class,'show_image'])->name('show-image');
    Route::get('/categories-div/{cat_id}',[CategoryController::class,'categories_div'])->name('categories-div');
 
        });
      
});
