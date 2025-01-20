<?php

declare(strict_types=1);

namespace UniVers;

class ProtocolHandler {

    private int $minProtocol;
    private int $maxProtocol;
    private string $kickMessageOld;
    private string $kickMessageNew;
    private array $playerProtocols = [];

    public function __construct(int $minProtocol, int $maxProtocol, string $kickMessageOld, string $kickMessageNew) {
        $this->minProtocol = $minProtocol;
        $this->maxProtocol = $maxProtocol;
        $this->kickMessageOld = $kickMessageOld;
        $this->kickMessageNew = $kickMessageNew;
    }

    public function setPlayerProtocol(string $playerName, int $protocol): void {
        $this->playerProtocols[$playerName] = $protocol;
    }

    public function getPlayerProtocol(string $playerName): ?int {
        return $this->playerProtocols[$playerName] ?? null;
    }

    public function checkProtocol(int $protocol): ?string {
        if ($protocol < $this->minProtocol) {
            return $this->kickMessageOld;
        } elseif ($protocol > $this->maxProtocol) {
            return $this->kickMessageNew;
        }
        return null;
    }
}
