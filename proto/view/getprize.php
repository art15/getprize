<?php
/**
 * Date: 2018/09/15 
 * Author: ASeryakov
 */
?>
<div class="mt-sm-5">
    <div class="mx-auto" style="width:400px;">
        <button class="btn btn-success<?=(!empty($_SESSION["myPrize"])?" d-none":"")?>" id="getprize"><h2>получить приз! <i class="fa fa-gift"></i></h2></button>
        <button class="btn btn-danger<?=(!empty($_SESSION["myPrize"])?"":" d-none")?>" id="declineprize"><h2>отказаться от приза <i class="fa fa-times"></i></h2></button>
    </div>
    <div id="prize-result" class="h3 mt-3"><?=(!empty($_SESSION["myPrize"])?$_SESSION["myPrize"]["textPrize"]:"")?></div>
    <div id="money-block" class="<?=(!empty($_SESSION["myPrize"]) && $_SESSION["myPrize"]["type"] == "money"?"":"d-none")?>">
        <button id="moneyToBankAccount" class="btn btn-primary">перевести на счет</button>
        <button id="moneyConvertToBonus" class="btn btn-primary">конвертировать в бонусы</button>
    </div>
    <div id="material-block" class="<?=(!empty($_SESSION["myPrize"]) && $_SESSION["myPrize"]["type"] == "material"?"":"d-none")?>">
        <button id="sendParcel" class="btn btn-primary">отправьте мне посылку!</button>
    </div>
    <input type="hidden" id="loyaltyBonus" value="<?=intval($_SESSION["auth_user"]["loyaltyBonus"])?>" />
    <div id="prize-params">
        <?php if(!empty($_SESSION["myPrize"])){ 
            foreach($_SESSION["myPrize"] as $key => $val){
                ?><input type="hidden" id="prize-<?=$key?>" value="<?=$val?>" /><?php
            }
            }else{
            foreach(array_flip(split(";","id;type;min;max;name;amount")) as $key=>$val){
                ?><input type="hidden" id="prize-<?=$key?>" value="" /><?php
            }?>
                    <input type="hidden" id="prize-randomAmount" value="" />
                    <input type="hidden" id="prize-textPrize" value="" />
                <?php
            }?>
    </div>
</div>
