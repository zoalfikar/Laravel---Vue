<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SurveyResource extends JsonResource
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
            'title' =>$this->title ,
            'id' =>$this->id ,
            'status' =>$this->status !== 'draft' ,
            'description' =>$this->description ,
            'expire_data' =>$this->expire_data ,
            'slug' =>$this->slug ,
            'created_at' =>$this->created_at ,
            'updated_at' =>$this->updated_at ,
            'expire_date' =>$this->expire_date ,
            'questions' => []
        ];
    }
}
