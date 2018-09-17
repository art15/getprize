<?php
namespace cls;
/**
 * Date: 2018/09/16
 * @author ASeryakov
 * класс расчета призовых сумм, предметов
 */
use params\main;
class Calculate extends main {

    public function getPrize(){
        $prizesAll = []; //массив количества по призам
        $prizesIdForRand = []; //массив ID фильтрованных призов, которые есть в наличии
        //массив нужен для понимания в коде какие поля используются при расчете приза
        
        //своего рода "поиск" призов которые еще в наличии (т.е. количество > 0 или бесконечное)
        if (($handle = fopen($this->config["fileDB"], "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $id = $data[0]; //идентификатор приза
                $prizeAmount = $data[5]; //количество приза из "БД"
                //заполняем список призов "в наличии"
                if($prizeAmount > 0 || $prizeAmount == "infinite"){$prizesIdForRand[] = $id;}
                $prizesAll[$id] =  $data; //["id" => $id, "amount" => $prizeAmount];
            }
            fclose($handle);
        }else{
            return ['state' => 'error', 'message' => 'Ошибка чтения файла данных', 'data'=> []];
        }

        //находим случайный индекс приза
        $randomIndxPrize = 0;//rand(0, sizeof($prizesIdForRand)-1);
        //определяем ID выпавшего приза
        $randomPrizeID = $prizesIdForRand[$randomIndxPrize];
        //находим в массиве данные по ID приза
        $randomPrizeData = $prizesAll[$randomPrizeID];
        
        //определяем тип приза
        $type = "\cls\Prize".ucfirst($randomPrizeData[1]); //money|bonus|material
        try {
            $cls = new $type($randomPrizeData);
            
            //производим расчет, смотря какой приз выпал
            $cls->calc($randomPrizeData, $fieldname);
            exit(var_dump($cls->getRandomAmount()));
            //обновляем в списке призов сумму выпавшего варианта
            $prizesAll[$randomPrizeData->id]["amount"] = $cls->getAmount() - $cls->getRandomAmount();
            //$this->updateFileDB($prizesAll);
            return ['state' => 'success', 
                    'message' => 'Поздравляем! Ваш выигрыш '.$result["message"], 
                    'data'=> [
                        "amount"=>$result["amount"]
                    ]];
        }catch(Exception $e){
            return ['state' => 'error', 'message' => 'Exception: '.$e->message, 'data'=> []];
        }
        //находим случайно выпавшее количество из возможных "от" и "до"
    }

    private function updateFileDB($prizesAll){
        //записываем итог обратно в файл
        $fp = fopen($this->config["fileDB"], 'w');
        foreach ($prizesAll as $prizeOne) {
            fputcsv($fp, $prizeOne, ";");
        }
        fclose($fp);
    }
}
