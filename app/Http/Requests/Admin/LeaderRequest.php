<?php

namespace App\Http\Requests\Admin;

use App\Models\Leader;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class LeaderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->is_admin === true;
    }

    /**
     * Normalize the slug and checkbox values.
     */
    protected function prepareForValidation(): void
    {
        $slug = $this->input('slug') ?: $this->input('name');

        $this->merge([
            'slug' => Str::slug((string) $slug),
            'badge_style' => $this->input('badge_style') ?: 'success',
            'is_published' => $this->boolean('is_published'),
            'remove_image' => $this->boolean('remove_image'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $leader = $this->route('leader');
        $leaderId = $leader instanceof Leader ? $leader->id : null;

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('leaders', 'slug')->ignore($leaderId)],
            'region' => ['nullable', 'string', 'max:255'],
            'badge_style' => ['required', Rule::in(['success', 'info', 'warning'])],
            'bio' => ['nullable', 'string'],
            'photo' => ['nullable', 'string', 'max:2048'],
            'photo_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'email' => ['nullable', 'email', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['boolean'],
            'remove_image' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'photo_file' => 'photo',
        ];
    }
}
