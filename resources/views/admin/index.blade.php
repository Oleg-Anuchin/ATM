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
                        Администрирование
                    </h1>
                </div>
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-12">
                    <p>
                        <a href="{{ route('admin.user.new') }}" class="btn btn-primary btn-lg">
                            Создать пользователя
                        </a>
                    </p>

                    <table class="table table-striped table-hover sortable">
                        <thead>
                        <tr>
                            <th>Пользователь</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr class="clickable-row" data-href="{{ route('admin.user.edit', $user->id) }}">
                                <td>{{ $user->name }}</td>

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
