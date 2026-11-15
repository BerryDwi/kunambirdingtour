<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Normalise the submitted currency before validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->filled('currency')) {
            $this->merge([
                'currency' => strtolower((string) $this->input('currency')),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tour_type' => ['required', 'string', 'in:scheduled,custom'],
            'tour_name' => ['required', 'string', 'max:255'],
            'tour_year' => ['nullable', 'string', 'max:50'],
            'currency' => ['required', 'string', 'in:gbp,usd'],
            'room_preference' => ['required', 'string', 'in:twin_share,single_supplement'],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'country' => ['required', 'string', 'max:100'],
            'participants_count' => ['required', 'integer', 'min:1', 'max:20'],
            'birding_experience' => ['nullable', 'string', 'max:100'],
            'dietary_medical' => ['nullable', 'string', 'max:1000'],
            'special_notes' => ['nullable', 'string', 'max:2000'],
            'terms_accepted' => ['required', 'accepted'],
            'website' => ['prohibited'],
        ];
    }
}
