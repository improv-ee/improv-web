<?php

namespace App\Orm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMedia;

class Media extends SpatieMedia implements AuditableContract
{
    use Auditable, HasFactory;

    /**
     * Return an unique hash of this Media object
     *
     * Currently a pseudo-hash, future refactoring: take checksum of content
     *
     * @return string
     */
    public function getHash()
    {
        return sha1($this->size . $this->file_name);
    }
}
