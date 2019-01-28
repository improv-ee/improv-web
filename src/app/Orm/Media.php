<?php

namespace App\Orm;

use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Spatie\MediaLibrary\Models\Media as SpatieMedia;

class Media extends SpatieMedia implements AuditableContract
{
    use Auditable;
}