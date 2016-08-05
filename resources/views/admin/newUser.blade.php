<!DOCTYPE html>
<html>
<head>
    @include('head')
    @include('css')
</head>

<body>

<div id="wrapper">

    @include('nav')

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    @if($isEditMode)
                        <h1 class="page-header">Редактирование пользователя: {{ $user->name }}</h1>
                    @else
                        <h1 class="page-header">Создание нового пользователя</h1>
                    @endif


                </div>
            </div>
            <!-- /.row -->

            <!-- /.row -->

            <div class="row" style="margin-top: 20px">
                <div class="col-lg-6">
                    <div class="form-group">
                        @if($isEditMode)
                            {!! Form::model($user, ['route' => ['admin.user.update', $user->id], 'method' => 'patch', 'autocomplete' => 'off']) !!}
                        @else
                            {!! Form::open(['route' => 'admin.user.store', 'autocomplete' => 'off']) !!}
                        @endif

                        <div class="form-group">
                            {!! Form::bsText('Имя пользователя:', 'name', old('name')) !!}
                        </div>


                        <div class="form-group">
                            {!! Form::label('head', 'Руководитель:',['class'=>'control-label']) !!}
                            {!! Form::select('head', $heads, isset($user) ? $user->getCurrentHeadId() : '', array('class' => 'form-control', '')) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::bsText('Электронная почта:', 'email', old('email')) !!}
                        </div>

                        <!-- The text and password here are to prevent FF from auto filling my login credentials because it ignores autocomplete="off"-->
                        <input type="text" style="display:none">
                        <input type="password" style="display:none">

                        <div class="form-group">
                            {!! Form::bsPassword('Пароль:', 'password', null) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('role', 'Роль:',['class'=>'control-label']) !!}
                            {!! Form::select('role', $roles, isset($user) ? $user->getCurrentRoleId() : '', array('class' => 'form-control', '')) !!}
                        </div>

                        {!! Form::submit('Сохранить', ['class' => 'btn btn-primary']) !!}
                        <a href="{{ route('admin.user.index') }}" class="btn btn-default form-inline">Назад</a>

                        {!! Form::close() !!}


                    </div>

                </div>
            </div>


        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>

</body>
</html>
