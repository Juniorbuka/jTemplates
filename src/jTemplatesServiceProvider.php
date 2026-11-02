<?php

namespace Jevo\jTemplates;

use EvolutionCMS\ServiceProvider;
use RuntimeException;

class jTemplatesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadPluginsFrom(dirname(__DIR__) . '/plugins/');
    }

    public function boot(): void
    {
        $siteRoot = defined('MODX_BASE_PATH') ? rtrim(MODX_BASE_PATH, '/\\') : public_path();
        $assetsPath = $siteRoot . '/assets/plugins/jTemplates';
        $configPath = $assetsPath . '/configs';

        $this->ensureDirectory($configPath);
        $this->migrateLegacyConfig($siteRoot . '/assets/plugins/jtemplates/configs', $configPath);
        $this->migrateLegacyConfig($siteRoot . '/assets/plugins/templatesedit/configs', $configPath);

        if ($this->app->runningInConsole() || (defined('IN_MANAGER_MODE') && IN_MANAGER_MODE)) {
            $this->publishAssets(dirname(__DIR__) . '/assets/plugins/jTemplates', $assetsPath);
        }
    }

    private function ensureDirectory(string $directory): void
    {
        if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
            throw new RuntimeException(sprintf('Unable to create jTemplates directory: %s', $directory));
        }
    }

    private function migrateLegacyConfig(string $source, string $destination): void
    {
        if (!is_dir($source)) {
            return;
        }

        foreach (glob(rtrim($source, '/\\') . '/*') ?: [] as $file) {
            if (is_link($file) || !is_file($file)) {
                continue;
            }

            $target = $destination . '/' . basename($file);
            if (!file_exists($target) && !copy($file, $target)) {
                throw new RuntimeException(sprintf('Unable to migrate jTemplates config: %s', $file));
            }
        }
    }

    private function publishAssets(string $source, string $destination): void
    {
        $this->ensureDirectory($destination);

        foreach (['.htaccess', 'css/builder.css', 'js/jTemplatesBuilder.js', 'js/Sortable.min.js'] as $asset) {
            $sourceFile = $source . '/' . $asset;
            $targetFile = $destination . '/' . $asset;
            $this->ensureDirectory(dirname($targetFile));

            if (!is_file($sourceFile)) {
                throw new RuntimeException(sprintf('jTemplates asset is missing: %s', $sourceFile));
            }

            if ($asset === '.htaccess' && is_file($targetFile)) {
                continue;
            }

            if (is_file($targetFile) && hash_file('sha256', $sourceFile) === hash_file('sha256', $targetFile)) {
                continue;
            }

            if (!copy($sourceFile, $targetFile)) {
                throw new RuntimeException(sprintf('Unable to publish jTemplates asset: %s', $targetFile));
            }
        }

        $example = $source . '/configs/custom_fields.example.php';
        $targetExample = $destination . '/configs/custom_fields.example.php';
        if (is_file($example) && !is_file($targetExample) && !copy($example, $targetExample)) {
            throw new RuntimeException(sprintf('Unable to publish jTemplates example config: %s', $targetExample));
        }
    }
}
