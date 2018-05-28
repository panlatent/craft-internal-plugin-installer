<?php

namespace panlatent\craft\composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Package\Loader\ArrayLoader;
use Composer\Package\Loader\JsonLoader;
use Composer\Plugin\PluginInterface;
use Composer\Script\Event;
use Composer\Script\ScriptEvents;

class Plugin implements PluginInterface
{
    /**
     * @var Installer
     */
    protected $installer;

    public function activate(Composer $composer, IOInterface $io)
    {
        $this->installer = new Installer($io, $composer);

        $composer->getEventDispatcher()->addListener(ScriptEvents::POST_INSTALL_CMD, [$this, 'installInternalPluginHandle']);
    }

    public function installInternalPluginHandle(Event $e)
    {
        $extra = $e->getComposer()->getPackage()->getExtra();
        if (isset($extra['craft-internal-plugin'])) {
            foreach ($extra['craft-internal-plugin'] as $packageName => $path) {
                $package = (new JsonLoader(new ArrayLoader()))->load($path);
                $this->installer->addPlugin($package);
            }
        }
    }
}