<?php

namespace App\Orm;

use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Spatie\MediaLibrary\Models\Media as SpatieMedia;

class Media extends SpatieMedia implements AuditableContract
{
    use Auditable;

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