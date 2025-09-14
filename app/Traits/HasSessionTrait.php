<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

trait HasSessionTrait
{
    /**
     * Get the current sessions.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function sessions($user_id)
    {
        if (config('session.driver') !== 'database') {
            return []; // Return an empty array if session driver is not 'database'
        }

        $sessions = DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('user_id', $user_id)
            ->orderBy('last_activity', 'desc')
            ->get();

        $result = [];

        foreach ($sessions as $session) {
            $agent = $this->createAgent($session);
            $result[] = [
                'agent' => $agent,
                'ip_address' => $session->ip_address,
                'is_current_device' => false,
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        }

        return $result;
    }

    /**
     * Create a new agent instance from the given session.
     *
     * @param  mixed  $session
     * @return \Laravel\Jetstream\Agent
     */
    protected function createAgent($session)
    {
        return tap(new Agent(), fn($agent) => $agent->setUserAgent($session->user_agent));
    }
}
