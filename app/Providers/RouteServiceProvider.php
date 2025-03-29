<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\article\frontend\CategoryController as CategoryControllerArticle;
use App\Http\Controllers\article\frontend\ArticleController;
use App\Http\Controllers\product\frontend\CategoryController as CategoryControllerProduct;
use App\Http\Controllers\product\frontend\ProductController;
use App\Http\Controllers\media\frontend\CategoryController as CategoryControllerMedia;
use  App\Http\Controllers\media\frontend\MediaController;
use App\Http\Controllers\components\ComponentsController;
use App\Http\Controllers\course\backend\CourseCategoryController;
use App\Http\Controllers\course\frontend\CourseCategoryController as FrontendCourseCategoryController;
use App\Http\Controllers\course\frontend\CourseController;
use App\Http\Controllers\quiz\frontend\QuizController;
use Session;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();
        $this->routes(function (Request $request) {
            $segments = request()->segments();
            $last  = end($segments);
            $first = reset($segments);
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web-backend.php'));
            if (in_array($first, config('app.alt_langs'))) {
                Route::middleware('web')
                    ->namespace($this->namespace)
                    ->group(base_path('routes/web-frontend-en.php'));
            } else {
                Route::middleware('web')
                    ->namespace($this->namespace)
                    ->group(base_path('routes/web-frontend-vi.php'));
            }
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web-frontend.php'));

            if (!empty($segments)) {
                if (in_array($first, config('app.alt_langs'))) {
                    $checkURL = DB::table('router')->select('module')->where('slug', $last)->where('alanguage', $first)->first();
                } else {
                    $checkURL = DB::table('router')->select('module')->where('slug', $first)->where('alanguage', 'vi')->first();
                }
                if (!empty($checkURL)) {
                    if (in_array($first, config('app.alt_langs'))) {
                        // if ($checkURL->module == 'category_products') {
                        //     Route::get('/' . $first . '/{slug}', [CategoryControllerProduct::class, 'index'])->middleware(['web', 'locale'])->where(['slug' => '.+'])->name('routerURL');
                        // }
                        // if ($checkURL->module == 'products') {
                        //     Route::get('/' . $first . '/{slug}', [ProductController::class, 'index'])->middleware(['web', 'locale'])->where(['slug' => '.+'])->name('routerURL');
                        // }
                        if ($checkURL->module == 'category_articles') {
                            Route::get('/' . $first . '/{slug}', [CategoryControllerArticle::class, 'index'])->middleware(['web', 'locale'])->where(['slug' => '.+'])->name('routerURL');
                        }
                        if ($checkURL->module == 'articles') {
                            Route::get('/' . $first . '/{slug}', [ArticleController::class, 'index'])->middleware(['web', 'locale'])->where(['slug' => '.+'])->name('routerURL');
                        }
                        if ($checkURL->module == 'category_media') {
                            Route::get('/' . $first . '/{slug}', [CategoryControllerMedia::class, 'index'])->middleware(['web', 'locale'])->where(['slug' => '.+'])->name('routerURL');
                        }
                        if ($checkURL->module == 'media') {
                            Route::get('/' . $first . '/{slug}', [MediaController::class, 'index'])->middleware(['web', 'locale'])->where(['slug' => '.+'])->name('routerURL');
                        }
                        // if ($checkURL->module == 'course_categories') {
                        //     Route::get('/' . $first . '/{slug}', [FrontendCourseCategoryController::class, 'index'])->middleware(['web', 'locale'])->where(['slug' => '.+'])->name('routerURL');
                        // }
                        // if ($checkURL->module == 'courses') {
                        //     Route::get('/' . $first . '/{slug}', [CourseController::class, 'index'])->middleware(['web', 'locale'])->where(['slug' => '.+'])->name('routerURL');
                        // }
                        // if ($checkURL->module == 'quizzes') {
                        //     Route::get('/' . $first . '/{slug}', [QuizController::class, 'quiz'])->middleware(['web', 'locale'])->where(['slug' => '.+'])->name('routerURL');
                        // }
                    } else {
                        // if ($checkURL->module == 'category_products') {
                        //     Route::get('/{slug}', [CategoryControllerProduct::class, 'index'])->middleware(['web', 'locale'])->where(['slug' => '.+'])->name('routerURL');
                        // }
                        // if ($checkURL->module == 'products') {
                        //     Route::get('/{slug}', [ProductController::class, 'index'])->middleware(['web', 'locale'])->where(['slug' => '.+'])->name('routerURL');
                        // }
                        // if ($checkURL->module == 'course_categories') {
                        //     Route::get('/{slug}', [FrontendCourseCategoryController::class, 'index'])->middleware(['web', 'locale'])->where(['slug' => '.+'])->name('routerURL');
                        // }
                        // if ($checkURL->module == 'courses') {
                        //     Route::get('/{slug}', [CourseController::class, 'index'])->middleware(['web', 'locale'])->where(['slug' => '.+'])->name('routerURL');
                        // }
                        // if ($checkURL->module == 'quizzes') {
                        //     Route::get('/{slug}', [QuizController::class, 'quiz'])->middleware(['web', 'locale'])->where(['slug' => '.+'])->name('routerURL');
                        // }
                        if ($checkURL->module == 'category_articles') {
                            Route::get('/{slug}', [CategoryControllerArticle::class, 'index'])->middleware(['web', 'locale'])->where(['slug' => '.+'])->name('routerURL');
                        }
                        if ($checkURL->module == 'articles') {
                            Route::get('/{slug}', [ArticleController::class, 'index'])->middleware(['web', 'locale'])->where(['slug' => '.+'])->name('routerURL');
                        }
                        if ($checkURL->module == 'category_media') {
                            Route::get('/{slug}', [CategoryControllerMedia::class, 'index'])->middleware(['web', 'locale'])->where(['slug' => '.+'])->name('routerURL');
                        }
                        if ($checkURL->module == 'media') {
                            Route::get('/{slug}', [MediaController::class, 'index'])->middleware(['web', 'locale'])->where(['slug' => '.+'])->name('routerURL');
                        }
                    }
                } else {
                    if (in_array($first, config('app.alt_langs'))) {
                        Route::get('/' . $first . '/{slug}', [ProductController::class, 'index'])->middleware(['web', 'locale'])->where(['slug' => '.+'])->name('routerURL');
                    } else {
                        Route::get('/{slug}', [ProductController::class, 'index'])->middleware(['web', 'locale'])->where(['slug' => '.+'])->name('routerURL');
                    }
                }
            }
        });
    }
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
