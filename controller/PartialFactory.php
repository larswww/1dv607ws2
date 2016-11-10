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
      $boatNr = $_GET['boatId'];
      $memberId = $_GET['memberId'];
      $member = $this->db->getMember($memberId);
      $memberBoats = $member->getBoats();

      return new UpdateBoatForm($memberBoats[$boatNr], $memberId, $boatNr);
    }

    $memberId = $_POST['boatId'];
    $member = $this->db->getMember($memberId);
      $this->boatModel->setBoatType($ip->type);
      $this->boatModel->setBoatLength($ip->length);
      $member->updateBoat($this->boatModel, $ip->boatNr);
    $this->db->updateMember($memberId, $member);
    return new BoatUpdated();
  }

  private function deleteBoat(){
      $id = $_GET['memberId'];
      $member = $this->db->getMember($id);
      $member->removeBoat($_GET['boatId']);
      $this->db->updateMember($id, $member);

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

    $this->boatModel->setBoatType($ip->type);
    $this->boatModel->setBoatLength($ip->length);
     $addForMember = $this->db->getMember($ip->memberId);
      $addForMember->addBoat($this->boatModel);

      $this->db->updateMember($ip->memberId, $addForMember);

    return new BoatCreated();
  }

  private function viewMember(){
      $member = $this->db->getMember($_GET['id']);

    return new ViewMember($member);
  }

  private function UpdateMember(){
    $ip = $this->incomingParams;
    $m = $this->db->getMember($_GET['id']);

    if($ip->noIncomingParams){
      return new UpdateMemberForm($m);
    }

    $m->setMemberName($ip->firstname, $ip->lastname);
      $m->setPassportNumber($ip->personalNumber);

    $this->db->updateMember($ip->id, $m);

    return new MemberUpdated();
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
