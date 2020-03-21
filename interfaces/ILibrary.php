<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ILibrary
 *
 * @author skliz
 */

 interface ILibrary {
    //put your code here
     function passwordSyntax();
     
     function Redirect($location);
     
     function destroySessions();
     
     function returnAdmins();
     
     function returnPreachers();
     
     function returnContinent();
     
     function returnCountry($continentid);
     function checkIfStateAlreadyExits($countryid,$state)
     ;
     
     function returnPreachername($preacherid);
     
     function returnPreacherIDbyname($preachername);
     
     function returnMemberID($Username);
     
     function returnPreacherID($messageid);
     
     function selectBranches();
     
     function returnFellowshipCenterinLocation($branchid,$cityid);
     
     function logMedia($mediatype, $title,$preacherid,$medianame);
     
     function displayFellowshipnames($branchid);
     
     function protectPages();
     
     function returnWeddingModel($id,$branchid,$webserviceObject);
     
     function returnMessageModel($messageId, $branchid, $webserviceMsgObject);
     
     function returnMemberUsername($memberid);
     
     function returnQuestionModel($quesid, $branchid,$questionModel);
     
     function displayQuestions($messageid, $status, $branchid, $questionjson);
     
     function stopInjection($value);
     
     function filter($value);
     
     function doEncryption($value);
     
     function checkDateformat($date);
}

?>
