/**
* This is a KhoV2 plugin edited by AnhKhoaaa (Maybe original plugin is ShopGUI by ItzFabb)
*/

<?php



namespace ItzFabb\Shop;

//Essentials Class
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\Commandsender;
use pocketmine\inventory\transaction\action\SlotChangeAction;
use pocketmine\item\Item;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\enchantment\{Enchantment, EnchantmentInstance};
use pocketmine\utils\TextFormat;
use pocketmine\utils\TextFormat as TF;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\utils\Config;
use libs\muqsit\invmenu\InvMenu;
use libs\muqsit\invmenu\InvMenuHandler;
use onebone\economyapi\EconomyAPI;

class Main extends PluginBase implements Listener{

	public const LAPIZ = 0;
	public const BLOCKLAPIZ = 1;
	public const REDSTONE = 2;
	public const BLOCKREDSTONE = 3;
	public const COAL = 4;
	public const BLOCKCOAL = 5;
	public const IRON = 6;
	public const BLOCKIRON = 7;
	public const GOLD = 8;
	public const BLOCKGOLD = 9;
	public const DIAMOND = 10;
	public const BLOCKDIAMOND = 11;
	public const EMERALD = 12;
	public const BLOCKEMERALD = 13;
	public const COBLESTONE = 14;

	public $database;

	public static $instance;
	
	public function onEnable(){
		//OnEnable 
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->id = new Config($this->getDataFolder()."id.yml",Config::YAML);
        $this->auto = new Config($this->getDataFolder()."auto.yml",Config::YAML);		        
        $this->int = new Config($this->getDataFolder()."int.yml",Config::YAML);		
		$this->eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
		$this->menu = InvMenu::create(InvMenu::TYPE_DOUBLE_CHEST);
		self::$instance = $this;
		$this->getLogger()->info("\n\n\n§l§9PLUGIN §5KHO \n§7AUTHOR: §4AnhKhoaaa, LetTIHL\n\n\n");
		
		if(!InvMenuHandler::isRegistered()){
			InvMenuHandler::register($this);
		}
		//Log Info
         
	}
	
	public function onJoin(PlayerJoinEvent $ev){
        if(!$this->auto->exists($ev->getPlayer()->getName())) {
            $this->auto->set($ev->getPlayer()->getName(), "on");
            $this->auto->save();           
	    }
	}
	
