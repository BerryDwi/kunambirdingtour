@php
    $product = $product ?? null;
    $currencies = $currencies ?? \App\Enums\Currency::cases();
    $inputClass = 'block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 shadow-sm outline-none transition focus:border-brand-green focus:ring-2 focus:ring-brand-green/20';
    $externalImage = filled($product?->image) && \Illuminate\Support\Str::startsWith($product->image, ['http://', 'https://', '//']) ? $product->image : '';
    $price = $product?->price !== null ? number_format($product->price / 100, 2, '.', '') : '';
@endphp

<div class="space-y-6">
    <div class="grid gap-4 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <x-admin.form.field label="Product name" name="name">
                <input id="name" name="name" type="text" value="{{ old('name', $product?->name) }}" required class="{{ $inputClass }}">
            </x-admin.form.field>
        </div>

        <div class="sm:col-span-2">
            <x-admin.form.field label="Slug" name="slug" hint="Leave blank to generate from the product name.">
                <input id="slug" name="slug" type="text" value="{{ old('slug', $product?->slug) }}" class="{{ $inputClass }}">
            </x-admin.form.field>
        </div>

        <x-admin.form.field label="Price" name="price" hint="Enter the price in major units, e.g. 24.99.">
            <input id="price" name="price" type="number" min="0" step="0.01" value="{{ old('price', $price) }}" class="{{ $inputClass }}">
        </x-admin.form.field>

        <x-admin.form.field label="Currency" name="currency">
            <select id="currency" name="currency" class="{{ $inputClass }}">
                @foreach ($currencies as $currency)
                    <option value="{{ $currency->value }}" @selected(old('currency', $product?->currency?->value ?? 'gbp') === $currency->value)>{{ $currency->label() }}</option>
                @endforeach
            </select>
        </x-admin.form.field>

        <div class="sm:col-span-2">
            <x-admin.form.field label="Description" name="description">
                <textarea id="description" name="description" rows="6" class="{{ $inputClass }}">{{ old('description', $product?->description) }}</textarea>
            </x-admin.form.field>
        </div>

        <div class="sm:col-span-2">
            <x-admin.form.field label="Purchase URL" name="purchase_url" hint="Where customers can buy this product.">
                <input id="purchase_url" name="purchase_url" type="url" value="{{ old('purchase_url', $product?->purchase_url) }}" placeholder="https://..." class="{{ $inputClass }}">
            </x-admin.form.field>
        </div>

        <div class="sm:col-span-2">
            <x-admin.form.field label="Image URL" name="image" hint="Paste an external image URL, or upload a file below.">
                <input id="image" name="image" type="text" value="{{ old('image', $externalImage) }}" placeholder="https://..." class="{{ $inputClass }}">
            </x-admin.form.field>
        </div>

        <div class="sm:col-span-2">
            <x-admin.form.field label="Upload image" name="image_file" hint="JPG, PNG or WebP, max 4 MB. Saved to public/uploads/products.">
                <input id="image_file" name="image_file" type="file" accept="image/jpeg,image/png,image/webp" class="block w-full cursor-pointer rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-brand-navy file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white">
            </x-admin.form.field>
        </div>

        @if ($product?->imageUrl())
            <div class="sm:col-span-2">
                <p class="text-sm font-medium text-slate-700">Current image</p>
                <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="mt-2 h-24 w-auto rounded-lg border border-slate-200 object-cover">

                <label class="mt-3 flex items-center gap-2 text-sm text-slate-600">
                    <input type="hidden" name="remove_image" value="0">
                    <input type="checkbox" name="remove_image" value="1" class="size-4 rounded border-slate-300 text-brand-green focus:ring-brand-green/30" @checked(old('remove_image'))>
                    Remove current image
                </label>
            </div>
        @endif

        <div class="flex items-end">
            <label class="flex items-center gap-2 pb-2 text-sm text-slate-700">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" class="size-4 rounded border-slate-300 text-brand-green focus:ring-brand-green/30" @checked(old('is_active', $product?->is_active ?? true))>
                Active
            </label>
        </div>
    </div>
</div>
