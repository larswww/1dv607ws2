<?php

require_once("IncominParams.php");

class PartialFactory{

  private $action;
  private $db;
  private $incomingParams;

  public function __construct(){
    $this->action = (!empty($_GET) && isset($_GET['action'])) ? $_GET['action'] : 'blank';
    $this->db = new \model\registryDatabase();
    $this->incomingParams = new IncomingParams();
  }

  public function getRenderedPartial(){
    try {
      $partialFunction = $this->action;
      $partial = $this->$partialFunction();
    } catch (Exception $e) {
      return new Errorpartial($e->getMessage());
    }

    return $partial;
  }

  private function blank(){
    return new Blank();
  }

  private function compactList(){
    $data = $this->db();
    return new CompactList($data);
  }

  private function verboseList(){
    $data = $this->db();
    return new VerboseList($data);
  }

  private function editBoat(){
    $ip = $this->incomingParams;
    $data = $this->db($ip->boatId, $ip->length, $ip->type); // Get data from corresponding model
    return new BoatUpdated();
  }

  private function deleteBoat(){
    $this->db($_GET['boatId']);
    return new BoatDeleted();
  }

  private function deleteMember(){
    $this->db($_GET['memberId'])
    return new MemberDeleted();
  }

  private function createNewMember() {
    $ip = $this->incomingParams;
    $this->db($ip->firstname, $ip->lastname, $ip->personalNumber)
    return new CreateMemberForm();
  }
}
