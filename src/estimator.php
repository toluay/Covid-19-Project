<?php

// Declare multi-dimensional array


function covid19ImpactEstimator($Data)
{
    function currentlyFactor( $Data, $bale){
    return $Data['reportedCases'] * $bale;
      }


    //Question 1
  $Impact_currentlyInfected = currentlyFactor($Data,10);

  $SevereImpact_currentlyInfected = currentlyFactor($Data,50);

  function infectionsByRequestedTimeFactor ($dayss , $InfectedMultiplier ){
    // echo($dayss);
    // echo ",,,,,,,,,,,,,,,,,,";
     $calFactorial = floor($dayss / 3) ;
    // echo "the factor is";echo($calFactorial);
    // echo "answer will be :";echo($InfectedMultiplier * (2^$calFactorial));
    return $InfectedMultiplier * pow(2,$calFactorial);
    }

    switch ($Data["periodType"]) {
      case 'days':
        $Impact_infectionsByRequestedTime =floor(infectionsByRequestedTimeFactor($Data["timeToElapse"], $Impact_currentlyInfected));
        break;
      case 'weeks':
        $Impact_infectionsByRequestedTime =floor(infectionsByRequestedTimeFactor(($Data["timeToElapse"] * 7), $Impact_currentlyInfected));
        break;
      case 'months':
        $Impact_infectionsByRequestedTime =floor(infectionsByRequestedTimeFactor(($Data["timeToElapse"] * 7 * 30), $Impact_currentlyInfected));
        break;

      default:
        $Impact_infectionsByRequestedTime =floor(infectionsByRequestedTimeFactor($Data["timeToElapse"], $Impact_currentlyInfected));
        break;
    }

    switch ($Data["periodType"]) {
      case 'days':
        $SevereImpact_infectionsByRequestedTime =floor(infectionsByRequestedTimeFactor($Data["timeToElapse"], $SevereImpact_currentlyInfected));
        break;
      case 'weeks':
        $SevereImpact_infectionsByRequestedTime =floor(infectionsByRequestedTimeFactor(($Data["timeToElapse"] * 7), $SevereImpact_currentlyInfected));
        break;
      case 'months':
        $SevereImpact_infectionsByRequestedTime =floor(infectionsByRequestedTimeFactor(($Data["timeToElapse"] * 7 * 30), $SevereImpact_currentlyInfected));
        break;

      default:
        $SevereImpact_infectionsByRequestedTime =floor(infectionsByRequestedTimeFactor($Data["timeToElapse"], $SevereImpact_currentlyInfected));
        break;
    }
 //Question 2 answered .....

    $Severe_severeCasesByRequestedTime=floor( 0.15 * $SevereImpact_infectionsByRequestedTime);
    $Impact_severeCasesByRequestedTime = floor(0.15 * $Impact_infectionsByRequestedTime);
    $Impact_hospitalBedsByRequestedTime = floor($Data["totalHospitalBeds"] * 0.35 ) +1- $Impact_severeCasesByRequestedTime;
    $Severe_hospitalBedsByRequestedTime = floor($Data["totalHospitalBeds"] * 0.35 )+1 - $Severe_severeCasesByRequestedTime;

    //Question 3

    $Impact_casesForICUByRequestedTime = floor($Impact_infectionsByRequestedTime *0.05);
    $Severe_casesForICUByRequestedTime = floor($SevereImpact_infectionsByRequestedTime * 0.05);

    $Severe_casesForVentilatorsByRequestedTime = floor($SevereImpact_infectionsByRequestedTime *0.02);
    $Impact_casesForVentilatorsByRequestedTime =floor($Impact_infectionsByRequestedTime * 0.02);

    $Impact_dollarsInFlight = floor(($Impact_infectionsByRequestedTime* $Data["region"]["avgDailyIncomeInUSD"]* $Data["region"]["avgDailyIncomePopulation"])/30);
    $Severe_dollarsInFlight = floor(($SevereImpact_infectionsByRequestedTime * $Data["region"]["avgDailyIncomeInUSD"]* $Data["region"]["avgDailyIncomePopulation"])/30);


    $Jresult =  [ 'data' => $Data , 'impact'=> [ 'currentlyInfected' => $Impact_currentlyInfected ,'infectionsByRequestedTime'=>
      $Impact_infectionsByRequestedTime,'severeCasesByRequestedTime'=> $Impact_severeCasesByRequestedTime,'hospitalBedsByRequestedTime'=>$Impact_hospitalBedsByRequestedTime,'casesForICUByRequestedTime'=> $Impact_casesForICUByRequestedTime,'casesForVentilatorsByRequestedTime'=>$Impact_casesForVentilatorsByRequestedTime, 'dollarsInFlight'=>$Impact_dollarsInFlight ],'severeImpact' =>['currentlyInfected'=>$SevereImpact_currentlyInfected ,
          'infectionsByRequestedTime'=>$SevereImpact_infectionsByRequestedTime ,'severeCasesByRequestedTime'=> $Severe_severeCasesByRequestedTime,'hospitalBedsByRequestedTime' =>$Severe_hospitalBedsByRequestedTime,'casesForICUByRequestedTime'=>$Severe_casesForICUByRequestedTime,'casesForVentilatorsByRequestedTime'=>$Severe_casesForVentilatorsByRequestedTime,'dollarsInFlight' =>$Severe_dollarsInFlight]];

    return json_encode($Jresult) ;
}

$dadawa= [
'region'=> [
'name'=> 'Africa',
'avgAge'=> '19.7',
'avgDailyIncomeInUSD'=> '1',
'avgDailyIncomePopulation'=> '0.65'
],
'periodType'=> 'days',
'timeToElapse'=>'34',
'reportedCases'=> '1698',
'population' =>'9956818',
'totalHospitalBeds'=> '117197'
];
echo(covid19ImpactEstimator($dadawa));



?>
