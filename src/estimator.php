<?php


function covid19ImpactEstimator($Data)
{
    function currentlyFactor($bale){
    return $Data['reportedCases'] * $bale;
  } 


    //Question 1 
  $Impact_currentlyInfected = currentlyFactor(10);

  $SevereImpact_currentlyInfected = currentlyFactor(50);
     
  function infectionsByRequestedTimeFactor ($dayss , $InfectedMultiplier ){
    $calFactorial = $dayss % 3;
    return $InfectedMultiplier * 2^$calFactorial;
    }

    switch ($Data["periodType"]) {
      case 'days':
        $Impact_infectionsByRequestedTime =infectionsByRequestedTimeFactor($Data["timeToElapse"], $Impact_currentlyInfected);
        break;
      case 'weeks':
        $Impact_infectionsByRequestedTime =infectionsByRequestedTimeFactor(($Data["timeToElapse"] * 7), $Impact_currentlyInfected);      
        break;
      case 'months':
        $Impact_infectionsByRequestedTime =infectionsByRequestedTimeFactor(($Data["timeToElapse"] * 7 * 30), $Impact_currentlyInfected);
        break;
      
      default:
        $Impact_infectionsByRequestedTime =infectionsByRequestedTimeFactor($Data["timeToElapse"], $Impact_currentlyInfected);
        break;
    }

    switch ($Data->periodType) {
      case 'days':
        $SevereImpact_infectionsByRequestedTime =infectionsByRequestedTimeFactor($Data["timeToElapse"], $SevereImpact_currentlyInfected);
        break;
      case 'weeks':
        $SevereImpact_infectionsByRequestedTime =infectionsByRequestedTimeFactor(($Data["timeToElapse"] * 7), $SevereImpact_currentlyInfected);      
        break;
      case 'months':
        $SevereImpact_infectionsByRequestedTime =infectionsByRequestedTimeFactor(($Data["timeToElapse"] * 7 * 30), $SevereImpact_currentlyInfected);
        break;
      
      default:
        $SevereImpact_infectionsByRequestedTime =infectionsByRequestedTimeFactor($Data["timeToElapse"], $SevereImpact_currentlyInfected);
        break;
    }
 //Question 2 answered .....

    $Severe_severeCasesByRequestedTime= 0.15 * $SevereImpact_infectionsByRequestedTime;
    $Impact_severeCasesByRequestedTime = 0.15 * $Impact_infectionsByRequestedTime;
    $Impact_hospitalBedsByRequestedTime = ($Data["totalHospitalBeds"] * 0.35 * 0.95) - $Impact_severeCasesByRequestedTime;
    $Severe_hospitalBedsByRequestedTime = ($Data["totalHospitalBeds"] * 0.35 * 0.95) -  $Severe_severeCasesByRequestedTime;
    
    //Question 3 

    $Impact_casesForICUByRequestedTime = $Impact_infectionsByRequestedTime *0.05;
    $Severe_casesForICUByRequestedTime = $SevereImpact_infectionsByRequestedTime * 0.05;

    $Severe_casesForVentilatorsByRequestedTime = $Impact_infectionsByRequestedTime *0.02;
    $Impact_casesForVentilatorsByRequestedTime =$SevereImpact_infectionsByRequestedTime * 0.02;
    
    
    $Jresult =  [ 'data' => $data , 'impact'=> [ 'currentlyInfected' => $Impact_currentlyInfected ,'infectionsByRequestedTime'=>
      $Impact_infectionsByRequestedTime,'severeCasesByRequestedTime'=> $Impact_severeCasesByRequestedTime,'hospitalBedsByRequestedTime'=>$Impact_hospitalBedsByRequestedTime,'casesForICUByRequestedTime'=> $Impact_casesForICUByRequestedTime,'casesForVentilatorsByRequestedTime'=>$Impact_casesForVentilatorsByRequestedTime ],'severeImpact' =>['currentlyInfected'=>$SevereImpact_currentlyInfected ,
          'infectionsByRequestedTime'=>$SevereImpact_infectionsByRequestedTime ,'severeCasesByRequestedTime'=> $Severe_severeCasesByRequestedTime,'hospitalBedsByRequestedTime' =>$Severe_hospitalBedsByRequestedTime,'casesForICUByRequestedTime'=>$Severe_casesForICUByRequestedTime,'casesForVentilatorsByRequestedTime'=>$Severe_casesForVentilatorsByRequestedTime]];

    return json_encode($Jresult) ;
}
?>