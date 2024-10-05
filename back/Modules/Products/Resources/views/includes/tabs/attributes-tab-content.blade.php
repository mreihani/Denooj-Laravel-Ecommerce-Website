<div class="tab-pane fade" id="nav-attributes" role="tabpanel" aria-labelledby="nav-attributes-tab">
    @foreach($product->total_attributes as $attr)
        <div class="special-attribute-list-item">
            <span>{{$attr['label']}}</span>
            <span>{{$attr['value']}}</span>
        </div>
    @endforeach
</div>
