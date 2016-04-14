<?php
 session_start();
if (isset($_SESSION["s_usuario"])) {
    header("Location: vistas/convocatorias.php");
}
@$mje = base64_decode($_GET['mje']);
?>

<html>
    <head>
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
        <title>Sistema de Gestión Convocatorias docente</title>
        <link rel="stylesheet" href="slide/css/style.css" type="text/css" media="screen"/>        
        <script type="text/javascript" src="slide/sliding.form.js"></script>
        <style>
            span.reference{
                position:fixed;
                left:5px;
                top:5px;
                font-size:10px;
                text-shadow:1px 1px 1px #fff;
            }
            span.reference a{
                color:#555;
                text-decoration:none;
                text-transform:uppercase;
            }
            span.reference a:hover{
                color:#000;

            }
            h1{
                color:#ccc;
                font-size:36px;
                text-shadow:1px 1px 1px #fff;
                padding:20px;
            }

            <!-- aumento-->
            *{
                margin:0px;
                padding:0px;
            }
            body{
                color:#444444;
                font-size:13px;
                background: #555;
                font-family:"Century Gothic", Helvetica, sans-serif;

            }
            #content{
                margin:15px auto;
                text-align:right;
                width:600px;
                position:relative;
                height:231px;
            }
           
            #steps{
                width:600px;
                /*height:320px;*/
                overflow:hidden;
            }
            .step{
                float:left;
                width:600px;
                /*height:320px;*/
            }
            #navigation{
                height:45px;
                background-color:#e9e9e9;
                border-top:1px solid #fff;
                -moz-border-radius:0px 0px 10px 10px;
                -webkit-border-bottom-left-radius:10px;
                -webkit-border-bottom-right-radius:10px;
                border-bottom-left-radius:10px;
                border-bottom-right-radius:10px;
            }
            #navigation ul{
                list-style:none;
                float:left;
                margin-left:22px;
            }
            #navigation ul li{
                float:left;
                border-right:1px solid #ccc;
                border-left:1px solid #ccc;
                position:relative;
                margin:0px 2px;
            }
            #navigation ul li a{
                display:block;
                height:45px;
                background-color:#444;
                color:#777;
                outline:none;
                font-weight:bold;
                text-decoration:none;
                line-height:45px;
                padding:0px 20px;
                border-right:1px solid #fff;
                border-left:1px solid #fff;
                background:#f0f0f0;
                background:
                    -webkit-gradient(
                    linear,
                    left bottom,
                    left top,
                    color-stop(0.09, rgb(240,240,240)),
                    color-stop(0.55, rgb(227,227,227)),
                    color-stop(0.78, rgb(240,240,240))
                    );
                background:
                    -moz-linear-gradient(
                    center bottom,
                    rgb(240,240,240) 9%,
                    rgb(227,227,227) 55%,
                    rgb(240,240,240) 78%
                    )
            }
            #navigation ul li a:hover,
            #navigation ul li.selected a{
                background:#d8d8d8;
                color:#666;
                text-shadow:1px 1px 1px #fff;
            }
            span.checked{
                background:transparent url(../images/checked.png) no-repeat top left;
                position:absolute;
                top:0px;
                left:1px;
                width:20px;
                height:20px;
            }
            span.error{
                background:transparent url(../images/error.png) no-repeat top left;
                position:absolute;
                top:0px;
                left:1px;
                width:20px;
                height:20px;
            }
            #steps form fieldset{
                border:none;
                padding-bottom:20px;
            }
            #steps form legend{
                text-align:left;
                background-color:#f0f0f0;
                color:#666;
                font-size:20px;
				font-family: 'Roboto', sans-serif;
                text-shadow:1px 1px 1px #fff;
                font-weight:300;
                float:left;
                width:590px;
                padding:5px 0px 5px 10px;
                margin:10px 0px;
                border-bottom:1px solid #fff;
                border-top:1px solid #d9d9d9;
            }
            #steps form p{
                float:left;
                /* clear:both;*/
                margin:5px 0px;
                background-color:#f4f4f4;
                border:1px solid #fff;
                width:400px;
                padding:10px;
                margin-left:100px;
                -moz-border-radius: 5px;
                -webkit-border-radius: 5px;
                border-radius: 5px;
                -moz-box-shadow:0px 0px 3px #aaa;
                -webkit-box-shadow:0px 0px 3px #aaa;
                box-shadow:0px 0px 3px #aaa;

            }
            #steps form p label{
                width:160px;
                float:left;
                text-align:right;
                margin-right:15px;
                line-height:26px;
                color:#666;
                text-shadow:1px 1px 1px #fff;
                font-weight:300;
				font-family: 'Roboto', sans-serif;
				font-size:20px
            }
            #steps form input:not([type=radio]),
            #steps form textarea,
            #steps form select{
                background: #ffffff;
                border: 1px solid #ddd;
                -moz-border-radius: 3px;
                -webkit-border-radius: 3px;
                border-radius: 3px;
                outline: none;
                padding: 5px;
                width: 200px;
                float:left;
            }
            #steps form input:focus{
                -moz-box-shadow:0px 0px 3px #aaa;
                -webkit-box-shadow:0px 0px 3px #aaa;
                box-shadow:0px 0px 3px #aaa;
                background-color:#FFFEEF;
                color:#933!important;
                font-size:16px
            }
          
            #steps form p.submit{
                background:none;
                border:none;
                -moz-box-shadow:none;
                -webkit-box-shadow:none;
                box-shadow:none;
            }
            #steps form button {
                border:#333;
                /*outline:none;*/
              	border-radius: 3px;
                
                display: block;
                cursor:pointer;
                margin: 0px auto;
                clear:both;
                padding: 7px 25px;
             
                font-weight:300;
                font-family:"Roboto", sans-serif;
                font-size:15px;
               
                box-shadow:0px 0px 3px #aaa;
                background:#d8d8d8;
            }
            #steps form button:hover {
                background:#d8d8d8;
                color:#666;
               
            }


        </style>
    </head>


    <body bgcolor="#FFFFFF" >
    <center></center>
    <table bgcolor="#CCCCCC">
        <tr>
            <td>
                <strong><?php
                   
                    ?>
                </strong>
            </td>
        </tr>
        <tr>
            <td>
                <span class="Estilo1"></span>
            </td>
        </tr>
    </table>

    <?php
    //Si no existe una session abierta entonces se loguea al usuario o se permite registrarse.
    if (!isset($_SESSION["s_username"])) {
        ?>
        <center><table width="350" border="0" cellspacing="0" cellpadding="0" bordercolor="#FFFFFF">
                <tr>
                    <td>
                        <div id="content" style="text-align: center; ">
                        <img src="vistas/images/logouncapng.png" alt="" name="logo" width="202" height="74" id="logo"> </br>
                            <div style="font-family:'Roboto', sans-serif; font-weight: 300; font-size:25px; margin-bottom:30px; color:#f4f4f4;" >
	                            Sistema de Gestión Convocatorias docente
                            </div>
                            <div id="wrapper">
                                <div align="center" id="steps">
                                    <form method="post" action="controlador/login.php" name="pForm">

                                        <fieldset class="step">
                                           
                                            <p style="font-size:16px; font-family:'Roboto', sans-serif; font-weight: 300; "> Usuario 
                                                <input type="text" size="20" name="fUsuario" autocomplete="off" maxlength="20"  value="<?php
                                                if (isset($_COOKIE["usuario"])) {
                                                    echo $_COOKIE["usuario"];
                                                } else {
                                                    echo '';
                                                }
                                                ?>" class="imputbox">
                                            </p>
                                            <p style="font-size:16px; font-family:'Roboto', sans-serif; font-weight: 300; "> Password 
                                                <input type="password" size="20" name="fClave" autocomplete="off" maxlength="20"  value="<?php
                                                if (isset($_COOKIE["clave"])) {
                                                    echo $_COOKIE["clave"];
                                                } else {
                                                    echo '';
                                                }
                                                ?>" class="imputbox">
                                            </p>

                                            <p class="submit">
                                            <table>
                                                <tr>
                                                    <td><button  type="submit" value="Aceptar" name="Aceptar" >Aceptar</button></td>
                                                    <td><button  type="reset" value="Limpiar" name="Limpiar" >Limpiar</button></td>
                                                </tr>	 
                                            </table>
                                            </p>

                                        </fieldset>
                                    </form>
                                </div>
                                <div style="color:red;" align="center">
                                    <?php
                                    if ($mje != "") {
                                        echo $mje;
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                    </td>
                </tr>
            </table></center>
        <?php
    } else {
//Si existe una session abierta el usuario puede cerrar la session o ir al
//menu de acciones.	
        ?>
        <div align="center">            
            <a href='script/session.cerrar.php'>Cerrar Sesión</a>
        </div>

<?php } ?>

</body>
</html>