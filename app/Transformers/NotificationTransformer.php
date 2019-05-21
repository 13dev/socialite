<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class NotificationTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($notification)
    {
        // return [
        //     'created_at' => optional($notification->created_at)->diffForHumans(),
        //     'data' => $notification->data,
        //     'read_at' => optional($notification->read_at)->diffForHumans(),
        //     'type' => $notification->type,
        //     'updated_at' => $notification->updated_at,
        // ];

        return array_merge($notification->data, [
            'type' => $notification->type,
            'created_at' => optional($notification->created_at)->diffForHumans(),
        ]);
    }
}
