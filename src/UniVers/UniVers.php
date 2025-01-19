<?php

declare(strict_types=1);

namespace UniVers;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

class UniVers extends PluginBase implements Listener {

    private $config;

    public function onEnable(): void {
        $this->saveDefaultConfig();
        $this->config = $this->getConfig();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onPreLogin(PlayerPreLoginEvent $event): void {
        $playerInfo = $event->getPlayerInfo();
        $protocol = $playerInfo->getProtocolVersion();
        $supportedProtocols = $this->config->get("accepted_protocols", []);

        if (!in_array($protocol, $supportedProtocols, true)) {
            $event->setKickMessage($this->config->get("kickMessage", "Tu versión no es compatible con este servidor."));
            $event->cancel();
        }
    }

    public function onPlayerJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $deviceInfo = $player->getPlayerInfo()->getExtraData();
        $clientVersion = $deviceInfo["GameVersion"] ?? "Desconocida";

        $joinMessage = $this->config->get("joinMessage", "¡Bienvenido al servidor!");
        $event->setJoinMessage(str_replace("{version}", $clientVersion, $joinMessage));

        $this->checkVersionMismatch($player);
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
