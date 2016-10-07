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
          $boatCount = count($currentMember['boats']);
          $str .= "
      <div class='listBox'>
      name: {$currentMember['member']['memberName']}<br>
      id: {$currentMember['member']['ID']}<br>
      Number of boats: {$boatCount}
      </div>
      ";

      }

//    foreach ($this->memberList as $key => $value) {
//      $numberOfBoats = $this->numberOfBoats($key['boats']);
//
//      $str .= "
//      <div class='listBox'>
//      name: {$key['firstName']} {$key['lastName']}<br>
//      id: {$key['memberId']}<br>
//      Number of boats: {$numberOfBoats}
//      </div>
//      ";
//    }

    return $str;
  }

  private function numberOfBoats($boats){
    return count($boats);
  }
}
