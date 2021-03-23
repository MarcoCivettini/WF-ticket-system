<?php

namespace App\Model;

abstract class TaskStatus
{
    public const New = 1;
    public const OnWorking = 2;
    public const Closed = 3;
}
