<?php

declare(strict_types=1);

namespace UniVers;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\RequestNetworkSettingsPacket;
use pocketmine\utils\Config;

class UniVers extends PluginBase implements Listener {

    private ProtocolHandler $protocolHandler;

    public function onEnable(): void {
        $this->saveResource("config.json");
        $configData = new Config($this->getDataFolder() . "config.json", Config::JSON);

        $this->protocolHandler = new ProtocolHandler(
            $configData->get("minimumProtocol", 0),
            $configData->get("maximumProtocol", PHP_INT_MAX),
            $configData->get("kickMessageOld", "Your version is too old. Please update to join the server."),
            $configData->get("kickMessageNew", "Your version is too new. Please downgrade to join the server.")
        );

        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("UniVers enabled successfully.");
    }

    public function onDataPacketReceive(DataPacketReceiveEvent $event): void {
        $packet = $event->getPacket();
        if ($packet instanceof RequestNetworkSettingsPacket) {
            $player = $event->getOrigin()->getPlayer();
            if ($player !== null) {
                $this->protocolHandler->setPlayerProtocol($player->getName(), $packet->getProtocolVersion());
            }
        }
    }

    public function onPlayerPreLogin(PlayerPreLoginEvent $event): void {
        $playerInfo = $event->getPlayerInfo();
        $protocol = $this->protocolHandler->getPlayerProtocol($playerInfo->getUsername());

        if ($protocol === null) {
            $this->getLogger()->warning("Failed to detect protocol for player {$playerInfo->getUsername()}.");
            return;
        }

        $kickMessage = $this->protocolHandler->checkProtocol($protocol);
        if ($kickMessage !== null) {
            $event->setKickMessage($kickMessage);
            $event->cancel();
        }
    }
}
