<?php

namespace Postmark;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ThrowExceptionOnFailurePlugin implements \Swift_Events_ResponseListener
{
    public function responseReceived(\Swift_Events_ResponseEvent $event)
    {
        if (!$event->isValid()) {
            if (Str::contains($event->getResponse(), 'ErrorCode":406')) {
                Log::critical($event->getResponse());
            } else {
                throw new \Swift_TransportException($event->getResponse());
            }
        }
    }
}
