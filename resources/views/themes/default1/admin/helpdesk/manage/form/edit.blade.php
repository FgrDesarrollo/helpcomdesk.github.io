@extends('themes.default1.admin.layout.admin')

@section('Manage')
class="nav-link active"
@stop

@section('manage-menu-parent')
class="nav-item menu-open"
@stop

@section('manage-menu-open')
class="nav nav-treeview menu-open"
@stop

@section('forms')
class="nav-link active"
@stop

@section('HeadInclude')
@stop
<!-- header -->
@section('PageHeader')
<h1>{!! Lang::get('lang.forms') !!}</h1>
@stop
<!-- /header -->
<!-- breadcrumbs -->
@section('breadcrumbs')
<ol class="breadcrumb">
</ol>
@stop
<!-- /breadcrumbs -->
<!-- content -->
@section('content')
@if (count($errors) > 0)
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if(Session::has('success'))
<div class="alert alert-success alert-dismissable">
    <i class="fa fa-check-circle"></i>
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('success')}}
</div>
@endif
@if(Session::has('fails'))
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('fails')}}
</div>
@endif
@if(Session::has('warn'))
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    {{Session::get('warn')}}
</div>
@endif
<div class="card card-light">

    <div class="card-header">
        <h3 class="card-title">{!! Lang::get('lang.edit') !!}</h3>
    </div>

    <div class="card-body">
        
        {!! Form::model($form,['route'=>['forms.update',$form->id],'method'=>'PATCH']) !!}
        
        <div class="row">

            <div class="form-group col-sm-6">

                <label>{!! Lang::get('lang.form_name') !!}: <span class="text-red"> *</span></label>
                 {!! Form::text('formname',null,['class'=>'form-control']) !!}
            </div>
        </div>
        
        <div class="callout callout-default" style="font-style: oblique;">{!! Lang::get('lang.instructions_on_creating_form') !!}.</div>
        <div class="callout callout-default"> {!! Lang::get('lang.click_add_fields_button_to_add_fields') !!} </div>

        <div class="card card-light">
            
            <div class="card-header">
            
                <h3 class="card-title">{!! Lang::get('lang.adding_fields') !!}</h3> 

                <div class="card-tools"> 
                    <button type="button" class="btn btn-default btn-tool addField" value="Show Div" onclick="showDiv()" >
                        <i class="fas fa-plus"></i>&nbsp;{!! Lang::get('lang.add_fields') !!}
                    </button>
                </div>    
            </div> 
     
            <div class="card-body" id="welcomeDiv">
                <table id="example2" class="table table-bordered table-striped">
                    <thead>
                    <th>{!! Lang::get('lang.label') !!} </th>
                    <th>{!! Lang::get('lang.name') !!} </th>
                    <th>{!! Lang::get('lang.type') !!} </th>
                    <th>{!! Lang::get('lang.values(selected_fields)') !!} </th>
                    <th>{!! Lang::get('lang.required') !!} </th>
                    <th>{!! Lang::get('lang.action') !!} </th>
                    </thead>
                    <tbody class="inputField">

                        @forelse($fields as $key=>$field)

                        <tr>
                            <td><input type="text" name="label[]" value="{{$field->label}}" class="form-control"></td>
                            <td><input type="text" name="name[]" value="{{$field->name}}" class="form-control"></td>
                            
                            <td>{!! Form::select('type[]',['text'=>'text','email'=>'email','password'=>'password','textarea'=>'textarea','select'=>'select','radio'=>'radio','checkbox'=>'checkbox','hidden'=>'hidden'],$field->type,['class'=>'form-control']) !!}</td>
                            <td><input type="text" name="value[]" value="{{$field->valuesAsString()}}" class="form-control"></td>
                            
                            <td>{!! Form::radio('required['.$key.']',1,true) !!}&nbsp;&nbsp;{!! Lang::get("lang.yes") !!}&nbsp;&nbsp;{!! Form::radio('required['.$key.']',0,$field->nonRequiredFieldForCheck()) !!}&nbsp;&nbsp;{!! Lang::get("lang.no") !!}</td>
                            <td><button type="button" class="remove_field btn btn-danger"><i class="fas fa-trash"></i></button></td>
                        </tr> 
                        @empty 

                        @endforelse

                    </tbody>
                </table>
            </div> 
        </div> 
    </div>
    <div class="card-footer">
        <input type="submit" class="btn btn-primary" value="{!! Lang::get('lang.save_form') !!}">
    </div>
</div>
{!! Form::close() !!}
<script>
    function showDiv() {
        document.getElementById('welcomeDiv').style.display = "block";
    }
    $(document).ready(function () {
        var max_fields = 10;
        var wrapper = $(".inputField");
        var add_button = $(".addField");
        var x = 1;
        $(add_button).click(function (e)
        {
            e.preventDefault();
            if (x < max_fields) {
                x++;
                $(wrapper).append('<tr>\n\
    <td><input type="text" class="form-control" name="label[]"></td>\n\
    <td><input type="text" class="form-control" name="name[]"></td>\n\
    <td><select name="type[]" class="form-control"><option>text</option><option>email</option><option>password</option><option>textarea</option><option>select</option><option>radio</option><option>checkbox</option><option>hidden</option></select>\n\
    </td><td><input type="text" name="value[]" class="form-control"></td>\n\
    <td><input type=radio name="required[]" value=1 checked>&nbsp;&nbsp;{!! Lang::get("lang.yes") !!}&nbsp;&nbsp;<input type=radio name="required[]" value=0>&nbsp;&nbsp;{!! Lang::get("lang.no") !!}</td>\n\
    <td><button type="button" class="remove_field btn btn-danger"><i class="fas fa-trash"></i></button></td></tr>');
            }
        });
        $(wrapper).on("click", ".remove_field", function (e)
        {
            e.preventDefault();
            $(this).closest('tr').remove();
            x--;
        });
    });
</script>
@stop

