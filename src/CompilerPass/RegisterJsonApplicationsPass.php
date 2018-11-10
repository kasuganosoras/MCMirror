<?php


namespace App\CompilerPass;


use App\Service\JsonApplicationService;
use App\Structs\JsonApplication;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;

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
                ->setArgument(0, $jsonData)
                ->addTag('app.application');
        }
    }

    public function createJsonApplication($jsonData): JsonApplication
    {
        return new JsonApplication($jsonData);
    }
}

