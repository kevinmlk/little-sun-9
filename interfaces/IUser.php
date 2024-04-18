<?php

interface IUser {
  // User login method
  public function loginUser();

  // User creation method for Admin only
  public function createUser();

  // Function to get all users
  public static function getAllUsers();
}