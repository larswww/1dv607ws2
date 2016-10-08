<?php
// REQUIRE MODELS
require_once('model/RegistryDatabase.php');
require_once('model/Member.php');
require_once('model/Boat.php');

// REQUIRE VIEW
require_once("view/view.php");

// REQUIRE CONTROLLERS
require_once("controller/PartialFactory.php");

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$db = new model\registryDatabase();
$m = new model\Member();
$b = new model\Boat();

$partial = (new PartialFactory($db, $m, $b))->getRenderedPartial();

// RENDER HTML
(new MainLayout($partial))->render();

// $db = new model\registryDatabase();
// $member = new model\Member();
// $member->setMemberName("Lars");
// $member->setPassportNumber(343434);
//
// $boat = new model\Boat();
// $boat->setBoatLength(7);
// $boat->setBoatType("Other");
//
// $db->createMember($member);
// $db->createBoat($boat);
//
// $db->registerBoatFor("57f63bf2ab790", "57f63bf2abbe9");

//$db->getBoat(1);
//$db->getMember(1);
