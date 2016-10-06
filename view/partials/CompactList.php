<?php

class CompactList{

  private $memberList;

  public function __construct($memberList){
    $this->memberList = $memberList;
  }

  public function show(){
    $str = "";

    foreach ($this->memberList as $key => $value) {
      $numberOfBoats = $this->numberOfBoats($key['boats']);

      $str .= "
      <div class='listBox'>
      name: {$key['firstName']} {$key['lastName']}<br>
      id: {$key['memberId']}<br>
      Number of boats: {$numberOfBoats}
      </div>
      ";
    }
  }

  private function numberOfBoats($boats){
    return count($boats);
  }
}
