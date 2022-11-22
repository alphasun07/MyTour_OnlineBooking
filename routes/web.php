<?php

use App\Http\Controllers\Admin\PostController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Front\RegisterInformationController;
use App\Http\Controllers\Front\PostController as frontPostController;
use App\Http\Controllers\Front\ForumController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\AnswersController;
use App\Http\Controllers\Admin\Helpdesk\HelpdeskArticleController;
use App\Http\Controllers\Front\DocumentController;
use App\Http\Controllers\Front\PayPalController;
use App\Http\Controllers\Front\DownloadController;
use App\Http\Controllers\Front\CategoryController;
use App\Http\Controllers\Front\ContactController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\SupportTicketsController;
use App\Http\Controllers\Admin\Helpdesk\HelpdeskLabelController;
use App\Http\Controllers\Admin\Helpdesk\HelpdeskStatusController;
use App\Http\Controllers\Admin\Helpdesk\HelpdeskCategoryController;
use App\Http\Controllers\Admin\Helpdesk\HelpdeskConfigController;
use App\Http\Controllers\Admin\Helpdesk\HelpdeskPriorityController;
use App\Http\Controllers\Admin\Helpdesk\HelpdeskEmailController;
use App\Http\Controllers\Admin\Helpdesk\HelpdeskTicketController;
use App\Http\Controllers\Admin\Helpdesk\ActivitiesReportController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('all-top');
});*/

Auth::routes();
Route::get('/admin/login', [App\Http\Controllers\Auth\LoginController::class, 'showAdminLoginForm']);
Route::get('/admin/register', [App\Http\Controllers\Auth\RegisterController::class, 'showAdminRegisterForm']);
Route::post('/admin/login', [App\Http\Controllers\Auth\LoginController::class, 'adminLogin'])->name('admin.login');
Route::post('/admin/register', [App\Http\Controllers\Auth\RegisterController::class, 'registerAdmin'])->name('admin-register');

