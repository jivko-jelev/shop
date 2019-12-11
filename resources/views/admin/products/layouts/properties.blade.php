<div class="row">
    @foreach($properties as $key => $property)
        <div class="col-md-3">
            <h3>{{ $property->name }}</h3>
            @foreach($property->subProperties as $subPropertyKey => $subProperty)
                <div class="w-100">
                    <input type="checkbox" id="minimal-checkbox-{{ $subProperty->id }}" class="icheckbox_minimal-blue"
                           name="sub_properties[{{ $key }}]" value="{{ $subProperty->id }}"
                            {{ isset($product) && count($product->subproperties->where('subproperty_id', $subProperty->id))>0 ? ' checked' : '' }} >
                    <label for="minimal-checkbox-{{ $subProperty->id }}">&nbsp;{{ $subProperty->name }}</label>
                </div>
            @endforeach
        </div>
    @endforeach
</div>

@if(!isset($product))
    <script>
        $('input[type="checkbox"]').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue',
            }
        );
    </script>
@endif