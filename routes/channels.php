<?php

use App\Models\FileUpload;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('progress.{fileId}', function ($user, $fileId) {
    return (int) $user->id === FileUpload::findOrNew($fileId)->user_id;
});