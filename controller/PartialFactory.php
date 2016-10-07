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
    $data = $this->db->listMembers();
    return new CompactList($data);
  }

  private function verboseList(){
    $data = $this->db->listMembers();
    return new VerboseList($data);
  }

  private function editBoat(){
    $ip = $this->incomingParams;
    if($ip->noIncomingParams){
      return new UpdateBoatForm();
    }

    $this->boatModel->setBoatLength($ip->length);
      $this->boatModel->setBoatType($ip->type);

    $data = $this->db->updateBoat($ip->boatId, $this->boatModel); // Get data from corresponding model
    return new BoatUpdated();
  }

  private function deleteBoat(){
    $this->db->deleteBoat($_GET['boatId']);
    return new BoatDeleted();
  }

  private function deleteMember(){
    $this->db->deleteMember($_GET['memberId']);
    return new MemberDeleted();
  }

  private function addBoat() {
    $ip = $this->incomingParams;
    if($ip->noIncomingParams){
      return new AddBoatForm();
    }

    $this->boatModel->setBoatType($ip->length);
    $this->boatModel->setBoatLength($ip->type);

    $this->db->createBoat($this->boatModel);

    return new BoatCreated();
  }

  private function viewMember(){
    $ip = $this->incomingParams;
    $data = $this->db->getMember($_GET['id']);

    //$member = $this->memberModel->getMember();
    print_r($data);
    $memberId = "";
    $firstname = "";
    $lastname = "";
    $personalNumber = "";
    $boats = array();
return new CreateMemberForm();
    return new ViewMember($memberId, $firstname, $lastname, $personalNumber, array $boats);
  }

  private function UpdateMemberForm(){
    print_r($_GET);
  }

  private function createNewMember() {
    $ip = $this->incomingParams;
    if($ip->noIncomingParams){
      return new CreateMemberForm();
    }

    $this->memberModel->setMemberName($ip->firstname, $ip->lastname);
    $this->memberModel->setPassportNumber($ip->personalNumber);

    $this->db->createMember($this->memberModel);

    return new MemberCreated();
  }
}
