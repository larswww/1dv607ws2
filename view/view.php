<?php
namespace View;

class MainLayout {

  private $maincontent;

  public function __construct($mainPartial, array $data){
    $this->maincontent = (new $mainpartial(...$data))->show();
  }

  public function render() {
    $this->maincontent->show();
      echo "<!DOCTYPE html>
        <html>
          <head>
            <meta charset='utf-8'>
            <title>Workshop 2 | 1dv607</title>
          </head>
          <body>
          <nav>
            <a href='?action=verboseList'>Compact</a>
            <a href='?action=compactList'>Verbose</a>
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
/*
arguments:
  firstname
  lastname
  personalnumber
  memberId
  boatType
  boatLength

methods:
  createMember    firstname, lastname, personalnumber
  viewMember      memberId, firstname, lastname, personalNumber,
  updateMember    firstname, lastname, personalnumber
  deleteMember    id
  compactList
  verboselist
  registerBoat    type, length
  deleteBoat      id
  updateBoat      id, type, length

mainPartials:
  ViewMember($memberId, $firstname, $lastname, $personalNumber, array $boats)
  UpdateMemberForm($id, $firstname, $lastname, $personalNumber)
  CreateMemberForm()
  Error($message)
*/
