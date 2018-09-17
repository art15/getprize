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
}

