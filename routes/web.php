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

        Route::get('/', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.dashboard.index');

        Route::group(['prefix' => '/dms'], function () {
            //dashboard
            Route::group(['prefix' => '/dashboard'], function () {
                Route::get('/', [App\Http\Controllers\Admin\Dms\DashboardController::class, 'index'])->name('admin.dms.dashboard');
                Route::get('/revenue_statistics', [App\Http\Controllers\Admin\Dms\DashboardController::class, 'revenueStatistics'])->name('admin.dms.dashboard.revenue_statistics');
            });
            //category
            Route::group(['prefix' => '/category'], function () {
                Route::get('/', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.category.list');
                Route::get('/add', [App\Http\Controllers\Admin\CategoryController::class, 'addDetail'])->name('admin.category.add');
                Route::get('/{id?}/edit', [App\Http\Controllers\Admin\CategoryController::class, 'addDetail'])->name('admin.category.detail');
            });

            //coupons
            Route::group(['prefix' => '/coupon'], function () {
                Route::get('/', [App\Http\Controllers\Admin\CouponController::class, 'index'])->name('admin.coupon.list');
                Route::get('/add', [App\Http\Controllers\Admin\CouponController::class, 'addDetail'])->name('admin.coupon.add');
                Route::get('/{id?}/edit', [App\Http\Controllers\Admin\CouponController::class, 'addDetail'])->name('admin.coupon.detail');
                Route::post('/delete', [App\Http\Controllers\Admin\CouponController::class, 'delete'])->name('admin.coupon.delete');
                Route::post('/store',[App\Http\Controllers\Admin\CouponController::class, 'store'])->name('admin.coupon.store');
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

            //download id
            Route::group(['prefix' => '/downloadids'], function(){
                Route::get('/', [App\Http\Controllers\Admin\DownloadIdController::class, 'index'])->name('admin.downloadids.list');
            });

            //tag
            Route::group(['prefix' => 'tag'], function () {
                Route::get('/', [App\Http\Controllers\Admin\TagController::class, 'index'])->name('admin.tag.list');
                Route::get('/add', [App\Http\Controllers\Admin\TagController::class, 'detail'])->name('admin.tag.add');
                Route::get('/edit/{id}', [App\Http\Controllers\Admin\TagController::class, 'detail'])->name('admin.tag.edit');
                Route::post('/store', [App\Http\Controllers\Admin\TagController::class, 'store'])->name('admin.tag.store');
                Route::post('/delete', [App\Http\Controllers\Admin\TagController::class, 'delete'])->name('admin.tag.delete');
            });

            //config
            Route::group(['prefix' => 'config'], function () {
                Route::get('/', [App\Http\Controllers\Admin\ConfigController::class, 'index'])->name('admin.dms.config');
                Route::post('/store', [App\Http\Controllers\Admin\ConfigController::class, 'store'])->name('admin.dms.config.store');
            });

            //order
            Route::group(['prefix' => 'order'], function () {
                Route::get('/', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin.order.list');
                Route::get('/add', [App\Http\Controllers\Admin\OrderController::class, 'detail'])->name('admin.order.add');
                Route::get('/edit/{id}', [App\Http\Controllers\Admin\OrderController::class, 'detail'])->name('admin.order.edit');
                Route::post('/store', [App\Http\Controllers\Admin\OrderController::class, 'store'])->name('admin.order.store');
                Route::post('/delete', [App\Http\Controllers\Admin\OrderController::class, 'delete'])->name('admin.order.delete');
                Route::post('/getUsers', [App\Http\Controllers\Admin\OrderController::class, 'getUsers'])->name('admin.order.getUsers');
                Route::post('/getUserByReferralCode', [App\Http\Controllers\Admin\OrderController::class, 'getUserByReferralCode'])->name('admin.order.getUserByReferralCode');
            });

            //message
            Route::group(['prefix' => 'message'], function () {
                Route::get('/', [App\Http\Controllers\Admin\MessageController::class, 'index'])->name('admin.dms.message');
                Route::post('/store', [App\Http\Controllers\Admin\MessageController::class, 'store'])->name('admin.dms.message.store');
            });

            //document
            Route::group(['prefix' => 'document'], function () {
                Route::get('/', [App\Http\Controllers\Admin\DocumentController::class, 'index'])->name('admin.dms.document.index');
                Route::get('/add', [App\Http\Controllers\Admin\DocumentController::class, 'detail'])->name('admin.dms.document.add');
                Route::get('/edit/{id}', [App\Http\Controllers\Admin\DocumentController::class, 'detail'])->name('admin.dms.document.edit');
                Route::post('/store', [App\Http\Controllers\Admin\DocumentController::class, 'store'])->name('admin.dms.document.store');
                Route::post('/delete', [App\Http\Controllers\Admin\DocumentController::class, 'delete'])->name('admin.dms.document.delete');
                Route::post('/searching_file', [App\Http\Controllers\Admin\DocumentController::class, 'getFileByPath'])->name('admin.dms.document.search.file');
            });

            //files
            Route::group(['prefix' => 'file'], function () {
                Route::get('/', [App\Http\Controllers\Admin\FileController::class, 'index'])->name('admin.dms.file');
                Route::get('/upload', [App\Http\Controllers\Admin\FileController::class, 'addDetail'])->name('admin.dms.file.detail');
                Route::post('/store', [App\Http\Controllers\Admin\FileController::class, 'store'])->name('admin.dms.file.store');
                Route::post('/delete', [App\Http\Controllers\Admin\FileController::class, 'delete'])->name('admin.dms.file.delete');
            });

            //pages
            Route::group(['prefix' => '/page'], function () {
                Route::get('/', [App\Http\Controllers\Admin\PageController::class, 'index'])->name('admin.page.list');
                Route::get('/add', [App\Http\Controllers\Admin\PageController::class, 'addDetail'])->name('admin.page.add');
                Route::get('/{id?}/edit', [App\Http\Controllers\Admin\PageController::class, 'addDetail'])->name('admin.page.detail');
                Route::post('/delete', [App\Http\Controllers\Admin\PageController::class, 'delete'])->name('admin.page.delete');
                Route::post('/store',[App\Http\Controllers\Admin\PageController::class, 'store'])->name('admin.page.store');
            });
        });
        Route::group(['prefix' => '/helpdesk'], function () {
            //article
            Route::group(['prefix' => '/article'], function () {
                Route::get('/', [HelpdeskArticleController::class, 'index'])->name('admin.helpdesk.articles.list');
                Route::get('/add', [HelpdeskArticleController::class, 'addDetail'])->name('admin.helpdesk.articles.add');
                Route::get('/{id?}/edit', [HelpdeskArticleController::class, 'addDetail'])->name('admin.helpdesk.articles.detail');
                Route::post('/delete', [HelpdeskArticleController::class, 'delete'])->name('admin.helpdesk.articles.delete');
                Route::post('/store',[HelpdeskArticleController::class, 'store'])->name('admin.helpdesk.articles.store');
            });

            //label
            Route::group(['prefix' => '/label'], function () {
                Route::get('/', [HelpdeskLabelController::class, 'index'])->name('admin.helpdesk.label.list');
                Route::get('/add', [HelpdeskLabelController::class, 'addDetail'])->name('admin.helpdesk.label.add');
                Route::get('/{id?}/edit', [HelpdeskLabelController::class, 'addDetail'])->name('admin.helpdesk.label.detail');
                Route::post('/delete', [HelpdeskLabelController::class, 'delete'])->name('admin.helpdesk.label.delete');
                Route::post('/store',[HelpdeskLabelController::class, 'store'])->name('admin.helpdesk.label.store');
            });

            //status
            Route::group(['prefix' => '/status'], function () {
                Route::get('/', [HelpdeskStatusController::class, 'index'])->name('admin.helpdesk.status.list');
                Route::get('/add', [HelpdeskStatusController::class, 'addDetail'])->name('admin.helpdesk.status.add');
                Route::get('/{id?}/edit', [HelpdeskStatusController::class, 'addDetail'])->name('admin.helpdesk.status.detail');
                Route::post('/delete', [HelpdeskStatusController::class, 'delete'])->name('admin.helpdesk.status.delete');
                Route::post('/store',[HelpdeskStatusController::class, 'store'])->name('admin.helpdesk.status.store');
                Route::post('/ordering', [HelpdeskStatusController::class, 'updateOrdering'])->name('admin.helpdesk.status.ordering');
            });

            //category
            Route::group(['prefix' => '/category'], function () {
                Route::get('/', [HelpdeskCategoryController::class, 'index'])->name('admin.helpdesk.category.list');
                Route::get('/add', [HelpdeskCategoryController::class, 'addDetail'])->name('admin.helpdesk.category.add');
                Route::post('/ordering', [HelpdeskCategoryController::class, 'updateOrdering'])->name('admin.helpdesk.category.ordering');
                Route::get('/{id?}/edit', [HelpdeskCategoryController::class, 'addDetail'])->name('admin.helpdesk.category.detail');
                Route::post('/delete', [HelpdeskCategoryController::class, 'delete'])->name('admin.helpdesk.category.delete');
                Route::post('/store',[HelpdeskCategoryController::class, 'store'])->name('admin.helpdesk.category.store');
            });

            //priority
            Route::group(['prefix' => '/priority'], function () {
                Route::get('/', [HelpdeskPriorityController::class, 'index'])->name('admin.helpdesk.priority.list');
                Route::get('/add', [HelpdeskPriorityController::class, 'addDetail'])->name('admin.helpdesk.priority.add');
                Route::get('/{id?}/edit', [HelpdeskPriorityController::class, 'addDetail'])->name('admin.helpdesk.priority.detail');
                Route::post('/delete', [HelpdeskPriorityController::class, 'delete'])->name('admin.helpdesk.priority.delete');
                Route::post('/store',[HelpdeskPriorityController::class, 'store'])->name('admin.helpdesk.priority.store');
                Route::post('/ordering', [HelpdeskPriorityController::class, 'updateOrdering'])->name('admin.helpdesk.priority.ordering');
            });

            //message
            Route::group(['prefix' => '/emails'], function () {
                Route::get('/', [HelpdeskEmailController::class, 'index'])->name('admin.helpdesk.email');
                Route::post('/store', [HelpdeskEmailController::class, 'store'])->name('admin.helpdesk.email.store');
            });

            //config
            Route::group(['prefix' => 'config'], function () {
                Route::get('/', [HelpdeskConfigController::class, 'index'])->name('admin.helpdesk.config');
                Route::post('/store', [HelpdeskConfigController::class, 'store'])->name('admin.helpdesk.config.store');
            });
            Route::group(['prefix' => '/ticket'], function () {
                Route::get('/', [HelpdeskTicketController::class, 'index'])->name('admin.helpdesk.ticket.list');
                Route::get('/add', [HelpdeskTicketController::class, 'addDetail'])->name('admin.helpdesk.ticket.add');
                Route::get('/{id?}/edit', [HelpdeskTicketController::class, 'addDetail'])->name('admin.helpdesk.ticket.detail');
                Route::post('/delete', [HelpdeskTicketController::class, 'delete'])->name('admin.helpdesk.ticket.delete');
                Route::post('/store',[HelpdeskTicketController::class, 'store'])->name('admin.helpdesk.ticket.store');
                Route::post('/storeComments',[HelpdeskTicketController::class, 'storeComments'])->name('admin.helpdesk.ticket.storeComments');
                Route::post('/update',[HelpdeskTicketController::class, 'update'])->name('admin.helpdesk.ticket.update');
                Route::get('/downloadFile/{id}/{name}/{folder}',[HelpdeskTicketController::class, 'downloadFile'])->name('admin.helpdesk.ticket.downloadFile');
                Route::get('/report', [HelpdeskTicketController::class, 'indexReport'])->name('admin.helpdesk.ticket.report.list');
            });
            //activity
            Route::group(['prefix' => '/activity'], function () {
                Route::get('/', [ActivitiesReportController::class, 'index'])->name('admin.helpdesk.activity');
            });
        });

        //post
        Route::group(['prefix' => 'post'], function () {
            Route::get('/', [PostController::class, 'index'])->name('admin.post.list');
            Route::get('/add', [PostController::class, 'addDetail'])->name('admin.post.add');
            Route::get('/{id?}/edit', [PostController::class, 'addDetail'])->name('admin.post.detail');
            Route::post('/delete', [PostController::class, 'delete'])->name('admin.post.delete');
            Route::post('/store', [PostController::class, 'store'])->name('admin.post.store');
            Route::post('/upload-image', [PostController::class, 'uploadImage'])->name('admin.post.upload.image');
            Route::post('/remove-image', [PostController::class, 'removeImage'])->name('admin.post.remove.image');
            Route::post('/get-image-info', [PostController::class, 'getImageInfo'])->name('admin.post.getimage.infor');
        });

        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [UserController::class, 'index'])->name('admin.user.list');
            Route::get('/add', [UserController::class, 'addDetail'])->name('admin.user.add');
            Route::get('/{id?}/edit', [UserController::class, 'addDetail'])->name('admin.user.detail');
            Route::post('/delete', [UserController::class, 'delete'])->name('admin.user.delete');
            Route::post('/store', [UserController::class, 'store'])->name('admin.user.store');
        });
        Route::group(['prefix' => 'tag'], function () {
            Route::get('/', [App\Http\Controllers\Admin\TagController::class, 'index'])->name('admin.tags.list');
            Route::get('/add', [App\Http\Controllers\Admin\TagController::class, 'add'])->name('admin.tags.add');
            Route::post('/store', [App\Http\Controllers\Admin\TagController::class, 'store'])->name('admin.tags.store');
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\TagController::class, 'edit'])->name('admin.tags.edit');
            Route::post('/update/{id}', [App\Http\Controllers\Admin\TagController::class, 'update'])->name('admin.tags.update');
            Route::post('/delete/{id}', [App\Http\Controllers\Admin\TagController::class, 'delete'])->name('admin.tags.delete');
        });

        Route::group(['prefix' => 'member'], function () {
            Route::get('/', [UserController::class, 'index'])->name('admin.member.list');
            Route::get('/add', [UserController::class, 'addDetail'])->name('admin.member.add');
            Route::get('/{id?}/edit', [UserController::class, 'addDetail'])->name('admin.member.detail');
            Route::post('/delete', [UserController::class, 'delete'])->name('admin.member.delete');
            Route::post('/store', [UserController::class, 'store'])->name('admin.member.store');
            Route::post('/randomCode', [UserController::class, 'ajaxGetRandomCode'])->name('admin.member.randomCode');
        });

        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [MemberController::class, 'index'])->name('admin.list');
            Route::get('/add', [MemberController::class, 'addDetail'])->name('admin.add');
            Route::get('/{id?}/edit', [MemberController::class, 'addDetail'])->name('admin.detail');
            Route::post('/delete', [MemberController::class, 'delete'])->name('admin.delete');
            Route::post('/store', [MemberController::class, 'store'])->name('admin.store');
        });

        Route::group(['prefix' => 'questions'], function () {
            Route::get('/', [QuestionController::class, 'index'])->name('admin.questions.list');
            Route::get('/{id?}/edit', [QuestionController::class, 'addDetail'])->name('admin.questions.detail');
            Route::post('/delete', [QuestionController::class, 'delete'])->name('admin.questions.delete');
            Route::post('/store', [QuestionController::class, 'update'])->name('admin.questions.store');
        });

        Route::group(['prefix' => 'answers'], function () {
            Route::get('/', [AnswersController::class, 'index'])->name('admin.answers.list');
            Route::get('/{id?}/edit', [AnswersController::class, 'addDetail'])->name('admin.answers.detail');
            Route::post('/delete', [AnswersController::class, 'delete'])->name('admin.answers.delete');
            Route::post('/store', [AnswersController::class, 'update'])->name('admin.answers.store');
        });

        Route::group(['prefix' => 'setting'], function () {
            Route::get('/', [SettingController::class, 'index'])->name('setting.index');
            Route::post('/social/store', [SettingController::class, 'socialStore'])->name('admin.setting.social.store');
            Route::post('/store', [SettingController::class, 'store'])->name('admin.setting.store');
            Route::post('/policy/store', [SettingController::class, 'policyStore'])->name('admin.setting.policy.store');
            Route::post('/upload-image', [SettingController::class, 'uploadImage'])->name('admin.setting.upload.image');
            Route::post('/remove-image', [SettingController::class, 'removeImage'])->name('admin.setting.remove.image');
            Route::post('/get-image-info', [SettingController::class, 'getImageInfo'])->name('admin.setting.getimage.infor');
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
