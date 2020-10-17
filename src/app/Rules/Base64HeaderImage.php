<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Validate that the input is a base64 encoded image of suitable mime type and dimensions
 *
 * @package App\Rules
 */
class Base64HeaderImage implements Rule
{
    protected int $minWidth;
    protected int $maxWidth;
    protected int $minHeight;
    protected int $maxHeight;

    protected $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/webp'
    ];

    public function __construct()
    {
        $this->minWidth = config('improv.images.header.width.min');
        $this->maxWidth = config('improv.images.header.width.max');
        $this->minHeight = config('improv.images.header.height.min');
        $this->maxHeight = config('improv.images.header.height.max');
    }


    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $data = $this->base64Decode($value);


        // Not base64-encoded data
        if ($data === false) {
            return false;
        }
        $mimeType = $this->getMimeType($data);

        // Not allowed mime type
        if (!$mimeType || !in_array($mimeType, $this->allowedMimeTypes)) {
            return false;
        }

        $imageSize = getimagesizefromstring($data);

        // Not an image
        if (!$imageSize) {
            return false;
        }

        $width = $imageSize[0];
        $height = $imageSize[1];

        // Dimensions out of bounds
        if (!$this->between($width, $this->minWidth, $this->maxWidth) || !$this->between($height, $this->minHeight, $this->maxHeight)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.not_valid_header', [
            'minHeight' => $this->minHeight,
            'maxHeight' => $this->maxHeight,
            'minWidth' => $this->minWidth,
            'maxWidth' => $this->maxWidth
        ]);
    }

    private function between($input, $min, $max)
    {
        return $input >= $min && $input <= $max;
    }

    /**
     * @param $value
     * @return bool|string
     */
    private function base64Decode($value) : string
    {
        // Strip out data uri scheme information (see RFC 2397)
        if (strpos($value, ';base64') !== false) {
            [$_, $value] = explode(';', $value);
            [$_, $value] = explode(',', $value);
        }

        return base64_decode($value);
    }

    /**
     * @param $data
     * @return string
     */
    private function getMimeType($data): string
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'image');
        $f = fopen($tempFile, 'w');
        fwrite($f, $data);

        $mimeType = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $tempFile);

        fclose($f);
        unlink($tempFile);

        return $mimeType;
    }
}
