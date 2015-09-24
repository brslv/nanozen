<?php

namespace Nanozen\Providers\Config;

use Nanozen\Providers\Mode\ModeProvider as Mode;
use Nanozen\Contracts\Providers\Config\ConfigProviderContract;

/**
 * Class ConfigProvider
 *
 * @author brslv
 * @package Nanozen\Providers\Config
 */
class ConfigProvider implements ConfigProviderContract
{

    protected $config;

    const CONFIG_LIVE_FILE_LOCATION = '../config-live.json';

    const CONFIG_DEVELOPMENT_FILE_LOCATION = '../config-development.json';

    public function __construct()
    {
        $this->setConfig();
    }

    public function get($value)
    {
        if (empty($this->config))
        {
            throw new \Exception("No config information available");
        }

        if (trim($value) == "" || is_null($value))
        {
            return $this->config;
        }

        return $this->searchForConfigValue($value);
    }

    private function setConfig()
    {
        $file = self::CONFIG_DEVELOPMENT_FILE_LOCATION;

        if (Mode::get() == Mode::MODE_APP_LIVE) {
            $file = self::CONFIG_LIVE_FILE_LOCATION;
        }

        $this->config = json_decode(file_get_contents($file), true);
    }

    private function searchForConfigValue($value)
    {
        $pathElements = preg_split("/\./", $value, null, PREG_SPLIT_NO_EMPTY);
        $configArray = $this->config;

        for ($i = 0; $i < count($pathElements); $i++) {
            $currentElement = $pathElements[$i];

            if (!is_array($configArray) || !array_key_exists($currentElement, $configArray)) {
                throw new \InvalidArgumentException("Invalid config path [{$value}].");
            }

            $configArray = $configArray[$currentElement];

            if (!is_array($configArray) && $i == count($pathElements) - 1) {
                return $configArray;
            }

            // If nothing found.
            if ($i == count($pathElements) - 1) {
                throw new \InvalidArgumentException(
                    "Invalid config path [{$value}] or possible key repetition in the config array.");
            }
        }
    }

}