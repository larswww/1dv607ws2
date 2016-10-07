<?php

class UpdateMemberForm{

  private $id;
  private $firstname;
  private $lastname;
  private $personalNumber;

  public function __construct($id, $firstname, $lastname, $personalNumber){
    $this->id = $id;
    $this->firstname = $firstname;
    $this->lastname = $lastname;
    $this->personalNumber = $personalNumber;
    $this->boats = $boats;
  }

  public function show(){
    return "
    <form action='?action=updateMember&id={$this->id}' method='POST'>

    <legend>First name
      <input type='text' name='firstname' value='{$this->firstname}'>
    </legend>

    <legend>Last name
      <input type='text' name='lastname' value='{$this->lastname}'>
    </legend>

    <legend>Personal identity number
      <input type='text' name='personalNumber' value='{$this->personalNumber}'>
    </legend>

    <input type='submit' name='UpdateMember'>
    <a href='?action=deleteMember&id={$this->id}'>Delete member</a>
    ";
  }
}
