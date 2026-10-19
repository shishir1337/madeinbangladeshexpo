<?php

namespace App\Http\Controllers;

use App\Models\GalleryAlbum;
use App\Support\Images\ImageManifest;
use Illuminate\Contracts\View\View;

class GalleryController extends Controller
{
    /**
     * Every album, in editor order.
     */
    public function index(): View
    {
        return view('pages.gallery.index', [
            'albums' => GalleryAlbum::query()->withCount('photos')->ordered()->get(),
        ]);
    }

    /**
     * One album: a photo grid that opens a lightbox, with ImageGallery structured data.
     */
    public function show(GalleryAlbum $album, ImageManifest $images): View
    {
        $album->load('photos');

        return view('pages.gallery.show', [
            'album' => $album,
            'structuredData' => [
                '@context' => 'https://schema.org',
                '@type' => 'ImageGallery',
                'name' => $album->title,
                'description' => $album->description,
                'url' => url()->current(),
                'image' => $album->photos->map(fn ($photo): array => [
                    '@type' => 'ImageObject',
                    'contentUrl' => $images->url($photo->image, 1200, 'jpg'),
                    'caption' => $photo->caption,
                ])->all(),
            ],
        ]);
    }
}
