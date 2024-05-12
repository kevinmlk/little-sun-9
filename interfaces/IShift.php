<?php

interface IShift {
  public static function getAllShifts();

  public static function getUserShifts($userId);

  public function addShift();
}