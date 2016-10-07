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
          print_r($currentMember);
          $id = $currentMember['member']['ID'];
          $boatCount = count($currentMember['boats']);
          $str .= "
      <div class='listBox'>
      <a href='?action=viewMember&id={$id}'>view member info</a>
      name: {$currentMember['member']['firstName']} {$currentMember['member']['lastName']}<br>
      id: {$currentMember['member']['ID']}<br>
      Number of boats: {$boatCount}
      </div>
      ";

      }

    return $str;
  }

  private function numberOfBoats($boats){
    return count($boats);
  }
}
