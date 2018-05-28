<?php

namespace panlatent\craft\composer;

use Composer\Package\PackageInterface;

class Installer extends \craft\composer\Installer
{
    public function addPlugin(PackageInterface $package)
    {
        parent::addPlugin($package);
    }
}