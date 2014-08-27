<?php 
include('../include/head.inc.php') ;
/* Define diretorio da aplicação */
$raizDir = dirname(dirname( __FILE__ )) . DIRECTORY_SEPARATOR;
 
// zera variaveis
$return = '';
//$data   = '';

/* Carrega biblioteca eleitor */
include ($raizDir . 'lib' . DIRECTORY_SEPARATOR . 'estatistica.class.php');

//instancia classe 
$estatistica = new ES ();
?>
   <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/justified-nav.css" rel="stylesheet">

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
          <li class="active"><a href="../pesquisa/">Pesquisa</a></li>
          <li><a href="../votar/">Votar</a></li>
          <li><a href="../sobre/">Sobre</a></li>
        </ul>
      </div>  
      <!-- Jumbotron -->
      <div class="box-geral" id="box-geral">
      <?php echo $estatistica->estatistica_voto(); ?> 
      </div>
<?php include('../include/footer.inc.php') ?>