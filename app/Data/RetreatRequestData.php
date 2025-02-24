<?php

namespace App\Data;

class RetreatRequestData
{

    public ?int $retreat_service_category_id = null;
    public ?string $start_time = null;
    public ?string $end_time = null;
    public ?int $user_id = null;
    public ?string $document_number = null;
    public ?string $birthday = null;
    public ?string $phone = null;
    public ?string $qr_code = null;
    public ?string $status = null;
    public ?string $retreat_mosque_id = null;
    public ?string $retreat_mosque_location_id = null;
    public ?string $name = null;
    public ?int $retreat_season_id = null;
    public static function fromArray(array $data): self
    {
        $instance = new self();
        $instance->name = $data['name'] ?? null;
        $instance->retreat_mosque_id = $data['retreat_mosque_id'] ?? null;
        $instance->retreat_mosque_location_id = $data['retreat_mosque_location_id'] ?? null;
        $instance->retreat_service_category_id = $data['retreat_service_category_id'] ?? null;
        $instance->start_time = $data['start_time'] ?? null;
        $instance->end_time = $data['end_time'] ?? null;
        $instance->user_id = $data['user_id'] ?? null;
        $instance->document_number = $data['document_number'] ?? null;
        $instance->birthday = $data['birthday'] ?? null;
        $instance->phone = $data['phone'] ?? null;
        $instance->qr_code = $data['qr_code'] ?? null;
        $instance->status = $data['status'] ?? null;
        $instance->retreat_season_id = $data['retreat_season_id'] ?? null;

        return $instance;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'retreat_mosque_id' => $this->retreat_mosque_id,
            'retreat_mosque_location_id' => $this->retreat_mosque_location_id,
            'retreat_service_category_id' => $this->retreat_service_category_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'user_id' => $this->user_id,
            'document_number' => $this->document_number,
            'birthday' => $this->birthday,
            'phone' => $this->phone,
            'qr_code' => $this->qr_code,
            'status' => $this->status,
            'retreat_season_id' => $this->retreat_season_id,
        ];
    }
}
