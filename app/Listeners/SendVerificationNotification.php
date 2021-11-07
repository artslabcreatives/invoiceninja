<?php
/**
 * Hype Sri Lanka (https://hypesl.org).
 *
 * @link https://github.com/artslabcreatives/invoiceninja source repository
 *
 * @copyright Copyright (c) 2021. Hype Sri Lanka (https://hypesl.org)
 *
 * @license https://www.elastic.co/licensing/elastic-license
 */

namespace App\Listeners;

use App\Jobs\Mail\NinjaMailer;
use App\Jobs\Mail\NinjaMailerJob;
use App\Jobs\Mail\NinjaMailerObject;
use App\Libraries\MultiDB;
use App\Mail\Admin\VerifyUserObject;
use App\Mail\User\UserAdded;
use App\Utils\Ninja;
use Exception;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Carbon;

class SendVerificationNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        nlog("In Send Verification Notification");
        
        MultiDB::setDB($event->company->db);

        $event->user->service()->invite($event->company);


        if(Carbon::parse($event->company->created_at)->lt(now()->subDay()))
        {
            App::forgetInstance('translator');
            $t = app('translator');
            $t->replace(Ninja::transformTranslations($event->company->settings));

            $nmo = new NinjaMailerObject;
            $nmo->mailable = new UserAdded($event->company, $event->creating_user, $event->user);
            $nmo->company = $event->company;
            $nmo->settings = $event->company->settings;
            $nmo->to_user = $event->creating_user;
            NinjaMailerJob::dispatch($nmo);
        }

    }
}
