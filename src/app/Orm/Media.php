<?php

namespace App\Orm;

use OwenIt\Auditing\Auditable;
use Spatie\MediaLibrary\Models\Media as SpatieMedia;

class Media extends SpatieMedia
{
    use Auditable;
}