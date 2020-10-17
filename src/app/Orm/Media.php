<?php

namespace App\Orm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMedia;

class Media extends SpatieMedia implements AuditableContract
{
    use Auditable, HasFactory, SoftDeletes;

    // Relative file path in Storage::disk('public')
    const DEFAULT_COVER_IMAGE = 'images/default-cover.jpg';

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

    /**
     * @return resource|null
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getDefaultCoverImageStream()
    {
        return Storage::disk('public')->readStream(self::DEFAULT_COVER_IMAGE);
    }
}
