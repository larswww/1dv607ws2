<?php
require_once("IncomingParams.php");

class PartialFactory{

  private $action;
  private $db;
    private $memberModel;
    private $boatModel;
  private $incomingParams;

  public function __construct($database, $member, $boat){
    $this->action = (!empty($_GET) && isset($_GET['action'])) ? $_GET['action'] : 'blank';
    $this->db = $database;
      $this->memberModel = $member;
      $this->boatModel = $boat;
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
    if($ip->noIncomingParams){
      return new UpdateBoatForm();
    }

    $ip = $this->incomingParams;
    if($ip->noIncomingParams){
      return new
    }

    $data = $this->db($ip->boatId, $ip->length, $ip->type); // Get data from corresponding model
    return new BoatUpdated();
  }

  private function deleteBoat(){
    $this->db($_GET['boatId']);
    return new BoatDeleted();
  }

  private function deleteMember(){
    $this->db($_GET['memberId']);
    return new MemberDeleted();
  }

  private function addBoat() {
    $ip = $this->incomingParams;
    if($ip->noIncomingParams){
      return new AddBoatForm();
    }

    $this->memberModel->setMemberName($ip->firstname);
    $this->memberModel->setPassportNumber($ip->personalNumber);

    $this->db->createMember($this->memberModel);

    return new BoatCreated();
  }

  private function createNewMember() {
    $ip = $this->incomingParams;
    if($ip->noIncomingParams){
      return new CreateMemberForm();
    }

    $this->memberModel->setMemberName($ip->firstname);
    $this->memberModel->setPassportNumber($ip->personalNumber);

    $this->db->createMember($this->memberModel);

    return new MemberCreated();
  }
}
