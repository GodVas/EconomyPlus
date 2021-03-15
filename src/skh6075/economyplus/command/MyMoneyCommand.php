<?php

namespace skh6075\economyplus\command;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use skh6075\economyplus\lang\PluginLang;
use skh6075\economyplus\player\EconomyPlayer;
use skh6075\economyplus\traits\EconomyWonFormatTrait;

final class MyMoneyCommand extends PluginCommand{
    use EconomyWonFormatTrait;

    public function __construct(Plugin $owner) {
        parent::__construct(PluginLang::getInstance()->format("mymoney.command.name", [], false), $owner);
        $this->setDescription(PluginLang::getInstance()->format("mymoney.command.description", [], false));
        $this->setPermission("mymoney.permission");
    }

    public function execute(CommandSender $player, string $label, array $args): bool{
        if (!$player instanceof EconomyPlayer) {
            $player->sendMessage(PluginLang::getInstance()->format("command.use.only.ingame"));
            return false;
        }

        if (!$this->testPermission($player)) {
            return false;
        }

        $format = "";
        $lang = Server::getInstance()->getLanguage()->getLang();
        switch ($lang) {
            case "kor":
                $format = $this->koreanWonFormat($player->myMoney(), PluginLang::getInstance()->format("money-format", [], false));
                break;
            case "eng":
                $format = $this->wonFormat($player->myMoney(), PluginLang::getInstance()->format("money-format", [], false));
                break;
            default:
                break;
        }

        $player->sendMessage(PluginLang::getInstance()->format("mymoney.command.result", ["%format%" => $format]));
        return true;
    }
}