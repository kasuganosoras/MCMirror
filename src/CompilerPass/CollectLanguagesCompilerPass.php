<?php declare(strict_types=1);

namespace App\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class CollectLanguagesCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container): void
    {
        $rootDir = $container->getParameter('kernel.root_dir');
        $translationsPath = $rootDir . '/../translations';

        $finder = new Finder();
        $finder->files()->in($translationsPath)->name('messages.*.yml');

        $languages = [];
        foreach ($finder as $file) {
            $languageKey = explode('.', $file->getFilename())[1];

            $languageFileContent = Yaml::parseFile($file->getRealPath());

            $languages[$languageKey] = $languageFileContent['languageName'];
        }

        $container->setParameter('app.availableLanguages', $languages);
    }
}
