<?php

namespace App\Http\Requests\Admin;

use App\Enums\SitePage;
use App\Models\HeroSlide;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class HeroSlideRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->is_admin === true;
    }

    /**
     * Normalize the checkbox values.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
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
        return [
            'page' => ['required', Rule::in(SitePage::values())],
            'image' => ['nullable', 'string', 'max:2048'],
            'image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'alt' => ['nullable', 'string', 'max:255'],
            'title' => ['nullable', 'string', 'max:255'],
            'text' => ['nullable', 'string', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
            'remove_image' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * Ensure an image is present when creating, or when the current one is removed.
     *
     * @return array<int, callable>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $slide = $this->route('hero_slide');
                $hasExistingImage = $slide instanceof HeroSlide && filled($slide->image);

                if ($this->hasFile('image_file') || filled($this->input('image'))) {
                    return;
                }

                if ($hasExistingImage && ! $this->boolean('remove_image')) {
                    return;
                }

                $validator->errors()->add('image_file', 'Please upload an image or provide an image URL.');
            },
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
            'image_file' => 'image',
        ];
    }
}