Route::get('/admin/password/reset', [App\Http\Controllers\Auth\AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
Route::post('/admin/password/email', [App\Http\Controllers\Auth\AdminForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');
Route::get('/admin/password/reset/{token}', [App\Http\Controllers\Auth\AdminResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');
Route::post('/admin/password/reset', [App\Http\Controllers\Auth\AdminResetPasswordController::class, 'reset'])->name('admin.password.update');
Route::group(['middleware' => [App\Http\Middleware\CheckLogin::class]], function () {

    Route::group(['prefix' => 'admin/'], function () {

        Route::get('/', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.dms.dashboard');

        //category
        Route::group(['prefix' => '/category'], function () {
            Route::get('/', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.category.list');
            Route::get('/add', [App\Http\Controllers\Admin\CategoryController::class, 'addDetail'])->name('admin.category.add');
            Route::get('/{id?}/edit', [App\Http\Controllers\Admin\CategoryController::class, 'addDetail'])->name('admin.category.detail');
        });

        //product/category
        Route::group(['prefix' => '/product/category/'], function () {
            Route::post('/store', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('admin.category.store');
            Route::post('/delete', [App\Http\Controllers\Admin\CategoryController::class, 'delete'])->name('admin.category.delete');
            Route::post('/ordering', [App\Http\Controllers\Admin\CategoryController::class, 'updateOrdering'])->name('admin.category.ordering');
            Route::post('/upload-image', [App\Http\Controllers\Admin\CategoryController::class, 'uploadImage'])->name('admin.category.upload.image');
            Route::post('/remove-image', [App\Http\Controllers\Admin\CategoryController::class, 'removeImage'])->name('admin.category.remove.image');
            Route::post('/get-image-info', [App\Http\Controllers\Admin\CategoryController::class, 'getImageInfo'])->name('admin.category.getimage.infor');
        });

        //user
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [MemberController::class, 'index'])->name('admin.list');
            Route::get('/add', [MemberController::class, 'addDetail'])->name('admin.add');
            Route::get('/{id?}/edit', [MemberController::class, 'addDetail'])->name('admin.detail');
            Route::post('/delete', [MemberController::class, 'delete'])->name('admin.delete');
            Route::post('/store', [MemberController::class, 'store'])->name('admin.store');
        });

        //member
        Route::group(['prefix' => 'member'], function () {
            Route::get('/', [UserController::class, 'index'])->name('admin.member.list');
            Route::get('/add', [UserController::class, 'addDetail'])->name('admin.member.add');
            Route::get('/{id?}/edit', [UserController::class, 'addDetail'])->name('admin.member.detail');
            Route::post('/delete', [UserController::class, 'delete'])->name('admin.member.delete');
            Route::post('/store', [UserController::class, 'store'])->name('admin.member.store');
            Route::post('/randomCode', [UserController::class, 'ajaxGetRandomCode'])->name('admin.member.randomCode');
        });

        //tour
        Route::group(['prefix' => 'tour'], function () {
            Route::get('/', [App\Http\Controllers\Admin\TourController::class, 'index'])->name('admin.tour.list');
            Route::get('/add', [App\Http\Controllers\Admin\TourController::class, 'detail'])->name('admin.tour.add');
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\TourController::class, 'detail'])->name('admin.tour.detail');
            Route::post('/store', [App\Http\Controllers\Admin\TourController::class, 'store'])->name('admin.tour.store');
            Route::post('/delete', [App\Http\Controllers\Admin\TourController::class, 'delete'])->name('admin.tour.delete');
            Route::post('/upload-image', [App\Http\Controllers\Admin\TourController::class, 'uploadImage'])->name('admin.tour.upload.image');
            Route::post('/remove-image', [App\Http\Controllers\Admin\TourController::class, 'removeImage'])->name('admin.tour.remove.image');
            Route::post('/get-image-info', [App\Http\Controllers\Admin\TourController::class, 'getImageInfo'])->name('admin.tour.getimage.infor');
        });

        //place
        Route::group(['prefix' => 'place'], function () {
            Route::get('/', [App\Http\Controllers\Admin\PlaceController::class, 'index'])->name('admin.place.list');
            Route::get('/add', [App\Http\Controllers\Admin\PlaceController::class, 'addDetail'])->name('admin.place.add');
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\PlaceController::class, 'addDetail'])->name('admin.place.detail');
            Route::post('/store', [App\Http\Controllers\Admin\PlaceController::class, 'store'])->name('admin.place.store');
            Route::post('/delete', [App\Http\Controllers\Admin\PlaceController::class, 'delete'])->name('admin.place.delete');
        });

        //place
        Route::group(['prefix' => 'service'], function () {
            Route::get('/', [App\Http\Controllers\Admin\ServiceController::class, 'index'])->name('admin.service.list');
            Route::get('/add', [App\Http\Controllers\Admin\ServiceController::class, 'detail'])->name('admin.service.add');
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\ServiceController::class, 'detail'])->name('admin.service.detail');
            Route::post('/store', [App\Http\Controllers\Admin\ServiceController::class, 'store'])->name('admin.service.store');
            Route::post('/delete', [App\Http\Controllers\Admin\ServiceController::class, 'delete'])->name('admin.service.delete');
        });
    });
});


