@extends('admin.layouts.panel')
@section('content')
    <div class="d-flex align-items-center justify-content-between py-3 mb-4">
        <h4 class="m-0 breadcrumb-wrapper">
            <span class="text-muted fw-light"><a href="{{route('attribute-categories.index')}}">گروه ویژگی ها</a> /</span> ویرایش
        </h4>
        <div>
            <a href="{{route('attribute-categories.create')}}" class="btn btn-primary"><span><i class="bx bx-plus me-sm-2"></i> <span class="d-none d-sm-inline-block">افزودن گروه جدید</span></span></a>
        </div>
    </div>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <div class="card">
        <div class="card-body">
            <form action="{{route('attribute-categories.update',$attributeCategory)}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
                @csrf
                @method('PATCH')

                <div class="col-lg-3 mb-4">
                    <label class="form-label" for="name">نام گروه</label>
                    <input id="name" type="text" name="name" class="form-control" value="{{old('name',$attributeCategory->name)}}">
                </div>

                {{-- attributes --}}
                <div class="mb-3">
                    <label class="form-label" for="attributes_select">ویژگی ها (ضروری)</label>
                    <select class="select2 form-select" id="attributes_select" name="attribute_list[]" data-allow-clear="true"
                            multiple required>
                        @foreach(\Modules\Products\Entities\Attribute::all() as $attribute)
                                <?php $val = $attribute->id . '-' . $attribute->frontend_type . '-' . $attribute->required . '-' . $attribute->label;?>
                                <option value="{{$val}}" {{ in_array($attribute->id,$attributeCategory->attributesList->pluck('id')->toArray()) ? 'selected' : '' }}>{{$attribute->label}}</option>
                        @endforeach
                    </select>
                </div>

                <div id="attributesContainer">
                    @if(old('attribute_list'))
                        @foreach(old('attribute_list') as $attr)
                            <?php
                            $arr = explode('-', $attr);
                            $code = $arr[0];
                            $frontendType = $arr[1];
                            $required = $arr[2] === 1;
                            $requiredVal = $arr[2];
                            $label = $arr[3];
                            $fieldName = 'total_attr_' . $code . '_' . $frontendType . '_' . $requiredVal . '_' . $label;?>
                            @if($frontendType == 'text' || $frontendType == 'number')
                                <div class="mb-3" id="{{'attr_'.$code.'_container'}}">
                                    <label class="form-label"
                                           for="{{'attr_' . $code}}">{{$label}}</label>
                                    <input type="{{$frontendType}}" class="form-control"
                                           id="{{'attr_' . $code}}"
                                           name="{{$fieldName}}"
                                           value="{{old($fieldName)}}" {{$required ? 'required' : ''}}>
                                </div>

                            @elseif($frontendType == 'textarea')
                                <div class="mb-3" id="{{'attr_'.$code.'_container'}}">
                                    <label class="form-label"
                                           for="{{'attr_' . $code}}">{{$label}}</label>
                                    <textarea class="form-control" id="{{'attr_' . $code}}"
                                              name="{{$fieldName}}" {{$required ? 'required' : ''}}>{{old($fieldName)}}</textarea>
                                </div>
                            @endif
                        @endforeach
                    @else
                        @foreach($attributeCategory->attributesList()->withPivot('default')->get() as $attr)

                            <?php $fieldName = 'attr_' . $attr['id'];?>

                            @if($attr['frontend_type'] == 'text' || $attr['frontend_type'] == 'number')
                                <div class="mb-3" id="{{'attr_'.$attr['code'].'_container'}}">
                                    <label class="form-label"
                                           for="{{'attr_' . $attr['code']}}">{{$attr['label']}}</label>
                                    <input type="{{$attr['frontend_type']}}" class="form-control"
                                           id="{{'attr_' . $attr['code']}}" name="{{$fieldName}}"
                                           value="{{old($fieldName,$attr->pivot->default)}}" {{$attr['required'] ? 'required' : ''}}>
                                </div>

                            @elseif($attr['frontend_type'] == 'textarea')
                                <div class="mb-3" id="{{'attr_'.$attr['code'].'_container'}}">
                                    <label class="form-label"
                                           for="{{'attr_' . $attr['code']}}">{{$attr['label']}}</label>
                                    <textarea class="form-control" id="{{'attr_' . $attr['code']}}"
                                              name="{{$fieldName}}" {{$attr['required'] ? 'required' : ''}}>{{old($fieldName,$attr->pivot->default)}}</textarea>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>


                <div class="mt-3">
                    <button type="submit" class="btn btn-success submit-button">ذخیره تغییرات</button>
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
