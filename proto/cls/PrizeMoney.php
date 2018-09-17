<?php
namespace cls;

/**
 * Description of PrizeMoney
 *
 * @author ASeryakov
 */
class PrizeMoney extends Prize {
    
    public function calc(){
        //если граница "до" > доступной суммы, но она больше "от", то призом становится эта сумма
        if($this->max > $this->amount && $this->amount >= $this->min){
            $this->randomAmount = $this->amount;
        }else{
            $this->randomAmount = rand($this->min, $this->max);
        }
        $this->textPrize = "Поздравляем! Ваш выигрыш составил ".$this->randomAmount." ".$this->config["currencySymbol"];
    }
    public function isTransferToBankAcc(){return true;} //можно ли переводить в банк
    public function isConvertToBonus(){return true;} //конвертируется ли в бонусы
    public function isSendAsParcel(){return false;} //отправляется ли как посылка
}
