@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light"><a href="{{route('attribute-categories.index')}}">گروه ویژگی ها</a> /</span> جدید
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{route('attribute-categories.store')}}" method="post" enctype="multipart/form-data" class="row align-items-end" id="mainForm">
                @csrf
                <div class="col-lg-3 mb-4">
                    <label class="form-label" for="name">نام گروه</label>
                    <input id="name" type="text" name="name" class="form-control" value="{{old('name')}}">
                </div>



                {{-- attributes --}}
                <div class="mb-3">
                    <label class="form-label" for="attributes_select">ویژگی ها (ضروری)</label>
                    <select class="select2 form-select" id="attributes_select" name="attribute_list[]" data-allow-clear="true"
                            multiple required>
                        @foreach(\Modules\Products\Entities\Attribute::all() as $attribute)
                            <?php $val = $attribute->id . '-' . $attribute->frontend_type . '-' . $attribute->required . '-' . $attribute->label;?>

                            <option value="{{$val}}" @if(old('attributes'))
                                {{ in_array($attribute->id,old('attributes')) ? 'selected' : '' }}
                                @endif>{{$attribute->label}}</option>
                        @endforeach
                    </select>
                </div>

                <div id="attributesContainer"></div>


                <div class="mt-3">
                    <button type="submit" class="btn btn-success submit-button">افزودن گروه</button>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        let attributesSelect = $('#attributes_select');

        // total attr unselect
        attributesSelect.on('select2:unselect', function(e) {
            let values = e.params.data.id.split('-');
            let id = '#attr_' + values[1] + '_container';
            $(id).remove();
        })

        // total attributes select
        attributesSelect.on('select2:select', function(e) {
            let label = e.params.data.text;
            let values = e.params.data.id.split('-');
            let name = values[0];
            let frontendType = values[1];
            let requiredAttr = '';
            let requiredName = values[2] === '1' ? '1' : '0';
            if (values[2] === '1') requiredAttr = 'required';
            let el = generateTotalAttributeField(label,frontendType,name,requiredName,requiredAttr);
            $('#attributesContainer').append(el);
        });

        function generateTotalAttributeField(label,frontendType,name,requiredName,requiredAttr){
            let el = '';
            if (frontendType === 'text' || frontendType === 'number'){
                el = "<div class='mb-3' id='attr_"+name+"_container'>" +
                    "<label class='form-label' for='attr_"+name+"'>"+ label +"</label>" +
                    "<input type='"+frontendType+"' class='form-control' id='attr_"+name+"' " +
                    "name='attr_"+name+"' "+requiredAttr+">" +
                    "</div>";
            }else if(frontendType === 'textarea'){
                el = "<div class='mb-3' id='attr_"+name+"_container'>" +
                    "<label class='form-label' for='attr_"+name+"'>"+ label +"</label>" +
                    "<textarea class='form-control' rows='2' id='attr_"+name+"' " +
                    "name='attr_"+name+"' "+requiredAttr+"></textarea>";
            }
            return el;
        }


    </script>
@endsection
