# jTemplates

jTemplates customizes resource and template editing forms in Evolution CMS 3.5.7 or later.
It is installed as a Composer library and supports PHP 8.3 and newer.

## Installation

From the Evolution CMS `core/` directory, install the package with the CMS Composer command:

```bash
php artisan package:installrequire jevo/jtemplates "^0.1"
```

The Laravel service provider is discovered automatically. On the next manager request, jTemplates
publishes its CSS, JavaScript, and access-control file to `assets/plugins/jTemplates/`. Existing
published assets are updated from the package, while a site's `.htaccess` file is never overwritten.
Generated configurations are stored in `assets/plugins/jTemplates/configs/` and are preserved across
Composer updates. Config files from previous `assets/plugins/jtemplates/configs/` and
`assets/plugins/templatesedit/configs/` directories are copied over without replacing existing
jTemplates configs.

If TemplatesEdit is still installed, disable its old manager plugin to prevent both extensions from
handling the same events.

## Language

Ukrainian is the default language when no matching translation is available. English, Spanish, and
Dutch translations remain available. Russian translation files have been removed.

## Custom fields

Copy `assets/plugins/jTemplates/configs/custom_fields.example.php` to
`assets/plugins/jTemplates/configs/custom_fields.php` and edit the copy to define custom resource
fields.

## License

GPL-3.0-only
