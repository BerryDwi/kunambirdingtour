<?php

namespace App\Http\Requests\Admin;

use App\Models\Setting;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->is_admin === true;
    }

    /**
     * Normalize the setting key.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'key' => trim((string) $this->input('key')),
            'group' => trim((string) $this->input('group')),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $setting = $this->route('setting');
        $settingId = $setting instanceof Setting ? $setting->id : null;

        return [
            'key' => ['required', 'string', 'alpha_dash', 'max:100', Rule::unique('settings', 'key')->ignore($settingId)],
            'value' => ['nullable', 'string'],
            'type' => ['required', Rule::in(['string', 'text', 'boolean', 'number'])],
            'group' => ['required', 'string', 'max:50'],
        ];
    }
}
