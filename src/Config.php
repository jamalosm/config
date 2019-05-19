<?php


namespace BONE\Config;

use SplFileInfo;
use Illuminate\Config\Repository;
use Symfony\Component\Finder\Finder;

class Config
{

    public static function getInstance($configPath)
    {
        return new Repository(static::getItems($configPath));
    }

    private static function getItems($configPath)
    {
        $items = [];
        foreach (static::getConfigurationFiles($configPath) as $key => $path) {
            $items[$key] = require $path;
        }
        return $items;
    }

    /**
     * @param $configPath
     * @return array
     */
    private static function getConfigurationFiles($configPath)
    {
        $files = [];

        $configPath = realpath($configPath);

        foreach (static::getConfigurationFilesList($configPath) as $file) {
            $directory = static::getNestedDirectory($file, $configPath);

            $files[$directory . basename($file->getRealPath(), '.php')] = $file->getRealPath();
        }

        ksort($files, SORT_NATURAL);

        return $files;
    }

    /**
     * Get the configuration files in config path.
     *
     * @param $configPath
     * @return Finder
     */
    private static function getConfigurationFilesList($configPath)
    {
        return Finder::create()->files()->name('*.php')->in($configPath);
    }

    /**
     * Get the configuration file nesting path.
     *
     * @param SplFileInfo $file
     * @param string $configPath
     * @return string
     */
    private static function getNestedDirectory(SplFileInfo $file, $configPath)
    {
        $directory = $file->getPath();

        if ($nested = trim(str_replace($configPath, '', $directory), DIRECTORY_SEPARATOR)) {
            $nested = str_replace(DIRECTORY_SEPARATOR, '.', $nested) . '.';
        }

        return $nested;
    }

}