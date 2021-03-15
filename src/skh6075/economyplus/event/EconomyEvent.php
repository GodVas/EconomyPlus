<?php

namespace skh6075\economyplus\event;

use pocketmine\event\Cancellable;
use pocketmine\event\Event;
use skh6075\economyplus\player\EconomyPlayer;

class EconomyEvent extends Event implements Cancellable{

    protected EconomyPlayer $player;

    protected float $amount;

    public function __construct(EconomyPlayer $player, float $amount) {
        $this->player = $player;
        $this->amount = $amount;
    }

    final public function getPlayer(): EconomyPlayer{
        return $this->player;
    }

    final public function getAmount(): float{
        return $this->amount;
    }

    final public function setAmount(float $amount): void{
        $this->amount = $amount;
    }
}