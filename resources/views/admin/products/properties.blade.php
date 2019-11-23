<div class="row">
    @foreach($properties as $key => $property)
        <div class="col-md-3">
            <h3>{{ $property->name }}</h3>
            @foreach($property->subProperties as $subPropertyKey => $subProperty)
                <div class="w-100">
                    <input type="checkbox" id="minimal-checkbox-{{ $subPropertyKey }}" class="icheckbox_minimal-blue">
                    <label for="minimal-checkbox-{{ $subPropertyKey }}">&nbsp;{{ $subProperty->name }}</label>
                </div>
            @endforeach
        </div>
    @endforeach
</div>

<script>
    $('input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    })
</script>