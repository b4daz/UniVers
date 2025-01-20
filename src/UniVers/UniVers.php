<?php

declare(strict_types=1);

namespace UniVers;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class UniVers extends PluginBase implements Listener {

    private Config $config;

    public function onEnable(): void {
        $this->saveResource("config.json");
        $this->config = new Config($this->getDataFolder() . "config.json", Config::JSON);

        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("UniVers enabled successfully.");
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
            $this->getLogger()->info("Player {$playerInfo->getUsername()} was kicked for using an old protocol: {$protocol}.");
        } elseif ($protocol > $maxProtocol) {
            $event->setKickMessage($kickMessageNew);
            $event->cancel();
            $this->getLogger()->info("Player {$playerInfo->getUsername()} was kicked for using a new protocol: {$protocol}.");
        }
    }
}
