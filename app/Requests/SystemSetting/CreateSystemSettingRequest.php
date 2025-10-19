<?php

namespace App\Requests\SystemSetting;

class CreateSystemSettingRequest
{
    public static function rules(): array
    {
        return [
            'meta_key'   => 'required|max_length[255]',
            'meta_value' => 'permit_empty',
            'label'      => 'required|max_length[255]',
            'status'     => 'permit_empty|in_list[0,1]',
        ];
    }

    public static function messages(): array
    {
        return [
            'meta_key.required'   => 'Meta key is required.',
            'meta_key.max_length' => 'Meta key cannot exceed 255 characters.',

            'label.required'      => 'Label is required.',
            'label.max_length'    => 'Label cannot exceed 255 characters.',

            'status.in_list'      => 'Status must be either 0 (inactive) or 1 (active).',
        ];
    }
}
