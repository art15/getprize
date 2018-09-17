<?php
namespace cls;

/**
 * Description of PrizeBonus
 *
 * @author ASeryakov
 */
use cls\Calculate;
class PrizeBonus extends Prize {
    
    public function calc(){
        //бонусы бесконечны, поэтому просто случайно выберем цифру из диапазона.
        $this->randomAmount = rand($this->min, $this->max);
        (new Calculate)->bonusIncrease($this->randomAmount);//обновим бонусы у пользователя
        $this->textPrize = "Поздравляем! Ваш выигрыш составил ".$this->randomAmount." ".
                            $this->plural_form($this->randomAmount,["бонус","бонуса","бонусов"]);
    }
    public function isTransferToBankAcc(){return false;} //можно ли переводить в банк
    public function isConvertToBonus(){return false;} //конвертируется ли в бонусы
    public function isSendAsParcel(){return false;} //отправляется ли как посылка
}
