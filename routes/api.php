    <?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Api\AuthController;
    use App\Http\Controllers\Api\FeedController;
    use App\Http\Controllers\Api\UploadController;

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {

        Route::get('/me', [AuthController::class, 'me']);

        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/feed/home', [FeedController::class, 'home']);

        Route::get('/feed/trending', [FeedController::class, 'trending']);

        Route::post('/video/upload', [UploadController::class, 'upload']);
    });