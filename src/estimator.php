<?php



function covid19ImpactEstimator($data)
{
  $Data = json_decode($data);

  function currentlyFactor($bale){
    return $Data->reportedCases * $bale;
  } ;

    
  $Impact_currentlyInfected = currentlyFactor(10);
  $SevereImpact_currentlyInfected = currentlyFactor(50);
     

    return json_decode('{ data : $data,
          impact: {currentlyInfected:$Impact_currentlyInfected,
            infectionsByRequestedTime:fffff},
          severeImpact : {currentlyInfected:$SevereImpact_currentlyInfected,
            infectionsByRequestedTime:nnnn}
          }');
};