<!DOCTYPE html>
<html>
<head>

    @include('head')
    @include('css')

    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('.table > tbody > tr').click(function () {
                window.document.location = $(this).data("href");
            });
        });
    </script>

    <style type="text/css">
        .table-striped > tbody > tr:hover > td {
            background-color: #efefef;
        }

        .sortable tr {
            cursor: pointer;
        }

        .list_line {
            border-left: 1px solid lightblue;
            background-color: #f1f1f1;
            list-style-type: none;
            padding: 10px 20px;
        }

    </style>


</head>

<body>

<div id="wrapper">

    @include('nav')

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Задачи для подчинённых
                    </h1>
                </div>
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-12">
                    <p>
                        <a href="{{ route('tasks.new') }}" class="btn btn-primary">
                            Создать задачу
                        </a>
                    </p>

                    <table class="table table-striped table-hover sortable">
                        <thead>
                        <tr>
                            <th>Наименование</th>
                            <th>Автор</th>
                            <th>Ответственный</th>
                            <th>Контрольый срок</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tasks as $task)
                            <tr class="clickable-row" data-href="{{ route('tasks.show', $task->id) }}">
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->author }}</td>
                                <td>{{ $task->responsible }}</td>
                                <td>{{ $task->deadline }}</td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>


                </div>
            </div>




        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>

</body>
</html>
