<div class="card border-0 shadow-sm rounded-3 p-3 mb-3" style="background-color: #fafcf9; border: 1px solid #e2ece0 !important;">
    <div class="row align-items-center g-3">
        <div class="col-md-2 col-4">
            <img src="{{ $tour->imageUrl() }}" alt="{{ $tour->name }}" class="img-fluid rounded" style="height: 80px; width: 100%; object-fit: cover;" loading="lazy">
        </div>
        <div class="col-md-7 col-8">
            <h5 class="fw-bold mb-1" style="font-size: 17px;"><a href="{{ $tour->external_url }}" target="_blank" rel="noopener" class="text-dark text-decoration-none">{{ $tour->name }}</a></h5>
            <p class="text-muted small mb-1">{{ $tour->summary }}</p>
            <div class="text-success small fw-semibold">{{ $tour->date_label }}</div>
        </div>
        <div class="col-md-3 text-md-end">
            <span class="bta-badge-status {{ $tour->statusBadgeClass() }}">{{ $tour->statusLabel() }}</span>
        </div>
    </div>
</div>
