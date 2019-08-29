<?php

namespace App\Observers;

use App\Orm\Organization;
use Illuminate\Support\Facades\Log;

class OrganizationObserver
{

    use OrmDefaultTranslationTrait;

    /**
     * Handle the app orm organization "created" organization.
     *
     * @param  Organization $organization
     * @return void
     */
    public function created(Organization $organization)
    {

        if ($this->shouldTranslate()) {
            $this->addDefaultTranslation($organization);
        }

        Log::info('Created a new Organization', [
            'id' => $organization->id
        ]);
    }


    /**
     * Handle the organization "creating" organization.
     *
     * @param  \App\Orm\Organization $organization
     * @return void
     * @throws \Exception
     */
    public function creating(Organization $organization)
    {
        $organization->setToken();
    }

    /**
     * Handle the organization "updated" organization.
     *
     * @param  \App\Orm\Organization  $organization
     * @return void
     */
    public function updated(Organization $organization)
    {
        Log::info('Updated details of an Organization', [
            'id' => $organization->id
        ]);
    }

    /**
     * Handle the organization "deleted" organization.
     *
     * @param  \App\Orm\Organization  $organization
     * @return void
     */
    public function deleted(Organization $organization)
    {
        Log::info('Marked an Organization as deleted', [
            'id' => $organization->id
        ]);
    }

    /**
     * Handle the organization "restored" organization.
     *
     * @param  \App\Orm\Organization  $organization
     * @return void
     */
    public function restored(Organization $organization)
    {
        //
    }

    /**
     * Handle the organization "force deleted" organization.
     *
     * @param  \App\Orm\Organization  $organization
     * @return void
     */
    public function forceDeleted(Organization $organization)
    {
        //
    }
}
