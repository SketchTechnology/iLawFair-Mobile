<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'author_id' => $this->author_id,
            'author' => $this->author->name,
            'category_id' => $this->category_id,
            'category' => $this->category->name,
            'price' => $this->price,
            'image' => $this->image,
            'sale_price' => $this->sale_price,
            'published_year' => $this->published_year,
            'publishing_house_id' => $this->publishing_house_id,
            'publishing_house' => $this->publishingHouse->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
         ];
    }
}
