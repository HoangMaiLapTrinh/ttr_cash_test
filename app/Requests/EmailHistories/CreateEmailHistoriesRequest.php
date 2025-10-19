<?php

namespace App\Requests\EmailHistories;

class CreateEmailHistoriesRequest
{
    public static function rules(): array
    {
        return [
            'code'      => 'required|max_length[100]',
            'recipient' => 'required|max_length[255]',
            'cc'       => 'permit_empty|max_length[255]',
            'bcc'      => 'permit_empty|max_length[255]',
            'subject'  => 'required|max_length[255]',
            'body'     => 'required',
            'error_message' => 'permit_empty',
            'status'   => 'required|in_list[0,1]',
            'sent_at' => 'permit_empty|valid_date[Y-m-d H:i:s]',
            'resent_times' => 'required|integer|max_length[10]',
            'deleted_at' => 'permit_empty|valid_date',
            'updated_at' => 'permit_empty|valid_date',
            'created_at' => 'permit_empty|valid_date',
        ];
    }

    public static function messages(): array
    {
        return [
            'code'      => [
                'required'    => 'The code field is required.',
                'max_length'  => 'The code field must not exceed 100 characters in length.',
            ],
            'recipient' => [
                'required'    => 'The recipient field is required.',
                'max_length'  => 'The recipient field must not exceed 255 characters in length.',
            ],
            'cc'       => [
                'max_length'  => 'The cc field must not exceed 255 characters in length.',
            ],
            'bcc'      => [
                'max_length'  => 'The bcc field must not exceed 255 characters in length.',
            ],
            'subject'  => [
                'required'    => 'The subject field is required.',
                'max_length'  => 'The subject field must not exceed 255 characters in length.',
            ],
            'body'     => [
                'required'    => 'The body field is required.',
            ],
            'error_message' => [
                'permit_empty' => 'The error_message field can be empty.',
            ],
            'status'   => [
                'required'    => 'The status field is required.',
                'in_list'     => 'The status field must be either 0 or 1.',
            ],
            'sent_at'  => [
                'valid_date' => 'The sent_at field must be a valid datetime format.',
            ],
            'resent_times' => [
                'required'    => 'The resent_times field is required.',
                'integer'     => 'The resent_times field must be an integer.',
                'max_length'  => 'The resent_times field must not exceed 10 characters in length.',
            ],
            'deleted_at' => [
                'valid_date' => 'The deleted_at field must be a valid datetime format.',
            ],
            'updated_at' => [
                'valid_date' => 'The updated_at field must be a valid datetime format.',
            ],
            'created_at' => [
                'valid_date' => 'The created_at field must be a valid datetime format.',
            ],
        ];
    }
}
