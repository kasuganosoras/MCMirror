<?php


namespace App\CompilerPass;


use App\Application\JsonApplication;
use Symfony\Component\Config\Resource\DirectoryResource;
use Symfony\Component\Config\Resource\FileResource;
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
    public function process(ContainerBuilder $container): void
    {
        $rootDir = $container->getParameter('kernel.root_dir');
        $applicationsPath = $rootDir . '/../applications';

        $categoriesFile = $applicationsPath . DIRECTORY_SEPARATOR . 'Categories.json';

        $container->addResource(new DirectoryResource($applicationsPath));
        $container->addResource(new FileResource($categoriesFile));

        $existingCategories = [];
        $folderFinder = new Finder();
        $folderFinder->directories()->in($applicationsPath);
        foreach ($folderFinder as $folder) {
            $container->addResource(new DirectoryResource($folder));
            
            $fileFinder = new Finder();
            $fileFinder->files()->in($folder->getRealPath());
            foreach ($fileFinder as $file) {
                $jsonData = json_decode($file->getContents(), true);
                $existingCategories[] = $jsonData['category'];

                $container->addResource(new FileResource($file->getRealPath()));

                $container->register('App\\Application\\JsonApplication\\' . $jsonData['name'])
                    ->setClass(JsonApplication::class)
                    ->setFactory([__CLASS__, 'createJsonApplication'])
                    ->setArgument(0, $jsonData)
                    ->addTag('app.application');

            }
        }

        $categoryOrder = json_decode(file_get_contents($categoriesFile), true);
        $existingCategories = array_keys(array_flip($existingCategories));

        $container->setParameter('application.categories', $this->getCategories($existingCategories, $categoryOrder));
    }

    private function getCategories(array $existingCategories, array $categoryOrder): array
    {
            $orderedCategories = [];

            foreach ($categoryOrder as $orderKey => $orderCategory) {
                if (\in_array($orderCategory, $existingCategories, true)) {
                    $orderedCategories[$orderKey] = $orderCategory;
                }
            }
            foreach ($existingCategories as $key => $category) {
                if (\in_array($category, $categoryOrder, true)) {
                    unset($existingCategories[$key]);
                    continue;
                }

                $orderedCategories[] = $category;
            }

            return $orderedCategories;
    }

    public function createJsonApplication(array $jsonData): JsonApplication
    {
        return new JsonApplication($jsonData);
    }
}

