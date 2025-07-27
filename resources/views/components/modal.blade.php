<div id="{{ $id }}" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-{{ $size }}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>{{ $slot }}</p>
            </div>
            <div class="modal-footer">
                @foreach ($buttons as $button)
                    <button type="button" class="btn btn-{{ $button['type'] ?? 'primary' }}" data-bs-dismiss="#{{ $id }}" onclick="{{ $button['onclick'] ?? ""}}">{{ $button['text'] ?? '' }}</button>
                @endforeach
            </div>
        </div>
    </div>
</div>