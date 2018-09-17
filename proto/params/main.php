<?php
namespace params;

class main {
    protected $config;
    function __construct(){
        $rateMoneyToBonus = 1; //коэффициент конвертации денег в бонусы
        //Перечисляем призы
        $prizes = [
                "money" => "денежный приз",
                "bonus" => "бонусный приз",
                "material" => "предмет"
            ];
        //amount (количество каждого приза) храним в pseudoDB.csv
        $this->config = [ "prizes"=>$prizes, "rateMoneyToBonus"=>$rateMoneyToBonus, "fileDB"=> __DIR__."/../pseudoDB.csv", 'currencySymbol' => "€"];
    }
    public function plural_form($n, $forms) {
        return $n%10==1&&$n%100!=11?$forms[0]:($n%10>=2&&$n%10<=4&&($n%100<10||$n%100>=20)?$forms[1]:$forms[2]);
    }
}

