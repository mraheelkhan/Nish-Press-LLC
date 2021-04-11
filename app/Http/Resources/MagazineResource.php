<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MagazineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image_cover' => asset("storage/$this->cover_image/$this->cover_image"),
            'url' => route('front.magazine.show', [$this->id, $this->title])
        ];
    }
}
