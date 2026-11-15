<?php

namespace App\Http\Requests\Admin;

use App\Models\TourReport;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TourReportRequest extends FormRequest
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
        $slug = $this->input('slug') ?: $this->input('title');

        $this->merge([
            'slug' => Str::slug((string) $slug),
            'kind' => $this->input('kind') ?: 'category',
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
        $report = $this->route('tour_report');
        $reportId = $report instanceof TourReport ? $report->id : null;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('tour_reports', 'slug')->ignore($reportId)],
            'region' => ['nullable', 'string', 'max:255'],
            'kind' => ['required', Rule::in(['category', 'latest'])],
            'summary' => ['nullable', 'string', 'max:500'],
            'cover_image' => ['nullable', 'string', 'max:2048'],
            'cover_image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'report_url' => ['nullable', 'url', 'max:2048'],
            'published_at' => ['nullable', 'date'],
            'is_featured' => ['boolean'],
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
            'cover_image_file' => 'cover image',
        ];
    }
}
