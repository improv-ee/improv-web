<?php

namespace App\Http\Controllers;


use App\Orm\Event;

class EventController extends Controller
{
    public function show(Event $event)
    {
        $keywords = [$event->production->title];
        foreach ($event->production->organizations()->get() as $org) {
            $keywords[] = $org->name;
        }

        $image = $event->getHeaderImage();
        $seoMeta = [
            'description' => $event->production->excerpt,
            'keywords' => implode(',', $keywords),
            'image' => $image ? $image->getUrl('cover') : null
        ];

        return view('frontpage', [
            'seo' => $seoMeta,
            'title' => sprintf('%s (%s; %s) - %s',
                $event->getTitleOrParent(),
                $event->start_time->toFormattedDateString(),
                $event->production->organizations()->get()->pluck('name')->implode(', '),
                strtolower(config('app.name'))
            )
        ]);
    }
}
