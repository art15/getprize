<?php
namespace cls;
/**
 * Date: 2018/09/16
 * @author ASeryakov
 * класс расчета призовых сумм, предметов
 */
use params\main;
class Calculate extends main {

    public $prizesAll = []; //массив количества по призам
    public $prizesIdForRand = []; //массив ID фильтрованных призов, которые есть в наличии
    
    public function getPrize(){
        if(!empty($_SESSION["myPrize"])){
            return ["state" => "error", "message" => "Вы уже получили свой приз :)", "data"=> []];
        }
        //своего рода "поиск" призов которые еще в наличии (т.е. количество > 0 или бесконечное)
        $this->readFileDB();

        //находим случайный индекс приза
        $randomIndxPrize = rand(0, sizeof($this->prizesIdForRand)-1);
        //определяем ID выпавшего приза
        $randomPrizeID = $this->prizesIdForRand[$randomIndxPrize];
        //находим в массиве данные по ID приза
        $randomPrizeData = $this->prizesAll[$randomPrizeID];
        
        //определяем тип приза
        $type = "\cls\Prize".ucfirst($randomPrizeData[1]); //money|bonus|material
        try {
            $cls = new $type($randomPrizeData);
            
            //производим расчет, смотря какой приз выпал
            $cls->calc();
            //обновляем в списке призов сумму выпавшего варианта, 
            //т.е. обновляем на будущее оставшееся доступное количчество(сумма) amount
            //при условии, если количество или сумма не бесконечны
            if( $this->prizesAll[$cls->getId()][5] != "infinite"){
                $this->prizesAll[$cls->getId()][5] = $cls->getAmount() - $cls->getRandomAmount();
            }
            //TODO: дописать метод "отказ от приза", когда выигранная сумма(предмет) возвращается в базу.
            $this->updateFileDB();
            $_SESSION["myPrize"] = $cls->getArray();
            return ["state" => "success", 
                    "message" => $cls->textPrize, 
                    "data"=> [  
                        "prize"=>$_SESSION["myPrize"], 
                        "isConvertToBonus"=>$cls->isTransferToBankAcc(),
                        "isConvertToBonus"=>$cls->isConvertToBonus(),
                        "isConvertToBonus"=>$cls->isSendAsParcel(),
                    ]];
        }catch(Exception $e){
            return ["state" => "error", "message" => "Exception: ".$e->message, "data"=> []];
        }
    }
    
    public function declinePrize(){
        $this->readFileDB();
        //возвращаем количество(сумму) приза обратно в "БД" 
        $id = $_SESSION["myPrize"]["id"];
        if( $this->prizesAll[$id][5] != "infinite"){ //если количество не бесконечно - обновляем
            $this->prizesAll[$id][5] = $this->prizesAll[$id][5] + $_SESSION["myPrize"]["randomAmount"];
        }
        //если тип выигрыша "бонус", то при отмене приза отнимаем у пользователя сумму бонусов
        if($this->prizesAll[$id][1] == "bonus"){
            $this->bonusDecrease($_SESSION["myPrize"]["randomAmount"]);
        }
        try{
            $this->updateFileDB();
            unset($_SESSION["myPrize"]);
            return ["state" => "success", "message" => "Вы отказались от приза", "data"=> []];
        }catch(Exception $e){
            return ["state" => "error", "message" => "Exception: ".$e->message, "data"=> []];
        }
    }
    
    //перевод денег на банковский счёт
    public function moneyToBankAccount(){
        $amount = $_SESSION["myPrize"]["randomAmount"]; 
        unset($_SESSION["myPrize"]);
        return ["state" => "success", "message" => "Сумма в размере ".$amount." была переведена на Ваш банковский счет.", "data"=> []];
    }
    
    //конвертация денег в бонусы лояльности
    public function moneyConvertToBonus(){
        $amount = $_SESSION["myPrize"]["randomAmount"];
        //высчитываем бонусы, исходя из указанного в конфигурации коэффициента по отношению к денежной единице
        $bonus = $amount * $this->config["rateMoneyToBonus"]; 
        $this->bonusIncrease($sum);
        unset($_SESSION["myPrize"]);
        return ["state" => "success", 
                "message" => "Сумма в размере ".$amount." ".$this->config["currencySymbol"]." была конвертирована в ".$bonus." ".$this->plural_form($bonus,["бонус","бонуса","бонусов"]), 
                "data"=> ["bonusAmount" => $bonus, "amount"=> $amount]];
    }
    
    //отправка посылки
    public function sendParcel(){
        //TODO: здесь организовать процесс по отправке посылки
        unset($_SESSION["myPrize"]);
        return ["state" => "success", "message" => "Ваш запрос на отправку посылки отправлен", "data"=> []];
    }


    //читаем файл данных с возможными призами
    private function readFileDB(){
        try{
            if (($handle = fopen($this->config["fileDB"], "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    $id = $data[0]; //идентификатор приза
                    $prizeAmount = $data[5]; //количество приза из "БД"
                    //заполняем список призов "в наличии"
                    if($prizeAmount > 0 || $prizeAmount == "infinite"){$this->prizesIdForRand[] = $id;}
                    $this->prizesAll[$id] =  $data; //["id" => $id, "amount" => $prizeAmount];
                }
                fclose($handle);
            }else{
                return ["state" => "error", "message" => "Ошибка чтения файла данных", "data"=> []];
            }
        }catch(Exception $e){
            return ["state" => "error", "message" => "Exception: ".$e->message, "data"=> []];
        }
    }

    //обновляем файл данных с призами
    private function updateFileDB(){
        //записываем итог обратно в файл
        $fp = fopen($this->config["fileDB"], 'w');
        foreach ($this->prizesAll as $prizeOne) {
            fputcsv($fp, $prizeOne, ";");
        }
        fclose($fp);
    }
   
    public function bonusIncrease($sum){
        $_SESSION["auth_user"]["loyaltyBonus"] = $_SESSION["auth_user"]["loyaltyBonus"] + $sum;
    }
    public function bonusDecrease($sum){
        $_SESSION["auth_user"]["loyaltyBonus"] = $_SESSION["auth_user"]["loyaltyBonus"] - $sum;
        if($_SESSION["auth_user"]["loyaltyBonus"] < 0){$_SESSION["auth_user"]["loyaltyBonus"] = 0;}
    }
}
