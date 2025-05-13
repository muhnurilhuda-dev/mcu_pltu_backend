<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id_user' => $this->id_user,
            'nama_lengkap' => $this->nama_lengkap,
            'email' => $this->email,
            'role' => $this->role,
            'status_aktif' => $this->status_aktif,
            'created_at' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
