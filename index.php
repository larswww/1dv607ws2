<?php
require_once("model/database.php");
require_once("model/member.php");
require_once("model/boat.php");


error_reporting(E_ALL);
ini_set('display_errors', 'On');

$db = new model\registryDatabase();

//test code for creating a boat and member manually
$member = new model\Member();
$member->setMemberName("Skrot Nisse");
$member->setPassportNumber(1337);
//
//$boat = new model\Boat();
//$boat->setBoatLength(7);
//$boat->setBoatType("Other");
//
//$db->createMember($member);
//$db->createBoat($boat);

//$db->registerBoatFor("57f657d392143", "57f6587e291c0"); // memberID, boatID
//$db->removeBoatFor("57f657d392143", "57f6587e291c0");

//$db->updateMember("57f657b59e13b", $member);

//$db->deleteMember("57f657b59e13b");

$db->listMembers();

//$db->getBoat(1);
//$db->getMember(1);

