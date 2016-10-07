<?php

// REQUIRE PARTIALS
require_once("partials/AddBoatForm.php");
require_once("partials/Blank.php");
require_once("partials/BoatCreated.php");
require_once("partials/BoatDeleted.php");
require_once("partials/BoatUpdated.php");
require_once("partials/CompactList.php");
require_once("partials/CompactList.php");
require_once("partials/CreateMemberForm.php");
require_once("partials/Errorpartial.php");
require_once("partials/MemberCreated.php");
require_once("partials/MemberDeleted.php");
require_once("partials/MemberUpdated.php");
require_once("partials/UpdateBoatForm.php");
require_once("partials/UpdateMemberForm.php");
require_once("partials/VerboseList.php");
require_once("partials/ViewMember.php");

class MainLayout {

  private $maincontent;
  private $title = "Välkommen till båtklubben den lila illern";

  public function __construct($partial){
    $this->maincontent = $partial->show();
  }

  public function render() {

      echo "<!DOCTYPE html>
        <html>
          <head>
            <meta charset='utf-8'>
            <title>Workshop 2 | 1dv607</title>
          </head>
          <body>
          <nav>
            <a href='?action=verboseList'>Verbose</a>
            <a href='?action=compactList'>Compact</a>
            <a href='?action=createNewMember'>New member</a>
          </nav>
            <h1>{$this->title}</h1>
            <div>
              {$this->maincontent}
            </div>
           </body>
        </html>
      ";
    }
}