Route::group(['middleware' => 'locale'], function() {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showUserLoginForm'])->name('user.showLoginForm');
    Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showUserRegisterForm'])->name('user.showRegisterForm');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'userLogin'])->name('login');
    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'userRegister'])->name('user.register');

    Route::get('/password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');

    Route::get('/', [App\Http\Controllers\Front\TopController::class, 'index'])->name('front.home');
    Route::get('/change-language/{language}', [App\Http\Controllers\Front\TopController::class, 'changeLanguage'])->name('home.change_language');
    Route::get('/profile/{id}', [App\Http\Controllers\Front\TopController::class, 'showProfile'])->name('home.profile.show');
    Route::post('/profile/store', [App\Http\Controllers\Front\TopController::class, 'updateProfile'])->name('home.profile.update')->middleware('auth');

    Route::post('/register_information/store', [RegisterInformationController::class, 'store'])->name('home.register_information.store');

    Route::group(['prefix' => 'post'], function () {
        Route::get('/', [frontPostController::class, 'filterList'])->name('home.post.search');
        Route::get('/detail/{id}', [frontPostController::class, 'show'])->name('home.post.show');
        Route::get('/{category_id}', [frontPostController::class, 'listPosts'])->name('home.post.list');
    });

    Route::group(['prefix' => 'category'], function() {
        Route::get('/{category_id}', [App\Http\Controllers\Front\CategoryController::class, 'show'])->name('home.category.show');
    });

    Route::group(['prefix' => 'document'], function() {
        Route::get('/{id}', [DocumentController::class, 'detail'])->name('home.document.detail');
        Route::get('/{id}/checkout', [PayPalController::class, 'index'])->name('checkout.payment')->middleware('checkFrontLogin');
        Route::get('/{id}/download', [DocumentController::class, 'download'])->name('home.document.download');
    });

    Route::get('/about/{id}', [frontPostController::class, 'aboutUs'])->name('home.about.us');

    Route::post('/contact/store', [ContactController::class, 'sendContact'])->name('home.contact.store');

    Route::get('/contact', [ContactController::class, 'contact'])->name('home.post.contact');

    Route::group(['prefix' => 'forum'], function () {
        Route::get('/', [ForumController::class, 'listQuestions'])->name('forum.question.list');

        Route::group(['middleware' => 'limtCount'], function() {
            Route::get('/questions/{id}', [forumController::class, 'listAnswers'])->name('forum.question.answer');
        });

        Route::group(['middleware' => 'auth'], function() {
            Route::post('/sends/questions', [
                'middleware' => 'auth',
                'as'=>'forum.question.store',
                'uses' => 'Front\ForumController@store']);
            Route::post('/questions/store', [forumController::class, 'StoreAnswers'])->name('forum.question.answer.store');
            Route::post('/vote/store', [forumController::class, 'updateVote'])->name('forum.vote.update');
            Route::post('/answer/delete', [forumController::class, 'deleteAnswer'])->name('forum.question.answer.delete');
        });
    });

    Route::post('/coupon/check', [App\Http\Controllers\Admin\CouponController::class, 'check'])->name('coupon.check');
    Route::post('/referral/check', [App\Http\Controllers\Admin\OrderController::class, 'getUserByReferralCode'])->name('referral.check');

    Route::group([
        'prefix' => 'checkout/payment',
        'middleware' => 'checkFrontLogin'
    ], function() {
        Route::get('/create', [PayPalController::class, 'paymentCreate'])->name('checkout.payment.create');
        Route::get('/status', [PayPalController::class, 'paymentStatus'])->name('checkout.payment.status');
        Route::get('/list', [PayPalController::class, 'paymentList'])->name('checkout.payment.list');
        Route::get('/detail', [PayPalController::class, 'paymentDetail'])->name('checkout.payment.detail');
    });

    Route::group([
        'prefix' => 'download',
        'middleware' => 'checkFrontLogin'
    ], function() {
        Route::get('/', [DownloadController::class, 'index'])->name('download.list');
        Route::get('/export_invoice/{id}', [DownloadController::class, 'exportInvoice'])->name('download.export.invoice');
    });

    Route::group([
        'prefix' => 'support-tickets',
        'middleware' => 'checkFrontLogin'
    ], function() {
        Route::get('/', [SupportTicketsController::class, 'index'])->name('support-tickets.index');
        Route::get('/{id}/detail', [SupportTicketsController::class, 'detail'])->name('support-tickets.detail');
        Route::get('/add', [SupportTicketsController::class, 'new'])->name('support-tickets.add');
        Route::post('/store', [SupportTicketsController::class, 'store'])->name('support-tickets.store');
        Route::post('/update', [SupportTicketsController::class, 'update'])->name('support-tickets.update');
        Route::post('/store-comment', [SupportTicketsController::class, 'storeComment'])->name('support-tickets.store-comment');
        Route::get('/downloadFile/{id}/{name}/{folder}',[HelpdeskTicketController::class, 'downloadFile'])->name('support-tickets.downloadFile');
    });

    Route::get('/{slug}', [PageController::class, 'detail'])->name('home.article.detail');
});
