<?php

namespace App\Helpers;

use App\Models\Notification;

class NotificationHelper
{
    public static function create(
        object $notifiable,
        string $type,
        string $title,
        string $message,
        ?string $link = null
    ): Notification {
        return Notification::create([
            'notifiable_type' => get_class($notifiable),
            'notifiable_id'   => $notifiable->id,
            'type'            => $type,
            'title'           => $title,
            'message'         => $message,
            'link'            => $link,
            'is_read'         => false,
        ]);
    }

    public static function getUnread(object $notifiable, int $limit = 10)
    {
        return Notification::where('notifiable_type', get_class($notifiable))
            ->where('notifiable_id', $notifiable->id)
            ->unread()
            ->latest()
            ->limit($limit)
            ->get();
    }

    public static function getRecent(object $notifiable, int $limit = 10)
    {
        return Notification::where('notifiable_type', get_class($notifiable))
            ->where('notifiable_id', $notifiable->id)
            ->latest()
            ->limit($limit)
            ->get();
    }

    public static function unreadCount(object $notifiable): int
    {
        return Notification::where('notifiable_type', get_class($notifiable))
            ->where('notifiable_id', $notifiable->id)
            ->unread()
            ->count();
    }
}
