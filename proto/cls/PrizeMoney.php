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
        //return ["message"=>"составил ".$prize." ".$this->params["currencySymbol"], "amount"=> $prize];
    }
}
