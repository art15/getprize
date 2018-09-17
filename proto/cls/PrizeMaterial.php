<?php
namespace cls;

/**
 * Description of PrizeMaterial
 *
 * @author ASeryakov
 */
class PrizeMaterial extends Prize {
    
    public function calc(){
         //если граница "до" > доступной суммы, но она больше "от", то призом становится эта сумма
        $this->randomAmount = rand($this->min, $this->max);
        $this->textPrize = "Поздравляем! Ваш выигрыш -  ".$this->name."!";
    }
    public function isTransferToBankAcc(){return false;} //можно ли переводить в банк
    public function isConvertToBonus(){return false;} //конвертируется ли в бонусы
    public function isSendAsParcel(){return true;} //отправляется ли как посылка
}
