<?php

namespace App\Listeners;

use App\Events\SearchKeyword;
use App\Models\SearchHistory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSearchhistory
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SearchKeyword  $event
     * @return void
     */
    public function handle(SearchKeyword $event)
    {
        //
        $insert_data=[
            'user_id'=>$event->data['user_id'],
            'from'   =>$event->data['from'],
            'keyword'=>$event->keyWord,
        ];
        SearchHistory::create($insert_data);
    }
}
