<?php
namespace cls;

/**
 * Description of Prize
 *
 * @author ASeryakov
 */
use params\main;
abstract class Prize extends main {
    protected $id; //уникальный идентификатор приза
    protected $type; //тип приза
    protected $min; //граница диапазона выбора суммы "от"
    protected $max; //граница диапазона выбора суммы "до"
    protected $name; //название предмета
    protected $amount; //доступное количество (доступная сумма)
    
    protected $randomAmount; //сумма или количество, которое будет случайно выбрано
    public $textPrize;
    
    public function getRandomAmount() {
        return $this->randomAmount;
    }

    public function setRandomAmount($randomAmount) {
        $this->randomAmount = $randomAmount;
    }

        public function getId() {
        return $this->id;
    }

    public function getType() {
        return $this->type;
    }

    public function getMin() {
        return $this->min;
    }

    public function getMax() {
        return $this->max;
    }

    public function getName() {
        return $this->name;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setMin($min) {
        $this->min = $min;
    }

    public function setMax($max) {
        $this->max = $max;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }
    
    //преобразуем массив данных в объект
    public function createObj(array $randomPrizeData){
        //массив нужен для преобразования цифровых индексов в поля класса приза
        $fieldname = split(";","id;type;min;max;name;amount"); //название поля => индекс
        foreach($randomPrizeData as $indx=>$data){
            $property = $fieldname[$indx];
            $this->$property = $data;
        }
    }
    
    public function __construct($randomPrizeData) {
        parent::__construct();
        $this->createObj($randomPrizeData);
    }

    public abstract function calc();
    public abstract function isTransferToBankAcc(); //можно ли переводить в банк
    public abstract function isConvertToBonus(); //конвертируется ли в бонусы
    public abstract function isSendAsParcel(); //отправляется ли как посылка
    
    public function getArray(){
        $vars = get_object_vars($this);
        unset($vars["config"]);
        return $vars;
    }
}
