<?php

namespace Amethyst\Observers;

use Amethyst\Managers\PermissionManager;
use Amethyst\Models\Ownable;
use Amethyst\Models\Permission;

class OwnablePermissionObserver
{
    /**
     * Handle the Ownable "created" event.
     *
     * @param \Amethyst\Models\Ownable $ownable
     */
    public function created(Ownable $ownable)
    {
        app(PermissionManager::class)->createOrFail($this->getParameters($ownable));
    }

    /**
     * Handle the Ownable "deleted" event.
     *
     * @param \Amethyst\Models\Ownable $ownable
     */
    public function deleted(Ownable $ownable)
    {
        Permission::where($this->getParameters($ownable))->delete();
    }

    public function getParameters(Ownable $ownable)
    {
        return [
            'data'      => $ownable->ownable_type,
            'action'    => '*',
            'attribute' => '*',
            'filter'    => "id = '{$ownable->ownable_id}'",
            'agent'     => "{{ agent.id }} == {$ownable->owner_id}",
        ];
    }
}
