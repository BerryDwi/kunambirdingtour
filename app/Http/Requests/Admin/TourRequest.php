<?php

namespace App\Http\Requests\Admin;

use App\Enums\TourStatus;
use App\Models\Tour;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TourRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->is_admin === true;
    }

    /**
     * Normalize slugs and checkbox values.
     */
    protected function prepareForValidation(): void
    {
        $slug = $this->input('slug') ?: $this->input('name');

        $this->merge([
            'slug' => Str::slug((string) $slug),
            'is_featured' => $this->boolean('is_featured'),
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
        $tour = $this->route('tour');
        $tourId = $tour instanceof Tour ? $tour->id : null;

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('tours', 'slug')->ignore($tourId)],
            'year' => ['required', 'integer', 'min:2000', 'max:2100'],
            'country' => ['nullable', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'itinerary' => ['nullable', 'string'],
            'duration_days' => ['nullable', 'integer', 'min:1', 'max:365'],
            'date_label' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'price_gbp' => ['nullable', 'numeric', 'min:0'],
            'price_usd' => ['nullable', 'numeric', 'min:0'],
            'single_supplement_gbp' => ['nullable', 'numeric', 'min:0'],
            'single_supplement_usd' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', Rule::enum(TourStatus::class)],
            'status_label' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'string', 'max:2048'],
            'image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_image' => ['sometimes', 'boolean'],
            'external_url' => ['nullable', 'url', 'max:2048'],
            'is_featured' => ['boolean'],
            'is_published' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
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
            'price_gbp' => 'price (GBP)',
            'price_usd' => 'price (USD)',
            'single_supplement_gbp' => 'single supplement (GBP)',
            'single_supplement_usd' => 'single supplement (USD)',
            'image_file' => 'image',
        ];
    }
}
