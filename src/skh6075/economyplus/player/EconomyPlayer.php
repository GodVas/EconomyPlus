<?php

namespace skh6075\economyplus\player;

use pocketmine\Player;
use skh6075\economyplus\EconomyPlus;
use skh6075\economyplus\event\AddMoneyEvent;
use skh6075\economyplus\event\ReduceMoneyEvent;

final class EconomyPlayer extends Player{

    private float $money;

    protected function initEntity(): void{
        parent::initEntity();
        $this->money = $this->namedtag->getFloat("money", EconomyPlus::getInstance()->getConfig()->getNested("default-money", 1000.0));
    }

    public function saveNBT(): void{
        parent::saveNBT();
        $this->namedtag->setFloat("money", $this->money);
    }

    public function myMoney(): float{
        return $this->money;
    }

    public function getMoney(): float{
        return $this->myMoney();
    }

    public function addMoney(float $amount): bool{
        $event = new AddMoneyEvent($this, $amount);
        $event->call();
        if (!$event->isCancelled()) {
            $this->money += $event->getAmount();
            return true;
        }

        return false;
    }

    public function reduceMoney(float $amount): bool{
        $event = new ReduceMoneyEvent($this, $amount);
        $event->call();
        if (!$event->isCancelled()) {
            $this->money -= $event->getAmount();
            if ($this->money < 0)
                $this->money = 0;

            return true;
        }

        return false;
    }

    public function setMoney(float $amount): void{
        if ($amount < 0)
            $amount = 0;

        $this->money = $amount;
    }
}