<?php

namespace skh6075\economyplus;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use skh6075\economyplus\command\MyMoneyCommand;
use skh6075\economyplus\lang\PluginLang;
use skh6075\economyplus\player\EconomyPlayer;

final class EconomyPlus extends PluginBase implements Listener{
    use SingletonTrait;

    public function onLoad(): void{
        self::setInstance($this);
    }

    public function onEnable(): void{
        $this->saveDefaultConfig();
        $this->saveResource("lang/kor.yml");
        $this->saveResource("lang/eng.yml");
        PluginLang::getInstance()
            ->setLang($lang = $this->getServer()->getLanguage()->getLang())
            ->setTranslates(yaml_parse(file_get_contents($this->getDataFolder() . "lang/" . $lang . ".yml")));

        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getCommandMap()->registerAll(strtolower($this->getName()), [
            new MyMoneyCommand($this)
        ]);
    }

    public function onDisable(): void{
        foreach ($this->getServer()->getOnlinePlayers() as $player)
            $player->saveNBT();
    }

    /**
     * @param PlayerCreationEvent $event
     *
     * @ignoreCancelled false
     * @priority HIGHEST
     */
    public function onPlayerCreation(PlayerCreationEvent $event): void{
        $event->setPlayerClass(EconomyPlayer::class);
    }
}