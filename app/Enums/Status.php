<?php

namespace App\Enums;

enum Status: string
{
    case New = "new";
    case Processing = "processing";
    case Checking = "checking";
    case Completed = "completed";
}
