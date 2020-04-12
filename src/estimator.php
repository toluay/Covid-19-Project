<?php



function covid19ImpactEstimator($data)
{
  $Data = json_decode("+\"+$data+\"+);

  function currentlyFactor($bale){
    return $Data->reportedCases * $bale;
  } 

    //Question 1 
  $Impact_currentlyInfected = currentlyFactor(10);

  $SevereImpact_currentlyInfected = currentlyFactor(50);
     
  function infectionsByRequestedTimeFactor ($dayss , $InfectedMultiplier ){
    $calFactorial = $dayss % 3;
    return $InfectedMultiplier * 2^$calFactorial;
    }

    switch ($Data->periodType) {
      case 'days':
        $Impact_infectionsByRequestedTime =infectionsByRequestedTimeFactor($Data->timeToElapse, $Impact_currentlyInfected);
        break;
      case 'weeks':
        $Impact_infectionsByRequestedTime =infectionsByRequestedTimeFactor(($Data->timeToElapse * 7), $Impact_currentlyInfected);      
        break;
      case 'months':
        $Impact_infectionsByRequestedTime =infectionsByRequestedTimeFactor(($Data->timeToElapse * 7 * 30), $Impact_currentlyInfected);
        break;
      
      default:
        $Impact_infectionsByRequestedTime =infectionsByRequestedTimeFactor($Data->timeToElapse, $Impact_currentlyInfected);
        break;
    }

    switch ($Data->periodType) {
      case 'days':
        $SevereImpact_infectionsByRequestedTime =infectionsByRequestedTimeFactor($Data->timeToElapse, $SevereImpact_currentlyInfected);
        break;
      case 'weeks':
        $SevereImpact_infectionsByRequestedTime =infectionsByRequestedTimeFactor(($Data->timeToElapse * 7), $SevereImpact_currentlyInfected);      
        break;
      case 'months':
        $SevereImpact_infectionsByRequestedTime =infectionsByRequestedTimeFactor(($Data->timeToElapse * 7 * 30), $SevereImpact_currentlyInfected);
        break;
      
      default:
        $SevereImpact_infectionsByRequestedTime =infectionsByRequestedTimeFactor($Data->timeToElapse, $SevereImpact_currentlyInfected);
        break;
    }
    

    $Jresult = "{ data :"+ $data + " ,impact: { currentlyInfected:"+ 
      $Impact_currentlyInfected 
      + ",infectionsByRequestedTime:"+
      $Impact_infectionsByRequestedTime
       +"},severeImpact :{currentlyInfected:"+
         $SevereImpact_currentlyInfected 
         + ",
          infectionsByRequestedTime:"+$SevereImpact_infectionsByRequestedTime+ "}
        }";
    return $Jresult ;
}