<?php

namespace App\Data;

class UserData
{
    public ?string $name = null;
    public ?string $email = null;
    public ?string $mobile = null;
    public ?string $password = null;
    public ?string $user_type = null;
    public ?string $document_type = null;
    public ?string $document_number = null;
    public ?string $visa_number = null;
    public ?string $birthday = null;
    public ?string $app_user_type = null;
    public ?int $country_id = null;
    public ?bool $is_active = null;
    public ?string $token;

    public static function fromArray(array $data): self
    {
        $instance = new self();
        $instance->name = $data['name'] ?? '';
        $instance->email = $data['email'] ?? '';
        $instance->mobile = $data['mobile'] ?? null;
        $instance->password = $data['password'] ?? null;
        $instance->user_type = $data['user_type'] ?? '';
        $instance->document_type = $data['document_type'] ?? null;
        $instance->document_number = $data['document_number'] ?? null;
        $instance->visa_number = $data['visa_number'] ?? null;
        $instance->birthday = $data['birthday'] ?? null;
        $instance->app_user_type = $data['app_user_type'] ?? null;
        $instance->country_id = $data['country_id'] ?? null;
        $instance->is_active = $data['is_active'] ?? null;
        $instance->token = $data['token'] ?? null;

        return $instance;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'password' => $this->password,
            'user_type' => $this->user_type,
            'document_type' => $this->document_type,
            'document_number' => $this->document_number,
            'visa_number' => $this->visa_number,
            'birthday' => $this->birthday,
            'app_user_type' => $this->app_user_type,
            'country_id' => $this->country_id,
            'is_active' => $this->is_active,
        ];
    }
}
