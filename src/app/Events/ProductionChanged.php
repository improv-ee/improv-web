<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class ProductionChanged {
    use SerializesModels;

    public function __construct()
    {

    }
}