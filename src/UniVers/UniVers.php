<?php

namespace UniVers;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerKickEvent;
use pocketmine\utils\Config;
use pocketmine\event\player\PlayerVersionEvent;

class UniVers extends PluginBase implements Listener {
    
    private $config;

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->saveDefaultConfig();
        $this->config = $this->getConfig();
    }

    public function onPlayerJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $version = $player->getClientVersion();

        if (!$this->isVersionCompatible($version)) {
            $kickMessage = str_replace("{version}", $version, $this->config->get("kickMessage"));
            $event->setJoinMessage($kickMessage);
            $player->kick($kickMessage);
        } else {
            $this->checkVersionMismatch($player);
        }
    }

    private function isVersionCompatible(int $version): bool {
        $acceptedProtocols = $this->config->get("accepted_protocols");
        return in_array($version, $acceptedProtocols);
    }

    private function checkVersionMismatch($player): void {
        $version = $player->getClientVersion();
        if ($version < min($this->config->get("accepted_protocols"))) {
            $message = $this->config->get("versionMismatchMessages")["older"];
        } elseif ($version > max($this->config->get("accepted_protocols"))) {
            $message = $this->config->get("versionMismatchMessages")["newer"];
        } else {
            return;
        }
        
        $player->sendMessage($message);
    }
}
