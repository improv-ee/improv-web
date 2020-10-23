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

        $seoMeta = [
            'description' => $event->production->excerpt,
            'keywords' => implode(',', $keywords),
        ];

        return view('frontpage', [
            'seo' => $seoMeta,
            'title' => config('app.name') . '|' . $event->production->title
        ]);
    }
}
