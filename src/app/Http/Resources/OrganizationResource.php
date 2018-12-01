<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
{

    protected function getMembers(): array
    {

        $members = [];
        foreach ($this->users as $user) {
            $members[] = ['name' => $user->name];
        }
        return $members;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'is_public' => $this->is_public,
            'is_member' => $this->when($request->user(), $this->isMember($request->user())),
            'members' => $this->getMembers()
        ];
    }
}
