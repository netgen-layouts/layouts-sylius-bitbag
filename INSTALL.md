# Netgen Layouts, Sylius eCommerce & BitBag Sylius CMS integration installation instructions

## Use Composer to install the integration

Run the following command to install Netgen Layouts, Sylius eCommerce & BitBag Sylius CMS integration:

```
composer require netgen/layouts-sylius-bitbag
```

Include routing configuration:

```yaml
layouts_sylius_bitbag:
    resource: "@NetgenLayoutsSyliusBitBagBundle/Resources/config/routing.yaml"
```
