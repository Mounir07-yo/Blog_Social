<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PasswordResetController;

use App\Http\Controllers\MessageController;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Rediriger vers le blog
Route::get('/home', function () {
    return redirect()->route('posts.index');
});

// Routes d'authentification
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes pour la réinitialisation de mot de passe
Route::get('/forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');

// Routes pour le blog
Route::get('/blog', [PostController::class, 'index'])->name('posts.index');
Route::get('/blog/create', [PostController::class, 'create'])->name('posts.create')->middleware('auth');
Route::post('/blog', [PostController::class, 'store'])->name('posts.store')->middleware('auth');
Route::get('/blog/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/blog/{post}/edit', [PostController::class, 'edit'])->name('posts.edit')->middleware('auth');
Route::put('/blog/{post}', [PostController::class, 'update'])->name('posts.update')->middleware('auth');
Route::delete('/blog/{post}', [PostController::class, 'destroy'])->name('posts.destroy')->middleware('auth');

// Routes pour les commentaires
Route::middleware('auth')->group(function () {
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Routes pour les likes
Route::middleware('auth')->group(function () {
    Route::post('/posts/{post}/like', [LikeController::class, 'togglePost'])->name('posts.like');
    Route::post('/comments/{comment}/like', [LikeController::class, 'toggleComment'])->name('comments.like');
});

// Routes pour le suivi d'utilisateurs
Route::middleware('auth')->group(function () {
    Route::post('/users/{user}/follow', [FollowController::class, 'toggle'])->name('users.follow');
});

// Routes pour les profils utilisateurs
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/{user}/followers', [UserController::class, 'followers'])->name('users.followers');
Route::get('/users/{user}/following', [UserController::class, 'following'])->name('users.following');
Route::get('/search/users', [UserController::class, 'search'])->name('users.search');

// Routes pour l'édition de profil
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'update'])->name('profile.update');
});

// Routes pour les notifications
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::get('/api/notifications/count', [NotificationController::class, 'unreadCount'])->name('notifications.count');
    Route::get('/api/notifications/latest', [NotificationController::class, 'getLatest'])->name('notifications.latest');
});

// Routes pour l'upload d'images
Route::middleware('auth')->group(function () {
    Route::post('/upload/image', [ImageUploadController::class, 'upload'])->name('upload.image');
    Route::post('/upload/images', [ImageUploadController::class, 'uploadMultiple'])->name('upload.images');
    Route::delete('/upload/image', [ImageUploadController::class, 'delete'])->name('upload.delete');
});

// Routes pour les signalements
Route::middleware('auth')->group(function () {
    Route::post('/report', [ReportController::class, 'store'])->name('report.store');
});

// Route pour la suppression de compte
Route::middleware('auth')->group(function () {
    Route::delete('/profile/delete', [UserController::class, 'deleteAccount'])->name('profile.delete');
});

// Routes d'administration (réservées aux admins)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');
    Route::patch('/reports/{report}', [ReportController::class, 'update'])->name('reports.update');
    Route::delete('/reports/{report}/delete-user', [ReportController::class, 'deleteReportedUser'])->name('reports.delete-user');
});

// Routes de messagerie
Route::middleware('auth')->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{user}', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/api/messages/unread-count', [MessageController::class, 'getUnreadCount'])->name('messages.unread-count');
});
