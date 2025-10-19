<?php

namespace App\Requests\SystemSetting;

class CreateSystemSettingRequest
{
    public static function rules(): array
    {
        return [
            'name'        => 'required|max_length[255]',
            'description' => 'permit_empty|max_length[500]',
            'status'      => 'required|in_list[0,1]',
        ];
    }

    public static function messages(): array
    {
        return [
            'name.required'       => 'Name is required.',
            'name.max_length'     => 'Name cannot exceed 255 characters.',

            'description.max_length' => 'Description cannot exceed 500 characters.',

            'role_type.max_length'   => 'Role type cannot exceed 100 characters.',

            'status.required'     => 'Status is required.',
            'status.in_list'      => 'Status must be either 0 (inactive) or 1 (active).',
        ];
    }
}
