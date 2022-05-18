<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use DateTimeInterface;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'username' => $this->username,
            'created_at' => $this->serializeDate($this->created_at),
            'updated_at' => $this->serializeDate($this->updated_at),
            'statistics' => $this->whenLoaded('statistics'),
            'games' => $this->whenLoaded("games")->duplicatesStrict()->makeHidden("pivot"),
        ];
    }

    /**
     * Prepare a date for array / JSON serialization.
     * 
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
