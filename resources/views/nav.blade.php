<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">Aspirity Task Manager</a>
    </div>
    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ Auth::user()->name }} <b
                        class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="{{ route('logout') }}"><i class="fa fa-fw fa-power-off"></i> Выход</a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li>
                <a href="{{ route('tasks.my.index') }}"><i class="fa fa-fw fa-dashboard"></i> Мои задачи</a>
            </li>
            <li>
                <a href="{{ route('tasks.formyself.index') }}"><i class="fa fa-fw fa-bar-chart-o"></i> Задачи для подчинённых</a>
            </li>
            @can('useAdmin', \Auth::user())
            <li>
                <a href="{{ route('admin.user.index') }}"><i class="fa fa-fw fa-table"></i> Администрирование</a>
            </li>
            @endcan

        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>