<?php

namespace App\Models;
class Calendar  
{

  public ?string $year;
  public ?string $month;
  public ?string $day;
  public ?string $today;


  public function __construct()
  {
    $this->year = date('Y');
    $this->month = date('m');
    $this->day = date('d');
    $this->today = date('Y-m-d');

    echo 'Calendar';
  }
} 