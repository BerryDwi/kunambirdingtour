<?php

namespace App\Http\Requests\Admin;

use App\Models\CustomTour;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CustomTourRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->is_admin === true;
    }

    /**
     * Normalize the slug, status and checkbox values.
     */
    protected function prepareForValidation(): void
    {
        $slug = $this->input('slug') ?: $this->input('title');

        $this->merge([
            'slug' => Str::slug((string) $slug),
            'status' => $this->input('status') ?: 'open',
            'is_published' => $this->boolean('is_published'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $customTour = $this->route('custom_tour');
        $customTourId = $customTour instanceof CustomTour ? $customTour->id : null;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('custom_tours', 'slug')->ignore($customTourId)],
            'destination' => ['nullable', 'string', 'max:255'],
            'date_label' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', 'max:50'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['boolean'],
        ];
    }
}
