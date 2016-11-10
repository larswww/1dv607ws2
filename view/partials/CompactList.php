<?php

class CompactList{

  private $memberList;

  public function __construct($memberList){
    $this->memberList = $memberList;
  }

  public function show(){
    $str = "";

      for ($i = 0; $i < count($this->memberList); $i++) {
          $currentMember = $this->memberList[$i];
          $id = $currentMember->getID();
          $boats = $currentMember->getBoats();
          $boatCount = count($boats);
          $firstname = $currentMember->getFirstName();
          $lastname = $currentMember->getLastName();

          $str .= "
      <div class='listBox'>
      <a href='?action=viewMember&id={$id}'>view member info</a><br>
      name: {$firstname} {$lastname}<br>
      id: {$id}<br>
      Number of boats: {$boatCount}
      </div>
      ";

      }

    return $str;
  }
}
