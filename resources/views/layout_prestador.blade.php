<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>EU RECLAMO</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
       
        
    </style>
    
    

            <!-- jQuery 2.2.3 -->
            <script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
            <!-- Bootstrap 3.3.6 -->
            <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
            <!-- FastClick -->
            <script src="{{ asset('plugins/fastclick/fastclick.js') }}"></script>
            <!-- AdminLTE App -->
            <script src="{{ asset('dist/js/app.min.js') }}"></script>
            <!-- Sparkline -->
            <script src="{{ asset('plugins/sparkline/jquery.sparkline.min.js') }}"></script>
            <!-- jvectormap -->
            <script src="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
            <script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
            <!-- SlimScroll 1.3.0 -->
            <script src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
            <!-- ChartJS 1.0.1 -->
            <script src="{{ asset('plugins/chartjs/Chart.min.js') }}"></script>
                <script src="{{ asset('js/jquery.maskMoney.min.js') }}"></script>
                <script src="{{ asset('/plugins/input-mask/jquery.inputmask.js') }}"></script>
            <script>
        $(function(){
            function esconder(){
                $(".resposta").fadeOut(1000);
            }
            
            setTimeout(esconder, 4000);
        })    
                </script>
</head>

<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">
      
      <!-- Logo -->
    <a href="" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">REC</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>EU RECLAMO</b></span>
    </a>

        <!-- Navigation -->
        <nav class="navbar navbar-static-top" >
            <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                  <span class="sr-only">Toggle navigation</span>
                </a>
            
            </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">MENU - EU RECLAMO -</li>
        
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Usuário Prestador</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route( 'admin::prestador::usuario::cadastrar')}}">Cadastrar Usuários</a></li>
            <li><a href="{{ route( 'admin::prestador::usuario::buscar')}}">Buscar Usuários</a></li>
          </ul>
        </li>
        
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Manifestação</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route( 'admin::manifestacao::buscar')}}">Buscar</a></li>
          </ul>
        </li>
        
        <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>Relatórios Prestador</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route( 'admin::relatorio::acompanhamento')}}">Acompanhamento</a></li>
            <li><a href="{{ route( 'admin::relatorio::acompanhamentofechado')}}">Acompanhamento Fechado</a></li>
            
          </ul>
        </li>
        
        
        <li class="treeview">
          <a href="{{ route( 'admin::sair')}}"><i class="fa fa-link"></i> <span>Sair</span>
            
          </a>
                    
                </ul>
    </section>
         
  </aside>
  <div class="content-wrapper" style="min-height: 100% !important">
        <section class="content">
            <div class="row">
                <div class="col-xs-12 ">
                    <div class='resposta'>
{!! isset($resp)?$resp:"" !!}
</div>
                    @yield("conteudo")
                </div>
            </div>
        </section>
        <!-- /#page-wrapper -->
</div>
  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- Default to the left -->
    
  </footer>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
    </div>
    <!-- /#wrapper -->

    
</body>

</html>
