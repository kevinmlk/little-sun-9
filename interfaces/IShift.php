<?php

interface IShift {
  public static function getAllShifts();

  public static function getUserShifts($userId);

  public function addShift();

  public function checkIn($shiftId);

  public function checkOut($shiftId);

  public static function getUserDaysOff($employeeId);

  public static function getUserAbsents($employeeId);

  public function addAbsent($employeeId);
}