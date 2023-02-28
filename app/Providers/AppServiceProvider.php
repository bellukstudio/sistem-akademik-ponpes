<?php

namespace App\Providers;

use App\Helpers\UtilHelper;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
        date_default_timezone_set('Asia/Jakarta');
        // currency
        Blade::directive('currency', function ($expression) {
            return "<?php echo number_format($expression,0,',','.'); ?>";
        });
        // view gdrive
        Blade::directive('gdrive', function ($id) {
            $data = "<?php echo $id ?>";
            return "https://drive.google.com/uc?export=view&id=$data";
        });

        Blade::directive('scoreRange', function ($expression) {
            $data = UtilHelper::scoreRange($expression);
            return "<?php echo $data; ?>";
        });
    }
}
