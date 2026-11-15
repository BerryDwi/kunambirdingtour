<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait ManagesImages
{
    /**
     * Resolve an image from an upload, the URL field, or the current value.
     */
    protected function resolveImage(
        Request $request,
        string $fileField,
        string $urlField,
        ?string $currentImage,
        string $directory,
    ): ?string {
        if ($request->hasFile($fileField)) {
            $this->deleteStoredImage($currentImage);

            return $request->file($fileField)->store($directory, 'public_uploads');
        }

        if ($request->boolean('remove_image')) {
            $this->deleteStoredImage($currentImage);

            return null;
        }

        $image = $request->validated($urlField);

        return filled($image) ? $image : $currentImage;
    }

    /**
     * Delete a locally stored image. External URLs are left untouched.
     */
    protected function deleteStoredImage(?string $image): void
    {
        if (filled($image) && ! Str::startsWith($image, ['http://', 'https://', '//'])) {
            Storage::disk('public_uploads')->delete($image);
        }
    }
}
