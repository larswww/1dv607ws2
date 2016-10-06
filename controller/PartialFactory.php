<?php

class PartialFactory{

  private $action;

  public function __construct(){
    $this->action = (!empty($_GET) && isset($_GET['action'])) ? $_GET['action'] : 'blank';
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
    $data = array(); // Get data from corresponding model
    return new CompactList($data);
  }

  private function verboseList(){
    $data = array(); // Get data from corresponding model
    return new VerboseList($data);
  }

  private function editBoat(){
    // dbRequest()
    return new BoatUpdated();
  }

  private function deleteBoat(){
    // dbRequest()
    return new BoatDeleted();
  }

  private function deleteMember(){
    // dbRequest()
    return new MemberDeleted();
  }

  private function createNewMember() {
    // dbRequest()
    return new CreateMemberForm();
  }
}
