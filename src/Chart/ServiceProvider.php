<?php

namespace Fjord\Chart;

use Carbon\CarbonInterface;
use Fjord\Chart\Engine\ApexEngine;
use Illuminate\Database\Eloquent\Builder;
use Fjord\Chart\Engine\ChartEngineResolver;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register the application services
     *
     * @return void
     */
    public function register()
    {
        $this->macros();

        $this->registerChartEngineResolver();

        $this->registerChartFactory();
    }

    /**
     * Register chart factory.
     *
     * @return void
     */
    public function registerChartFactory()
    {
        $this->app->singleton('fjord.chart.factory', function () {
            return new ChartFactory($this->app['fjord.chart.engine.resolver']);
        });
    }

    /**
     * Register EngineResolver.
     *
     * @return void
     */
    public function registerChartEngineResolver()
    {
        $this->app->singleton('fjord.chart.engine.resolver', function () {
            $resolver = new ChartEngineResolver;

            $this->registerApexEngine($resolver);

            return $resolver;
        });
    }

    /**
     * Register ApexEngine.
     *
     * @param ChartEngineResolver $resolver
     * @return void
     */
    public function registerApexEngine(ChartEngineResolver $resolver)
    {
        $resolver->register('apex', function () {
            return new ApexEngine;
        });
    }

    /**
     * Register chart macros.
     *
     * @return void
     */
    public function macros()
    {
        Builder::macro(
            'whereInSecond',
            fn ($column, CarbonInterface $time) => $this
                ->whereBetween($column, [
                    $time->copy()->startOfSecond(),
                    $time->copy()->endOfSecond(),
                ])
        );

        Builder::macro(
            'whereInMinute',
            fn ($column, CarbonInterface $time) => $this
                ->whereBetween($column, [
                    $time->copy()->startOfMinute(),
                    $time->copy()->endOfMinute(),
                ])
        );

        Builder::macro(
            'whereInHour',
            fn ($column, CarbonInterface $time) => $this
                ->whereBetween($column, [
                    $time->copy()->startOfHour(),
                    $time->copy()->endOfHour(),
                ])
        );

        Builder::macro(
            'whereInDay',
            fn ($column, CarbonInterface $time) => $this
                ->whereBetween($column, [
                    $time->copy()->startOfDay(),
                    $time->copy()->endOfDay(),
                ])
        );

        Builder::macro(
            'whereInWeek',
            fn ($column, CarbonInterface $time) => $this
                ->whereBetween($column, [
                    $time->copy()->startOfWeek(),
                    $time->copy()->endOfWeek(),
                ])
        );

        Builder::macro(
            'whereInMonth',
            fn ($column, CarbonInterface $time) => $this
                ->whereBetween($column, [
                    $time->copy()->startOfMonth(),
                    $time->copy()->endOfMonth(),
                ])
        );

        Builder::macro(
            'whereInYear',
            fn ($column, CarbonInterface $time) => $this
                ->whereBetween($column, [
                    $time->copy()->startOfYear(),
                    $time->copy()->endOfYear(),
                ])
        );

        Builder::macro(
            'whereInDecade',
            fn ($column, CarbonInterface $time) => $this
                ->whereBetween($column, [
                    $time->copy()->startOfDecade(),
                    $time->copy()->startOfDecade(),
                ])
        );
    }
}
