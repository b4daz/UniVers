<?php

declare(strict_types=1);

namespace IndexDev\UniVers;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {

    private Config $config;

    protected function onEnable(): void {
        $this->loadConfiguration();

        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("UniVers is enabled");
    }

    private function loadConfiguration(): void {
        $this->saveResource("config.json");
        $this->config = new Config($this->getDataFolder() . "config.json", Config::JSON);
    }

    public function onPreLogin(PlayerPreLoginEvent $event): void {
        $playerInfo = $event->getPlayerInfo();
        $protocol = $playerInfo->getProtocolVersion();

        $minProtocol = $this->config->get("minimumProtocol", 0);
        $maxProtocol = $this->config->get("maximumProtocol", PHP_INT_MAX);
        $kickMessageOld = $this->config->get("kickMessageOld", "Your version is too old. Please update to join the server.");
        $kickMessageNew = $this->config->get("kickMessageNew", "Your version is too new. Please downgrade to join the server.");

        if ($protocol < $minProtocol) {
            $event->setKickMessage($kickMessageOld);
            $event->cancel();
        } elseif ($protocol > $maxProtocol) {
            $event->setKickMessage($kickMessageNew);
            $event->cancel();
        }
    }
}
