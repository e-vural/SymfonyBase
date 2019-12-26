<?php
/**
 * Created by PhpStorm.
 * User: emrevural
 * Date: 2019-04-10
 * Time: 11:07
 */

namespace Project\Utils\Core\Php;


class Tools
{

    public function clearNumberFormat($number){

        if($number == "" || !$number){
            return 0;
        }

//        if(strpos($number,",") === false){
//            $number = $this->numberFormatter();
//        }

        $number = str_replace(".","",$number);
        return str_replace(",",".",$number);

    }

    public function numberFormatter($value = null,$clear = false,$digits = 2){

        $formatter = new \NumberFormatter("tr_TR", \NumberFormatter::DECIMAL);
//        $formatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, 2);
        $formatter->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, $digits);
        if($value !== null){
            $formattedValue = $formatter->format($value);
            if($clear){
                $formattedValue = $this->clearNumberFormat($formattedValue);
            }
//            floatval($kdvHaric) TODO burada float yapalım? zararı olur mu?
            return $formattedValue;
        }

        return $formatter;
    }

    public function parseDate($date,$format = "d/m/Y"){

        if(!$date){
            return null;
        }

        return \DateTime::createFromFormat($format, $date);

    }

    public function getUuid(){
        return uniqid("_");
    }

    public function dateLocaleParser($date,$pattern = "d-MMMM-Y EEEE HH:mm"){
        //http://userguide.icu-project.org/formatparse/datetime

        $formatter = new \IntlDateFormatter(\Locale::getDefault(), \IntlDateFormatter::NONE, \IntlDateFormatter::NONE);
        $formatter->setPattern($pattern);
        return $formatter->format($date);
    }

    public function hesapMakinesi($sayi,$sayi2,$islem = "+"){
        $p = $sayi.$islem.$sayi2;
        $p = eval('return '.$p.';');
        return $p;
    }

    public function matOperator($defaultOperator,$ters_islem = false){

        if($ters_islem){
            $defaultOperator == "+" ? $defaultOperator = "-" : $defaultOperator = "+";
        }
        return $defaultOperator;

    }

    public function kdvliHaliniHesapla($kdvHaric,$kdvOrani = 8){

        return $this->numberFormatter($kdvHaric * (1+($kdvOrani / 100)),true);

    }

    public function kdvsizHaliniHesapla($kdvDahil,$kdvOrani = 8){


        return $this->numberFormatter($kdvDahil / (1+($kdvOrani / 100)),true);

    }
}
