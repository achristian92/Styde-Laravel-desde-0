<?php

namespace App\Providers;

use App\Http\ViewComposers\UserFieldsComposer;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        View::composer(['users.create','users.edit'],UserFieldsComposer::class);
        Blade::directive('render', function ($expression){
            $parts = explode(',',$expression,2);
            $component = $parts[0];
            $args = trim($parts[1] ?? '[]');

            return "<?php echo app('App\Http\ViewComponents\\\\'.{$component},{$args})->toHtml() ?>";

        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
