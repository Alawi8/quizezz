<?php
// routes/api.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Frontend\UserAnswersController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Sections\SectionsController;
use App\Http\Controllers\Frontend\StudentTestController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Questions\EnvQuestionsController;
use App\Http\Controllers\Sections\front\DisplayController;
use App\Http\Controllers\Admin\StatsController;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ImportController;
use Illuminate\Http\Request;

// ✅ AUTHENTICATION ROUTES
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// ✅ CHECK AUTH ROUTE
Route::middleware(['auth:sanctum'])->get('/check-auth', function (Request $request) {
    return response()->json([
        'id' => $request->user()->id,
        'name' => $request->user()->name,
        'email' => $request->user()->email,
        'roles' => $request->user()->getRoleNames(),
        'permissions' => $request->user()->getAllPermissions()->pluck('name'),
    ]);
});

// ✅ USER PROFILE ROUTES
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit']);
    Route::patch('/profile', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);
});

// ✅IMPORT ROUTES
Route::middleware(['auth:sanctum', 'role:super-admin|admin'])->prefix('import')->group(function () {
    Route::post('/questions', [ImportController::class, 'importQuestions']);
    // Route::post('/sections', [ImportController::class, 'importSections']);
    // Route::post('/users', [ImportController::class, 'importUsers']);
});




Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // ✅ ROUTES FOR STUDENTS
    Route::middleware('auth:sanctum' , 'role:super-admin|student')->prefix('student')->group(function () {
        Route::resource('questions', EnvQuestionsController::class);
        Route::post('/submit-answer', [UserAnswersController::class, 'submitAnswer']);
        Route::get('/user-answers', [UserAnswersController::class, 'getUserAnswers']);
        Route::get('/final-result/{test}', [EnvQuestionsController::class, 'finalResult']);
        Route::post('/clear-answers', [UserAnswersController::class, 'clearAnswers']);
        Route::get('/display', [DisplayController::class, 'index'])->name('tests.index');
        Route::get('/admin/questions/env', [EnvQuestionsController::class, 'index']);
        Route::get('/question/{test}/', [EnvQuestionsController::class, 'questionsByTest']);
        Route::get('/answers/{test_id}', [TestController::class, 'getQuestionsWithUserAnswers']);
    });

    // ✅ SUPER ADMIN ROUTES
    Route::middleware('auth:sanctum', 'role:super-admin|admin')->prefix('admin')->group(function () {
        Route::resource('questions', QuestionController::class)->names('admin.questions');
        Route::get('/tests/{test}/questions', [TestController::class, 'questions']);
        Route::get('/test/students', [StudentTestController::class, 'index'])->name('admin.questions');

        Route::get('/users', [UserManagementController::class, 'index']);
        Route::post('/users/{user}/update-role', [UserManagementController::class, 'updateRole']);
        Route::delete('/users/{user}', [UserManagementController::class, 'destroy']);
        Route::post('/users', [UserManagementController::class, 'store']);
        Route::get('/permissions', [UserManagementController::class, 'getPermissions']);
        Route::delete('/questions', [QuestionController::class, 'destroyAll']);

        Route::get('/roles', function () {
            return response()->json([
                'roles' => Role::pluck('name')
            ]);
        });

        Route::get('/stats', [StatsController::class, 'index']);
        Route::resource('section', SectionsController::class);
    });
});