	public function onbreak(BlockBreakEvent $ev){
	    $player = $ev->getPlayer();
        $this->data = new Config($this->getDataFolder().$player->getName().".yml",Config::YAML);
        $level = $player->getInventory()->getItemInHand()->getEnchantmentLevel(Enchantment::FORTUNE) + 1;
		if(!$ev->isCancelled()){}else{return;}
	    if($this->auto->get($player->getName()) == "on"){
	        if($ev->getBlock()->getId() == 56){
	            $ev->setDrops(array());
	            $id = mt_rand(0,$level);
	            $this->data->set(self::DIAMOND, ($this->data->get(self::DIAMOND) + $id));
                $this->data->save();
            }
      //Than
            if($ev->getBlock()->getId() == 16){
                $ev->setDrops(array());                
                $id = mt_rand(0,$level);
                $this->data->set(self::COAL, ($this->data->get(self::COAL) + $id));
                $this->data->save();
            }
      ///Block Vàng
            if($ev->getBlock()->getId() == 41){
                $ev->setDrops(array());               
                $this->data->set(self::BLOCKGOLD, ($this->data->get(self::BLOCKGOLD) + 1));
                $this->data->save();
            }
      //Block Sắt
            if($ev->getBlock()->getId() == 42){
                $ev->setDrops(array());
                $this->data->set(self::BLOCKIRON, ($this->data->get(self::BLOCKIRON) + 1));
                $this->data->save();
            }
      //Đá
            if($ev->getBlock()->getId() == 4){
                $ev->setDrops(array());
                $this->data->set(self::COBLESTONE, ($this->data->get(self::COBLESTONE) + 1));
                $this->data->save();
            }
      //Block Kim Cương
            if($ev->getBlock()->getId() == 57){
                $ev->setDrops(array());
                $this->data->set(self::BLOCKDIAMOND, ($this->data->get(self::BLOCKDIAMOND) + 1));
                $this->data->save();
            }
      //Đá Đỏ
            if($ev->getBlock()->getId() == 73){
                $ev->setDrops(array());
	            $id = mt_rand(0,$level);  
	            $this->data->set(self::REDSTONE, ($this->data->get(self::REDSTONE) + $id * 4));
                $this->data->save();
            }
      //block emrald
            if($ev->getBlock()->getId() == 133){
               $ev->setDrops(array()); 
               $this->data->set(self::BLOCKEMERALD, ($this->data->get(self::BLOCKEMERALD) + 1));
              $this->data->save();
            }
            if($ev->getBlock()->getId() == 129){
                $ev->setDrops(array());
	            $id = mt_rand(0,$level);
	            $this->data->set(self::EMERALD, ($this->data->get(self::EMERALD) + $id));
                $this->data->save();
            }
            if($ev->getBlock()->getId() == 173){
                $ev->setDrops(array());
                $this->data->set(self::BLOCKCOAL, ($this->data->get(self::BLOCKCOAL) + 1));
                $this->data->save();     
            }
            if($ev->getBlock()->getId() == 21){
                $ev->setDrops(array());
                $this->data->set(self::LAPIZ, ($this->data->get(self::LAPIZ) + 1));
                $this->data->save();
            }
            if($ev->getBlock()->getId() == 22){
                $ev->setDrops(array());
                $this->data->set(self::BLOCKLAPIZ, ($this->data->get(self::BLOCKLAPIZ) + 1));
                $this->data->save();             
            }
            if($ev->getBlock()->getId() == 152){
                $ev->setDrops(array());
                $this->data->set(self::BLOCKREDSTONE, ($this->data->get(self::BLOCKREDSTONE) + 1));
                $this->data->save();
            }
        }
	}
	
    public function getNumber(int $type, Player $player) : int {
        $this->data = new Config($this->getDataFolder().$player->getName().".yml",Config::YAML);
        return $this->data->get($type);
    }
    
    public function addNumber64(int $type, Player $player) {
         $this->data = new Config($this->getDataFolder().$player->getName().".yml",Config::YAML);              $this->data->set($type, ($this->data->get($type) + 64 ));
         $this->data->save();
    }
    
    public function addNumber48(int $type, Player $player) {
         $this->data = new Config($this->getDataFolder().$player->getName().".yml",Config::YAML);              $this->data->set($type, ($this->data->get($type) + 48 ));
         $this->data->save();
    }
    
    public function addNumber32(int $type, Player $player) {
         $this->data = new Config($this->getDataFolder().$player->getName().".yml",Config::YAML);              $this->data->set($type, ($this->data->get($type) + 32 ));
         $this->data->save();
    }
    
    public function addNumber16(int $type, Player $player) {
         $this->data = new Config($this->getDataFolder().$player->getName().".yml",Config::YAML);              $this->data->set($type, ($this->data->get($type) + 16 ));
         $this->data->save();
    }
    
    public function addNumber1(int $type, Player $player) {
         $this->data = new Config($this->getDataFolder().$player->getName().".yml",Config::YAML);              $this->data->set($type, ($this->data->get($type) + 1 ));
         $this->data->save();
    }
    
    public function descreaseNumber64(int $type, Player $player) {
         $this->data = new Config($this->getDataFolder().$player->getName().".yml",Config::YAML);              $this->data->set($type, ($this->data->get($type) - 64 ));
         $this->data->save();
    }
    
    public function descreaseNumber48(int $type, Player $player) {
         $this->data = new Config($this->getDataFolder().$player->getName().".yml",Config::YAML);              $this->data->set($type, ($this->data->get($type) - 48 ));
         $this->data->save();
    }
    
