<?php

namespace ReformedDevs\ReformedNetwork_Core\BuildProtect\commands;

use ReformedDevs\ReformedNetwork_Core\BuildProtect\BuildProtect;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\Player;

class Protect extends Command{

	private $plugin;
	
	public function __construct(BuildProtect $plugin){
		
		$this->plugin = $plugin;
		parent::__construct("buildprotect");
		$this->setDescription("get the build protect wand(feather)!");
		$this->setUsage("/buildprotect");
		$this->setPermission("build.protect.wand");
		$this->setAliases(["bp"]);
	}
	
	public function execute(CommandSender $sender, string $commandLabel, array $args){
		
		if(!($sender->hasPermission("build.protect.wand") || $sender->hasPermission("build.protect.build.protect.admin"))){
			$sender->sendMessage("§l§c(!) §r§7You do not have permission to run this command!");
			return;
		}
		
		if(!$sender instanceof Player){
			$sender->sendMessage("You must use this command IN-GAME!");
			return;
		}
		
		if(!$sender->isOp()){
			$sender->sendMessage("§l§c(!) §r§7You must be opped to use this command!");
			return;
		}
		
		$item = Item::get(Item::FEATHER);
		$item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(100), 1));
		$item->setCustomName("§l§6Protection §fFeather");
		$item->setLore(["§fRight Click §6to select first position\n\n§fLeft Click §6to select second position"]);
		
		if(!$sender->getInventory()->canAddItem($item)){
			$sender->sendMessage("§l§c(!) §r§7Can not add item to your inventory!");
			return;
		}
		
		$sender->getInventory()->addItem($item);
		$sender->sendMessage("§l§a(!) §r§7Added §l§6Protection §fFeather §r§7to your inventory!");
	}
}