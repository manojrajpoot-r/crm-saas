

<div id="{{ $wrapperId ?? 'ajaxTable' }}"
    data-url="{{ $url }}">

    <div class="table-content">
        {!! $content !!}
    </div>
</div>

@push('scripts')
<script>
$(document).on('click', '#{{ $wrapperId ?? "ajaxTable" }} .pagination a', function (e) {

    e.preventDefault();

    let wrapper = $('#{{ $wrapperId ?? "ajaxTable" }}');
    let url = $(this).attr('href');

    $.get(url, function (res) {
        wrapper.find('.table-content').html(res);
    });
});
</script>
@endpush
