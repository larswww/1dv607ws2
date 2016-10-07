<?php

class CreateMemberForm{

  public function show(){
    return "
    <form action='?action=createNewMember' method='POST'>

    <legend>First name
      <input type='text' name='firstname'>
    </legend>

    <legend>Last name
      <input type='text' name='lastname'>
    </legend>

    <legend>Personal identity number
      <input type='text' name='personalNumber'>
    </legend>

    <input type='submit' name='RegisterMember'>
    ";
  }
}
