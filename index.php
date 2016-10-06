<?php
// REQUIRE MODELS
require_once("model/database.php");
require_once("model/member.php");
require_once("model/boat.php");

// REQUIRE VIEW
require_once("view/view.php");

// REQUIRE CONTROLLERS
require_once("controller/PartialFactory.php");

error_reporting(E_ALL);
ini_set('display_errors', 'On');

$partial = (new PartialFactory())->getRenderedPartial();

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
