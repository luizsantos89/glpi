<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Onduline - GLPI</title>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" type="images/x-icon" href="pics/onduline.ico" />
        <meta name='viewport' content='width=device-width, initial-scale=1'/>
        <link rel="stylesheet" type="text/css" href="front/css.php?file=main_styles&v=9.4.2" media="all">
        <link rel="stylesheet" type="text/css" href="lib/font-awesome/css/all.min.css?v=9.4.2" media="all">
        <link rel="stylesheet" type="text/css" href="css/css.css" />
        <script type="text/javascript">
            //<![CDATA[


                  var CFG_GLPI  = {
                     'url_base': 'http://10.31.71.210/glpi',
                     'root_doc': '/glpi',
                  };


            //]]>
        </script>
        <script type="text/javascript" src="lib/jquery/js/jquery.min.js?v=9.4.2"></script>
        <script type="text/javascript" src="lib/jqueryplugins/select2/js/select2.full.js?v=9.4.2"></script>
        <script type="text/javascript" src="lib/fuzzy/fuzzy-min.js?v=9.4.2"></script>
        <link rel="stylesheet" type="text/css" href="lib/jqueryplugins/select2/css/select2.min.css?v=9.4.2" media="all">
        <script type="text/javascript" src="js/common.min.js?v=9.4.2"></script>
    </head>
    <body>
        <div>
            <div id='logo_login'></div>
            
            <div id='text-login'>
                Sistema de Atendimento - Suporte
            </div>
            
            <div id='boxlogin'>
                <form action='front/login.php' method='post'>
                    <input type='hidden' name='noAUTO' value='1' />
                    <p class="login_input" id="login_input_name"> 
                        <input type="text" name="fielda5e28315a6016c" id="login_name" required="required"
                            placeholder="Usuário" autofocus="autofocus" />
                    </p>
                    <p class="login_input" id="login_input_password">
                        <input type="password" name="fieldb5e28315a601b6" id="login_password" required="required"
                               placeholder="Senha"  />
                    </p>
                    <input type="hidden" name="auth" value="local" />
                    <p class="login_input">
                        <label for="login_remember" style="color: black; font-size: 10pt;">
                            <input type="checkbox" name="fieldc5e28315a601fb" id="login_remember"
                                   accept=""checked="checked" />
                            Lembrar-me
                        </label>
                    </p>
                    <p class="login_input">
                        <input type="submit" name="submit" value="Acessar" class="submit" />
                    </p>
                    <a id="forget" href="front/lostpassword.php?lostpassword=1" style="color: red; font-size: 10pt;">
                        Esqueceu sua senha?
                    </a>
                    <input type="hidden" name="_glpi_csrf_token" value="0c26c648c424b96cd55e27d0d59dfe25" />
                </form>
                <center>
                    <br><br>
                    <img src="pics/logos/logo-GLPI-100-black.png" />
                </center>
                <script type="text/javascript">
                    //<![CDATA[

                    $(function() {
                          $('#login_name').focus();
                       });

                    //]]>
                </script>
            </div>
            
            <div class='error'>
                <noscript>
                    <p>Você deve ativar a função JavaScript do seu navegador</p>
                </noscript>
            </div>
            
            <div id='display-login'>
                <link rel="stylesheet" type="text/css" href="plugins/news/css/styles.min.css?v=9.4.2" media="all">
                <div class='plugin_news_alert-login'>
                    <div class='plugin_news_alert-container'>
                        
                    </div>
                    <script type="text/javascript" src="lib/jquery/js/jquery-1.10.2.min.js?v=9.4.2"></script>
                    <script type="text/javascript" src="lib/jquery/js/jquery-ui-1.10.4.custom.min.js?v=9.4.2">
                    </script><script type="text/javascript" src="plugins/news/js/news.min.js?v=9.4.2"></script>
                </div>
            </div>
        </div>
        
        <div id='footer-login' class='home'>
            <a href="http://glpi-project.org/" title="Powered by Teclib and contributors" class="copyright" target="_blank">
                GLPI Copyright &copy; 2015-2019 Teclib' and contributors
            </a> | 
            <a href="mailto:suporte.dsti@onduline.com.br" title="D.S.T.I. Suporte" class="copyright">
                D.S.T.I. Suporte
            </a>
        </div>
    </body>
</html>