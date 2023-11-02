<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsSyliusBitBagBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\GlobFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Yaml\Yaml;

use function file_get_contents;

final class NetgenLayoutsSyliusBitBagExtension extends Extension implements PrependExtensionInterface
{
    /**
     * @param mixed[] $configs
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $locator = new FileLocator(__DIR__ . '/../Resources/config');

        $loader = new DelegatingLoader(
            new LoaderResolver(
                [
                    new GlobFileLoader($container, $locator),
                    new YamlFileLoader($container, $locator),
                ],
            ),
        );

        $loader->load('services/**/*.yaml', 'glob');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter(
            'netgen_layouts.sylius.bitbag.component_create_routes',
            $config['component_routes']['create'] ?? [],
        );

        $container->setParameter(
            'netgen_layouts.sylius.bitbag.component_update_routes',
            $config['component_routes']['update'] ?? [],
        );
    }

    public function prepend(ContainerBuilder $container): void
    {
        $prependConfigs = [
            'liip_imagine.yaml' => 'liip_imagine',
            'block_definitions.yaml' => 'netgen_layouts',
            'block_type_groups.yaml' => 'netgen_layouts',
            'block_types.yaml' => 'netgen_layouts',
            'value_types.yaml' => 'netgen_layouts',
            'query_types.yaml' => 'netgen_layouts',
            'item_types.yaml' => 'netgen_content_browser',
            'view/block_view.yaml' => 'netgen_layouts',
            'view/item_view.yaml' => 'netgen_layouts',
            'view/rule_target_view.yaml' => 'netgen_layouts',
            'doctrine.yaml' => 'doctrine',
            'framework/twig.yaml' => 'twig',
            'sylius_ui.yaml' => 'sylius_ui',
        ];

        foreach ($prependConfigs as $configFile => $prependConfig) {
            $configFile = __DIR__ . '/../Resources/config/' . $configFile;
            $config = Yaml::parse((string) file_get_contents($configFile));
            $container->prependExtensionConfig($prependConfig, $config);
            $container->addResource(new FileResource($configFile));
        }
    }
}
