<?php

namespace App\Listeners;

use App\Events\FootPrint;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\FootPrint as FootPrintModel;
class SendFootPrint
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
     * @param  FootPrint  $event
     * @return void
     */
    public function handle(FootPrint $event)
    {
        //
        $insert_data=[
            'user_id'=>$event->user_id,
            'goods_id'=>$event->goods_id,
        ];
        FootPrintModel::create($insert_data);
    }
}
