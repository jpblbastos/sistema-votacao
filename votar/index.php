<?php include('../include/head.inc.php') ?>
   <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/justified-nav.css" rel="stylesheet">


    <!-- Requisições -->
    <script type="text/javascript" src="../ajax/ajax.js"></script>

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <div class="masthead">
        <h3 class="text-muted">Sistema de Votação</h3>
        <ul class="nav nav-justified">
          <li><a href="../">Home</a></li>
          <li><a href="../pesquisa/">Pesquisa</a></li>
          <li class="active"><a href="../votar/">Votar</a></li>
          <li><a href="../sobre/">Sobre</a></li>
        </ul>
      </div>   
      <!-- Jumbotron -->
      <div class="box-geral" id="box-geral">
      <div class="jumbotron" id="box">
      <form class="form-signin" role="form" >
      	<h3 class="text-muted">Precisamos de alguns dados ...</h3>
      	<p><i class="fa fa-2x fa-pencil-square-o fa-fw"></i></p>
      	<div class="input-group margin-bottom-sm">
             <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
             <input class='form-control' name='email' id='email' maxlength='250' size='60' type='email'  placeholder='Email' required autofocus>
        </div>
        <br/>
        <!--<input type="button" name="btnPesquisar" value="Pesquisar" onclick="verifica_eleitor();" />-->
        <button class="btn btn-lg btn-primary" type="button" onclick="verifica_eleitor();">Consultar Eleitor<i class="fa fa-refresh fa-fw"></i></button>
      </form>
      </div> <!-- /jumbotron -->
      </div>
<?php include('../include/footer.inc.php') ?>