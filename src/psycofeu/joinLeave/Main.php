<?php

namespace psycofeu\joinLeave;

use pocketmine\event\entity\EntityTeleportEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\SingletonTrait;

class Main extends PluginBase implements Listener
{
    protected function onEnable(): void
    {
        $this->saveResource("config.yml");
        $this->saveDefaultConfig();
        $this->getLogger()->notice("vJoinLeave plugin enable | by Psycofeu");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    public function getConfigFile(): Config
    {
        return new Config($this->getDataFolder() . "config.yml", Config::YAML);
    }
    public function playerJoinEvent(PlayerJoinEvent $event)
    {
        $event->setJoinMessage("");
        $config = $this->getConfigFile();
        $player = $event->getPlayer();
        if ($player->hasPlayedBefore()){
            if ($config->get("join_message_enable")){
                Server::getInstance()->broadcastMessage(str_replace("{player}", $player->getName(), $config->get("join_message")));
            }
            if ($config->get("join_popup_enable")){
                Server::getInstance()->broadcastPopup(str_replace("{player}", $player->getName(), $config->get("join_popup")));
            }
        }else{
            if ($config->get("welcome_message_enable")){
                Server::getInstance()->broadcastMessage(str_replace("{player}", $player->getName(), $config->get("welcome_message")));
            }
            if ($config->get("welcome_popup_enable")){
                Server::getInstance()->broadcastPopup(str_replace("{player}", $player->getName(), $config->get("welcome_popup")));
            }
        }
    }
    public function playerquit(PlayerQuitEvent $event)
    {
        $event->setQuitMessage("");
        $config = $this->getConfigFile();
        $player = $event->getPlayer();
        if ($config->get("leave_message_enable")){
            Server::getInstance()->broadcastMessage(str_replace("{player}", $player->getName(), $config->get("leave_message")));
        }
        if ($config->get("leave_popup_enable")){
            Server::getInstance()->broadcastPopup(str_replace("{player}", $player->getName(), $config->get("leave_popup")));
        }
    }
}