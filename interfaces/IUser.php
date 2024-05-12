<?php

interface IUser {
  // User login method
  public function loginUser();

  // User creation method for Admin only
  public function createUser();

  public function editUserPassword();

  // Function to get all users
  public static function getAllUsers();

  public static function getLastAddedUser();
}