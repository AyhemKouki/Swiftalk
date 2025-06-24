<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{receiver_id}', function ($user, $receiver_id) {
    return (int) $user->id === (int) $receiver_id;
});

Broadcast::channel('group.{groupId}', function ($user, $groupId) {
    // Vérifier si l'utilisateur est membre du groupe
    return \App\Models\Group::find($groupId)?->isMember($user);
});
