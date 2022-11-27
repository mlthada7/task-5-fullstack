<?php

namespace App\Http\Resources\api\v1;

use App\Http\Resources\api\v1\PostResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'user_id' => $this->user_id,
            'name' => $this->name,
            'posts' => PostResource::collection($this->whenLoaded('posts')),
            // 'created_at' => date_format($this->created_at, "Y/m/d H:i:s"),
            // 'updated_at' => date_format($this->updated_at, "Y/m/d H:i:s"),
        ];
    }
}