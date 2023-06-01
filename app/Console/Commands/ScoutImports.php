<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use MeiliSearch\Client;
use MeiliSearch\Exceptions\ApiException;

class ScoutImports extends Command
{

    protected $signature = 'scout:imports {model} {--flush} {--index=all}';

    protected $description = 'It is extend version of scout:import command with registering filterable and sortable fields';

    public function handle(Client $client): int
    {
        $model = $this->argument('model');
        $flag = $this->option('flush');
        $index = $this->option('index');

        if (class_exists($model)) {
            try {
                if ($flag) {
                    $this->comment('Flushing previous data...');
                    Artisan::call('scout:flush', [
                        'model' => $model,
                    ]);
                    $this->info('successfully flushed data.');
                }

                if ($index == 'all') {
                    $this->comment("Importing indexes of model including attributes $model ...");
                    Artisan::call('scout:import', [
                        'model' => $model,
                    ]);
                    $this->info('Index importing  records completed successfully!');
                    $this->comment("Updating searchable, filterable and sortable attributes for $model ...");
                    $client->index(app($model)->getTable())
                        ->updateSettings([
                            'searchableAttributes' => method_exists($model, 'searchableAttributes') ? $model::searchableAttributes() : Schema::getColumnListing(app($model)->getTable()),
                            'filterableAttributes' => method_exists($model, 'searchFilterableAttributes') ? $model::searchFilterableAttributes() : [],
                            'sortableAttributes' => method_exists($model, 'searchSortableAttributes') ? $model::searchSortableAttributes() : [],
                        ]);
                    $this->info('Successfully updated indexes and attributes.');
                } else if ($index == 'attrs' or $index == 'attributes') {
                    $this->comment('indexing attributes only...');
                    $client->index(app($model)->getTable())
                        ->updateSettings([
                            'searchableAttributes' => method_exists($model, 'searchableAttributes') ? $model::searchableAttributes() : Schema::getColumnListing(app($model)->getTable()),
                            'filterableAttributes' => method_exists($model, 'searchFilterableAttributes') ? $model::searchFilterableAttributes() : [],
                            'sortableAttributes' => method_exists($model, 'searchSortableAttributes') ? $model::searchSortableAttributes() : [],
                        ]);
                    $this->info('Successfully indexed attributes.');
                } else {
                    $this->comment("Importing indexes of model including attributes $model ...");
                    Artisan::call('scout:import', [
                        'model' => $model,
                    ]);
                    $this->info('Index importing  records completed successfully!');
                }
            } catch (ApiException $apiException) {
                $this->error($apiException->getMessage());

                return self::FAILURE;
            } catch (Exception $exception) {
                $this->error($exception->getMessage());

                return self::FAILURE;
            }
        } else {
            $this->error("$model is not found!");

            return self::INVALID;
        }

        return 0;
    }
}
