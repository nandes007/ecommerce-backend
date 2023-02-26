<?php

namespace App\Console\Commands\Helper;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateService extends Command
{
    protected $signature = 'generate:service {serviceName}';

    protected $description = 'Generate Service';

    public function handle()
    {
        $serviceArgs = $this->argument('serviceName');
        $serviceParams = explode('/', $serviceArgs);
        if (count($serviceParams) > 1) {
            $serviceName = end($serviceParams);
            array_pop($serviceParams);
            $directory = implode('/', $serviceParams);
            $dirNamespace = implode('\\', $serviceParams);
            $serviceDirectory = app_path('Services/'.$directory);
            $namespace = "App\\Services\\$dirNamespace";
        } else {
            $serviceName = $serviceParams[0];
            $serviceDirectory = app_path('Services');
            $namespace = "App\\Services";
        }
        $serviceClassName = $serviceName;
        $serviceImplementationClassName = $serviceName . 'Impl';

        if (!File::exists($serviceDirectory)) {
            File::makeDirectory($serviceDirectory, 0755, true);
        }

        $serviceClassPath = $serviceDirectory  . '/' . $serviceClassName . '.php';
        $serviceImplementationClassPath = $serviceDirectory . '/' . $serviceImplementationClassName . '.php';
        $serviceContent = "<?php\n\nnamespace $namespace;\n\ninterface $serviceClassName\n{\n\n}";
        $serviceImplementationContent = "<?php\n\nnamespace $namespace;\n\nclass $serviceImplementationClassName implements $serviceClassName\n{\n\n}";

        File::put($serviceClassPath, $serviceContent);
        File::put($serviceImplementationClassPath, $serviceImplementationContent);

        $serviceProviderPath = app_path('Providers/AppServiceProvider.php');

        $serviceProviderContents = File::get($serviceProviderPath);

        $serviceProviderContents = str_replace(
            ['{{ServiceNamespace}}', '{{ServiceClassName}}'],
            ['App\Services', $serviceClassName],
            $serviceProviderContents
        );

        File::put($serviceProviderPath, $serviceProviderContents);

        $this->info('Service classes generated successfully!');
    }
}
