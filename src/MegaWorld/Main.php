<?php
namespace MegaWorld;

use MegaWorld\Commands\MegaWorldCommand;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;

class Main extends PluginBase{
    use SingletonTrait;

    public function onLoad(): void{
        self::setInstance($this);
    }

    public function onEnable(): void{
        Server::getInstance()->getCommandMap()->registerAll($this->getName(), $this[
            new MegaWorldCommand
        ]);
    }
}
