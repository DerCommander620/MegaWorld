<?php
namespace MegaWorld;

use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;

class Main extends PluginBase{

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
        switch($command->getName()){
            case "megaworld":
                if($sender instanceof Player){
                    if($sender->hasPermission("megaworld.cmd.use")){
                        switch(strtolower($args[0])){
                            case "create":
                                if(empty($args[1])){
                                    $sender->sendMessage("§cPlease enter the WorldName that you want do create!");
                                }
                                if(empty($args[2])){
                                    $sender->sendMessage("§cPlease enter a Generator name!");
                                }
                                if(!$args([2])->exist()){
                                    $sender->sendMessage("§cSorry but this Generator is not Found!");
                                }else{
                                    Server::getInstance()->getWorldManager()->generateWorld($args([1]), $args([2]));
                                    $sender->sendMessage("§aSuccessfully Generated the World " . $args([1]) . " §aWith the Generator: " . $args([2]));
                                }
                                break;
                            case "tp":
                                if(empty($args[1])){
                                    $sender->sendMessage("§cPlease enter a Player Name!");
                                }
                                if(empty($args[2])){
                                    $sender->sendMessage("§cPlease Enter A Location To Telepor the Player to!");
                                }else{
                                    $player = $this->getServer()->getPlayerExact($args([1]));
                                    $world = $args([2]);
                                    $player->teleport($world);
                                    $player->sendMessage("§aYou successfully teleported to the world: §e" . $world . " §aby the Player: §e" . $sender->getDisplayName());
                                    $sender->sendMessage("§aYou successfully Teleported ´" . $player . "´ To" . $world[1]);
                                }
                                break;
                            case "list":
                                $sender->sendMessage("§aList §7| §aMegaWorld§f\n§aWorlds: §e" . Server::getInstance()->getWorldManager()->getWorlds());
                                break;
                            case "help":
                                $sender->sendMessage("§eHelp §7| §aMegaWorld");
                                $sender->sendMessage("-§c/megaworld §ecreate <WorldName> <Generator>");
                                $sender->sendMessage("-§c/megaworld §etp <PlayerName> <WorldName>");
                                $sender->sendMessage("-§c/megaworld §elist");
                                $sender->sendMessage("-§c/megaworld help");
                                $sender->sendMessage("-§c/megaworld §eduplicate <WorldName> <Generator>");
                                $sender->sendMessage("-§c/megaworld §erename <WorldName> <newWorldName>");
                                $sender->sendMessage("-§c/megaworld §eworld setspawn");
                                break;
                            case "duplicate":
                                $world = $args([1]);
                                $generator = $args([2]);
                                if(!$world->exist()){
                                    $sender->sendMessage("§cThis world doesnt exist!");
                                }
                                if(!$generator->exist()){
                                    $sender->sendMessage("§cThis generator doesn't exists!");
                                }else{
                                    Server::getInstance()->getWorldManager()->generateWorld($world, $generator);
                                    $sender->sendMessage("§aWorld has been successfully Duplicated!");
                                }
                                break;
                            case "rename":
                                $world = $args([1]);
                                $newname = $args([2]);
                                if(empty($world)){
                                    $sender->sendMessage("§cPlease enter a WorldName!");
                                }    
                                if(!$world->exist()){
                                    $sender->sendMessage("§cSorry but this World cannot be found!");
                                }
                                if(empty($newname)){
                                    $sender->sendMessage("§cPlease Enter the new name of the world!");
                                }else{
                                    Server::getInstance()->getWorldManager()->getWorld($world)->setDisplayName($newname);
                                }
                                break;
                            case "world":
                                switch(strtolower($args[1])){
                                    case "setspawn":
                                        $sender->sendMessage("§aYou successfully set the worldspawn on the location: §e" . $sender->getPosition());
                                        $sender->getWorld()->setSpawnLocation($sender->getPosition());
                                        break;
                                }
                                break;                            
                        }
                    }
                }else{
                    $sender->sendMessage("Please use it In-Game");
                }
        }
    return true;    
    }
}