    public function descreaseNumber32(int $type, Player $player) {
         $this->data = new Config($this->getDataFolder().$player->getName().".yml",Config::YAML);              $this->data->set($type, ($this->data->get($type) - 32 ));
         $this->data->save();
    }
    
    public function descreaseNumber16(int $type, Player $player) {
         $this->data = new Config($this->getDataFolder().$player->getName().".yml",Config::YAML);              $this->data->set($type, ($this->data->get($type) - 16 ));
         $this->data->save();
    }
    
    

	public function onCommand(CommandSender $sender, Command $command, String $label, array $args) : bool {
        switch($command->getName()){
            case "kho":
                $this->kho($sender);
	        break;
	        case "autokho":
	            $name = $sender->getName();
                $auto =$this->auto->get($name);
                if($auto == "on"){
                   $this->auto->set($name, "off");
                   $sender->sendMessage("§l§c•§aMine vào kho §fOff");
                }
                if($auto == "off"){
                   $this->auto->set($name, "on");
                   $sender->sendMessage("§l§c•§aMine vào kho §fOn");                   
                }           
           return true;
        }
        return true;
	}
	
	public function kho($sender)
    {
        $this->menu->readonly();
        $this->menu->setListener([$this, "khomenu"]);
        $this->menu->setName("§eKHO CHỨA TÀI NGUYÊN ĐÀO ĐƯỢC");
        $inventory = $this->menu->getInventory();

        
        //Chest Section 1-8
        $inventory->setItem(0, Item::get(160, 9, 1) );
        $inventory->setItem(1, Item::get(160, 9, 1) );
        $inventory->setItem(2, Item::get(160, 9, 1) );
        $inventory->setItem(3, Item::get(160, 9, 1) );
        $inventory->setItem(4, Item::get(160, 9, 1) );
        $inventory->setItem(5, Item::get(160, 9, 1) );
        $inventory->setItem(6, Item::get(160, 9, 1) );
        $inventory->setItem(7, Item::get(160, 9, 1) );
        $inventory->setItem(8, Item::get(160, 9, 1) );
         //Chest Section 9-17
         $inventory->setItem(9, Item::get(160, 9, 1) );
         $inventory->setItem(10, Item::get(0, 8, 1) );
         $inventory->setItem(11, Item::get(0, 8, 1) );
         $inventory->setItem(12, Item::get(0, 9, 1) );
         $inventory->setItem(13, Item::get(4, 0, 1)->setCustomName("§rKHO ĐÁ CUỘI "));
         $inventory->setItem(14, Item::get(0, 9, 1) );
         $inventory->setItem(15, Item::get(0, 8, 1) );
         $inventory->setItem(16, Item::get(0, 8, 1) );
         $inventory->setItem(17, Item::get(160, 9, 1)->setCustomName(" §r §7 §r"));
         //Chest Section 18-26
        $inventory->setItem(18, Item::get(160, 9, 1) );
        $inventory->setitem(19, Item::get(351, 4, 1)->setCustomName(" §rKHO LAPIZ "));
        $inventory->setItem(20, Item::get(331, 0, 1)->setCustomName(" §rKHO REDSTONE "));
        $inventory->setItem(21, Item::get(263, 0, 1)->setCustomName(" §rKHO QUẶNG THAN "));
        $inventory->setItem(22, Item::get(265, 0, 1)->setCustomName(" §rKHO QUẶNG SẮT "));
        $inventory->setItem(23, Item::get(266, 0, 1)->setCustomName(" §rKHO QUẶNG VÀNG "));
        $inventory->setItem(24, Item::get(264, 0, 1)->setCustomName(" §rKHO KIM CƯƠNG "));
        $inventory->setItem(25, Item::get(388, 0, 1)->setCustomName(" §rKHO EMERALD "));
        $inventory->setItem(26, Item::get(160, 9, 1) );
        //Chest Section 27-35
        $inventory->setItem(27, Item::get(160, 9, 1) );
        $inventory->setItem(28, Item::get(22, 0, 1)->setCustomName(" §rKHO KHỐI LAPIZ "));
        $inventory->setItem(29, Item::get(152, 0, 1)->setCustomName(" §rKHO KHỐI REDSTONE "));
        $inventory->setItem(30, Item::get(173, 0, 1)->setCustomName(" §rKHO KHỐI THAN "));
        $inventory->setItem(31, Item::get(42, 0, 1)->setCustomName(" §rKHO KHỐI SẮT "));
        $inventory->setItem(32, Item::get(41, 0, 1)->setCustomName(" §rKHO KHỐI VÀNG "));
        $inventory->setItem(33, Item::get(57, 0, 1)->setCustomName(" §rKHO KHỐI KIM CƯƠNG "));
        $inventory->setItem(34, Item::get(133, 0, 1)->setCustomName(" §rKHO KHỐI EMERALD"));
         $inventory->setItem(35, Item::get(160, 9, 1) );
         //Chest Section 36-44
         $inventory->setItem(36, Item::get(160, 9, 1) );
         $inventory->setItem(37, Item::get(0, 8, 1) );
         $inventory->setItem(38, Item::get(0, 8, 1) );
         $inventory->setItem(39, Item::get(0, 9, 1) );
         $inventory->setItem(40, Item::get(0, 8, 1) );
         $inventory->setItem(41, Item::get(0, 9, 1) );
         $inventory->setItem(42, Item::get(0, 8, 1) );
         $inventory->setItem(43, Item::get(0, 8, 1) );
         $inventory->setItem(44, Item::get(160, 9, 1)->setCustomName(" §r §7 §r"));
         //Chest Section 45-53
         $inventory->setItem(45, Item::get(160, 9, 1) );
         $inventory->setitem(46, Item::get(160, 9, 1) );
         $inventory->setItem(47, Item::get(160, 9, 1) );
        $inventory->setItem(48, Item::get(386, 0, 1)->setCustomName("§l§7SỐ LƯỢNG CÁC BLOCK TRONG KHO HIỆN CÓ:\n\n§f＞ §bBLOCK LAPIZ:§a " . $this->getNumber(self::BLOCKLAPIZ, $sender) . "\n§f＞ §bBLOCK REDSTONE:§a " . $this->getNumber(self::BLOCKREDSTONE, $sender) . "\n§f＞ §bBLOCK THAN:§a " . $this->getNumber(self::BLOCKCOAL, $sender) . "\n§f＞ §bBLOCK SẮT:§a " . $this->getNumber(self::BLOCKIRON, $sender) . "\n§f＞ §bBLOCK VÀNG:§a " . $this->getNumber(self::BLOCKGOLD, $sender) . "\n§f＞ §bBLOCK KIM CƯƠNG:§a " . $this->getNumber(self::BLOCKDIAMOND, $sender) . "\n§f＞ §bBLOCK EMERALD:§a " . $this->getNumber(self::BLOCKEMERALD, $sender) . "\n\n"));
        $inventory->setItem(49, Item::get(160, 9, 1) );
        $inventory->setItem(50, Item::get(386, 0, 1)->setCustomName("§l§7SỐ LƯỢNG CÁC BLOCK TRONG KHO HIỆN CÓ:\n\n§f＞ §bĐÁ CUỘI:§a " . $this->getNumber(self::COBLESTONE, $sender) . "\n§f＞ §bLAPIZ:§a " . $this->getNumber(self::LAPIZ, $sender) . "\n§f＞ §bREDSTONE:§a " . $this->getNumber(self::REDSTONE, $sender) . "\n§f＞ §bTHAN:§a " . $this->getNumber(self::COAL, $sender) . "\n§f＞ §bSẮT:§a " . $this->getNumber(self::IRON, $sender) . "\n§f＞ §bVÀNG:§a " . $this->getNumber(self::GOLD, $sender) . "\n§f＞ §bKIM CƯƠNG:§a " . $this->getNumber(self::DIAMOND, $sender) . "\n§f＞ §bEMERALD:§a " . $this->getNumber(self::EMERALD, $sender) . "\n\n"));
        $inventory->setItem(51, Item::get(160, 9, 1) );
        $inventory->setItem(52, Item::get(160, 9, 1) );
        $inventory->setItem(53, Item::get(160, 9, 1) );
        
        $this->menu->send($sender);
    }
    public function khomenu(Player $sender, Item $item){
       $hand = $sender->getInventory()->getItemInHand()->getCustomName();
        $inventory = $this->menu->getInventory();
        if($item->getId() == 4 && $item->getDamage() == 0){
 
            $this->int->set($sender->getName(), self::COBLESTONE);
            $this->id->set($sender->getName(), 4);
            $this->item($sender);
        }
        if($item->getId() == 351 && $item->getDamage() == 4){
 
            $this->int->set($sender->getName(), self::LAPIZ);
            $this->id->set($sender->getName(), 351);
            $this->item($sender);
        }

        if($item->getId() == 22 && $item->getDamage() == 0){
 
            $this->int->set($sender->getName(), self::BLOCKLAPIZ);
            $this->id->set($sender->getName(), 22);
            $this->item($sender);
        }
        if($item->getId() == 331 && $item->getDamage() == 0){
             $this->int->set($sender->getName(), self::REDSTONE);
            $this->id->set($sender->getName(), 331);
            $this->item($sender);
        }
        if($item->getId() == 152 && $item->getDamage() == 0){
 
            $this->int->set($sender->getName(), self::BLOCKREDSTONE);
            $this->id->set($sender->getName(), 152);
            $this->item($sender);
        }
        if($item->getId() == 263 && $item->getDamage() == 0){
 
            $this->int->set($sender->getName(), self::COAL);
            $this->id->set($sender->getName(), 263);
            $this->item($sender);
        }
        if($item->getId() == 265 && $item->getDamage() == 0){
 
            $this->int->set($sender->getName(), self::IRON);
            $this->id->set($sender->getName(), 265);
            $this->item($sender);
        }
        if($item->getId() == 42 && $item->getDamage() == 0){
           
            $this->int->set($sender->getName(), self::BLOCKIRON);
            $this->id->set($sender->getName(), 42);
            $this->item($sender);
        }
        if($item->getId() == 173 && $item->getDamage() == 0){
 
            $this->int->set($sender->getName(), self::BLOCKCOAL);
            $this->id->set($sender->getName(), 173);
            $this->item($sender);
        }
        if($item->getId() == 266 && $item->getDamage() == 0){
            
            $this->int->set($sender->getName(), self::GOLD);
            $this->id->set($sender->getName(), 266);
            $this->item($sender);
        }
        if($item->getId() == 41 && $item->getDamage() == 0){
 
            $this->int->set($sender->getName(), self::BLOCKGOLD);
            $this->id->set($sender->getName(), 41);
            $this->item($sender);
        }
        if($item->getId() == 264 && $item->getDamage() == 0){
 
            $this->int->set($sender->getName(), self::DIAMOND);
            $this->id->set($sender->getName(), 264);
            $this->item($sender);
        }
        if($item->getId() == 57 && $item->getDamage() == 0){
 
            $this->int->set($sender->getName(), self::BLOCKDIAMOND);
            $this->id->set($sender->getName(), 57);
            $this->item($sender);
        }
        if($item->getId() == 388 && $item->getDamage() == 0){
 
            $this->int->set($sender->getName(), self::EMERALD);
            $this->id->set($sender->getName(), 388);
            $this->item($sender);            
        }
        if($item->getId() == 133 && $item->getDamage() == 0){
 
            $this->int->set($sender->getName(), self::BLOCKEMERALD);
            $this->id->set($sender->getName(), 133);
            $this->item($sender);
        }
    }
    public function item(Player $sender)
    {
        $type = $this->id->get($sender->getName());
        $meta = 0;
        if($type == 351){
            $meta = 4;
        }
         $id = $this->int->get($sender->getName());  
        $this->menu->readonly();
        $this->menu->setListener([$this, "lapizmenu"]);
         $this->menu->setName("§eKho");
        $inventory = $this->menu->getInventory();

        
        //Chest Section 1-8
        for($i = 0;$i<=9;$i++){
        $inventory->setItem($i, Item::get(160, 9, 1) );
        }
         $inventory->setItem(10, Item::get(0, 8, 1) );
         $inventory->setItem(11, Item::get(0, 8, 1) );$inventory->setItem(12, Item::get(0, 9, 1) );
         $inventory->setItem(13, Item::get($type, $meta, 1)->setCustomName("§rBạn hiện có §a[" . $this->getNumber($id, $sender) . "]§f "));
         $inventory->setItem(14, Item::get(0, 9, 1) );
         $inventory->setItem(15, Item::get(0, 8, 1) );
         $inventory->setItem(16, Item::get(0, 8, 1) );
         $inventory->setItem(17, Item::get(160, 9, 1));
         //Chest Section 18-26
        $inventory->setItem(18, Item::get(160, 9, 1) );
        $inventory->setitem(19, Item::get(0, 0, 1));
        $inventory->setItem(20, Item::get(160, 5, 1));
        $inventory->setItem(21, Item::get(0, 0, 1));
        $inventory->setItem(22, Item::get(66, 0, 1) );
        $inventory->setItem(23, Item::get(0, 0, 1));
        $inventory->setItem(24, Item::get(160, 14, 1));
        $inventory->setItem(25, Item::get(0, 0, 1) );
        $inventory->setItem(26, Item::get(160, 9, 1) );
        //Chest Section 27-35
        $inventory->setItem(27, Item::get(160, 9, 1) );
        $inventory->setItem(28, Item::get(339, 11, 1)->setCustomName(" §l§aBỏ vào §5x16"));
        $inventory->setItem(29, Item::get(339, 12, 1)->setCustomName("§l§aBỏ vào §5x32"));
        $inventory->setItem(30, Item::get(339, 13, 1)->setCustomName(" §l§aBỏ vào §5x64"));
        $inventory->setItem(31, Item::get(66, 0, 1) );
        $inventory->setItem(32, Item::get(339, 0, 1)->setCustomName("§l§aLấy ra §5x16"));
        $inventory->setItem(33, Item::get(339, 1, 1)->setCustomName("§l§aLấy ra §5x32"));
        $inventory->setItem(34, Item::get(339, 2, 1)->setCustomName("§l§aLấy ra §5x64"));
         $inventory->setItem(35, Item::get(160, 9, 1) );
         //Chest Section 36-44
         $inventory->setItem(36, Item::get(160, 9, 1));
         $inventory->setItem(37, Item::get(0, 8, 1));
         $inventory->setItem(38, Item::get(0, 8, 1) );
         $inventory->setItem(39, Item::get(0, 9, 1) );
         $inventory->setItem(40, Item::get(66, 8, 1) );
         $inventory->setItem(41, Item::get(0, 9, 1) );
         $inventory->setItem(42, Item::get(0, 8, 1) );
         $inventory->setItem(43, Item::get(0, 8, 1) );
         $inventory->setItem(44, Item::get(160, 9, 1));
         //Chest Section 45-53
         for($i = 45;$i<=52;$i++){
         $inventory->setItem($i, Item::get(160, 9, 1) );
         }
        $inventory->setItem(53, Item::get(386, 0, 1)->setCustomName("§l§cQUAY LẠI TRANG CHỦ"));
        
        $this->menu->send($sender);
    }
    public function lapizmenu(Player $sender, Item $item){
       $id = $this->id->get($sender->getName());
       $metan = 0;
       if($id == 351){
           $metan = 4;
       }
       $type = $this->int->get($sender->getName());
       $hand = $sender->getInventory()->getItemInHand()->getCustomName();
        $inventory = $this->menu->getInventory();
        if($item->getId() == 386 && $item->getDamage() == 0){
             $this->kho($sender);
        }
        $meta = $item->getDamage();
        switch($meta){
            case 11:
        	if($sender->getInventory()->contains(Item::get($id, $metan, 16))){
        		$sender->getInventory()->removeItem(Item::get($id, $metan, 16));
        		$this->addNumber16($type, $sender);
            	$this->item($sender);
        		$sender->sendMessage("§5[§aKHO§5]: §aBạn đã gửi x16 item vào kho lưu trữ."); 
        	}else{
        		$sender->removeWindow($inventory);        	    
         		$sender->sendMessage("§5[§aKHO§5]: §aBạn không đủ item để giửi"); 
            }       	    
            break;
            case 12:
        	if($sender->getInventory()->contains(Item::get($id, $metan, 32))){
        		$sender->getInventory()->removeItem(Item::get($id, $metan, 32));
        		$this->addNumber32($type, $sender);
            	$this->item($sender);
        		$sender->sendMessage("§5[§aKHO§5]: §aBạn đã gửi x32 item vào kho lưu trữ."); 
        	}else{
        		$sender->removeWindow($inventory);        	    
         		$sender->sendMessage("§5[§aKHO§5]: §aBạn không đủ item để giửi"); 
            } 
            break;
            case 13:
        	if($sender->getInventory()->contains(Item::get($id, $metan, 64))){
        		$sender->getInventory()->removeItem(Item::get($id, $metan, 64));
        		$this->addNumber64($type, $sender);
            	$this->item($sender);
        		$sender->sendMessage("§5[§aKHO§5]: §aBạn đã gửi x64 item vào kho lưu trữ."); 
        	}else{
        		$sender->removeWindow($inventory);        	    
         		$sender->sendMessage("§5[§aKHO§5]: §aBạn không đủ item để giửi"); 
            } 
            break;
            case 0:
        	if ($this->getNumber($type, $sender) >= 16){
        		if ($sender->getInventory()->firstEmpty() === -1){
            		$sender->sendMessage("§5[§aKHO§5]: §cLỗi, kho đồ của bạn đang đầy. hãy thử lại.");
            		$sender->removeWindow($inventory);
            	} else {
        		$sender->getInventory()->addItem(Item::get($id, $metan, 16));
        		$this->descreaseNumber16($type, $sender);
            	$this->item($sender);
        		$sender->sendMessage("§5[§aKHO§5]: §aBạn đã lấy x16 item ra túi đồ.");
        	}              
        	} else {
        		$sender->removeWindow($inventory);
        		$sender->sendMessage("§5[§aKHO§5]: §cTrong kho không đủ item để lấy ra.");
        	}
           break;
           case 1:
        	if ($this->getNumber($type, $sender) >= 32){
        		if ($sender->getInventory()->firstEmpty() === -1){
            		$sender->sendMessage("§5[§aKHO§5]: §cLỗi, kho đồ của bạn đang đầy. hãy thử lại.");
            		$sender->removeWindow($inventory);
            	} else {
        		$sender->getInventory()->addItem(Item::get($id, $metan, 32));
        		$this->descreaseNumber32($type, $sender);
            	$this->item($sender);
        		$sender->sendMessage("§5[§aKHO§5]: §aBạn đã lấy x32 LAPIZ ra túi đồ.");
        	}              
        	} else {
        		$sender->removeWindow($inventory);
        		$sender->sendMessage("§5[§aKHO§5]: §cTrong kho không đủ item để lấy ra.");
        	}
            break;
            case 2:
        	if ($this->getNumber($type, $sender) >= 64){
        		if ($sender->getInventory()->firstEmpty() === -1){
            		$sender->sendMessage("§5[§aKHO§5]: §cLỗi, kho đồ của bạn đang đầy. hãy thử lại.");
            		$sender->removeWindow($inventory);
            	} else {
        		$sender->getInventory()->addItem(Item::get($id, $metan, 64));
        		$this->descreaseNumber64($type, $sender);
            	$this->item($sender);
        		$sender->sendMessage("§5[§aKHO§5]: §aBạn đã lấy x64 item ra túi đồ.");
        	}
        	} else {
        		$sender->removeWindow($inventory);
        		$sender->sendMessage("§5[§aKHO§5]: §cTrong kho không đủ item để để lấy ra.");
        	}
        	break;
        }
    }
}
