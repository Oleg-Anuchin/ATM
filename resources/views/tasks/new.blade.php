<!DOCTYPE html>
<html>
<head>
    @include('head')
    @include('css')

    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('#datetimepicker1').datetimepicker();
            $('#datetimepicker2').datetimepicker();
        });
    </script>

</head>

<body>

<div id="wrapper">

    @include('nav')

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    @if ($isEditMode)
                        <h1 class="page-header">Редактирование задачи: {{ $task->title }}</h1>
                    @elseif ($isNewMode)
                        <h1 class="page-header">Создание новой задачи</h1>
                    @elseif ($isShowMode)
                        <h1 class="page-header">Просмотр задачи</h1>
                    @else
                    @endif


                </div>
            </div>
            <!-- /.row -->

            <!-- /.row -->

            <div class="row" style="margin-top: 20px">
                <div class="col-lg-6">
                    <div class="form-group">
                        @if($isEditMode)
                            {!! Form::model($task, ['route' => ['tasks.update', $task->id], 'method' => 'patch',
                            'autocomplete' => 'off', 'files' => 'true']) !!}
                        @else
                            {!! Form::open(['route' => 'tasks.store', 'autocomplete' => 'off', 'files' => 'true']) !!}
                        @endif


                        <div class="form-group">
                            @if($isEditMode || $isNewMode)
                                {!! Form::bsText('Наименование:', 'title', old('title')) !!}
                            @elseif($isShowMode)
                                {!! Form::label('title', 'Наименование: ' .$task->title,['class'=>'control-label']) !!}
                            @endif
                        </div>

                        <div class="form-group">
                            @if($isEditMode || $isNewMode)
                                {!! Form::label('author', 'Автор: ' .Auth::user()->name, ['class'=>'control-label']) !!}
                            @elseif($isShowMode)
                                {!! Form::label('author', 'Автор: ' .$task->author,['class'=>'control-label']) !!}
                            @endif
                        </div>

                        <div class="form-group">

                        </div>

                        <div class="form-group">
                            @if($isEditMode || $isNewMode)
                                {!! Form::label('responsible', 'Ответственный:',['class'=>'control-label']) !!}
                                {!! Form::select('responsible', $responsibles, isset($task) ? $task->getResponsibleId() :
                                '', array('class' => 'form-control', '')) !!}
                            @elseif($isShowMode)
                                {!! Form::label('title', 'Ответственный: ' .$task->getResponsibleName(),
                                ['class'=>'control-label']) !!}
                            @endif
                        </div>

                        <div class="form-group">
                            @if($isEditMode || $isNewMode)
                                {!! Form::label('deadline', 'Крайний срок:',['class'=>'control-label']) !!}
                                {!! Form::text('deadline', old('regDate'), array('id' => 'deadline')) !!}
                            @elseif($isShowMode)
                                {!! Form::label('deadline', 'Крайний срок: ' .$task->getDeadline(), ['class'=>'control-label']) !!}
                            @endif
                        </div>

                        <div class="form-group">
                            @if($isNewMode)
                                {!! Form::file('file'); !!}
                            @elseif($isEditMode)
                                {!! Form::file('file'); !!}
                                <a href="#">Документ.doc</a>
                            @elseif($isShowMode)
                                <a href="#">Документ.doc</a>
                            @endif
                        </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <h6>datetimepicker1</h6>

                                    <div class="form-group">
                                        <div class="input-group date" id="datetimepicker1">
                                            <input type="text" class="form-control" />	<span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
                                        </div>
                                    </div>
                                    <h6>datetimepicker2</h6>

                                    <input type="text" class="form-control" id="datetimepicker2" />
                                </div>
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
