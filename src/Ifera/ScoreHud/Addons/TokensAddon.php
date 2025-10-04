<?php

declare(strict_types=1);

namespace Ifera\ScoreHud\Addons;

use Ifera\ScoreHud\addon\AddonBase;
use Ifera\ScoreHud\event\PlayerTagUpdateEvent;
use Ifera\ScoreHud\scoreboard\ScoreTag;
use onebone\tokenapi\TokenAPI;
use pocketmine\player\Player;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

class TokensAddon extends AddonBase implements Listener {

    public function onEnable(): void {
        $this->getOwner()->getServer()->getPluginManager()->registerEvents($this, $this->getOwner());
    }

    public function onJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $this->updateTokens($player);
    }

    public function updateTokens(Player $player): void {
        $coins = TokenAPI::getInstance()->myMoney($player);
        (new PlayerTagUpdateEvent(
            $this,
            $player,
            new ScoreTag("tokens.coins", (string)$coins)
        ))->call();
    }
}
