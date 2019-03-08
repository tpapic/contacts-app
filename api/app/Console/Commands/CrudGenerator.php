<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CrudGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:generator {name : Class (singular) for example User}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create CRUD operations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $name = $this->argument('name');

      $this->controller($name);
      $this->model($name);
      $this->request($name);

      $this->error('To finish CRUD you must also add Migration, Routes, Model fields and Validation rules!!!!');
    }

    protected function getStub($type)
    {
      return file_get_contents(resource_path("stubs/$type.stub"));  
    }

    protected function model($name)
    {
      $modelTemplate = str_replace(
          ['{{modelName}}'],
          [$name],
          $this->getStub('Model')
      );

      file_put_contents(app_path("/{$name}.php"), $modelTemplate);
    }

    protected function controller($name)
    {
        $controllerTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $name,
                strtolower(str_plural($name)),
                strtolower($name)
            ],
            $this->getStub('Controller')
        );

        file_put_contents(app_path("/Api/V1/Controllers/{$name}Controller.php"), $controllerTemplate);
    }

    protected function request($name)
    {
        $requestTemplate = str_replace(
          [
            '{{modelName}}',
            '{{modelNameSingularLowerCase}}'
          ],
          [
            $name,
            strtolower($name)
          ],
            $this->getStub('Request')
        );

        if(!file_exists($path = app_path('/Api/V1/Requests')))
            mkdir($path, 0755, true);

        file_put_contents(app_path("/Api/V1/Requests/{$name}Request.php"), $requestTemplate);
    }
}
