<?php


namespace App\CompilerPass;


use App\Application\JsonApplication;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;
use Symfony\Component\VarDumper\VarDumper;

class RegisterJsonApplicationsPass implements CompilerPassInterface
{

    /**
     * You can modify the container here before it is dumped to PHP code.
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $rootDir = $container->getParameter('kernel.root_dir');
        $applicationsPath = $rootDir . '/../applications';

        $finder = new Finder();
        $finder->files()->in($applicationsPath);

        foreach ($finder as $file) {
            $jsonData = json_decode($file->getContents(), true);

            $container->register('App\\Application\\JsonApplication\\' . $jsonData['name'])
                ->setClass(JsonApplication::class)
                ->setFactory([__CLASS__, 'createJsonApplication'])
                ->setArgument(0, $file->getRealPath())
                ->addTag('app.application');
        }
    }

    public function createJsonApplication(string $filePath): JsonApplication
    {
        return new JsonApplication(json_decode(file_get_contents($filePath), true));
    }
}

