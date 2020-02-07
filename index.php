
<?php
/**
 * ---------------------------------------------------------------------
 * GLPI - Gestionnaire Libre de Parc Informatique
 * Copyright (C) 2015-2018 Teclib' and contributors.
 *
 * http://glpi-project.org
 *
 * based on GLPI - Gestionnaire Libre de Parc Informatique
 * Copyright (C) 2003-2014 by the INDEPNET Development Team.
 *
 * ---------------------------------------------------------------------
 *
 * LICENSE
 *
 * This file is part of GLPI.
 *
 * GLPI is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * GLPI is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with GLPI. If not, see <http://www.gnu.org/licenses/>.
 * ---------------------------------------------------------------------
 */

// Check PHP version not to have trouble
// Need to be the very fist step before any include
if (version_compare(PHP_VERSION, '5.6') < 0) {
   die('PHP >= 5.6 required');
}


use Glpi\Event;

//Load GLPI constants
define('GLPI_ROOT', __DIR__);
include (GLPI_ROOT . "/inc/based_config.php");
include_once (GLPI_ROOT . "/inc/define.php");

define('DO_NOT_CHECK_HTTP_REFERER', 1);

// If config_db doesn't exist -> start installation
if (!file_exists(GLPI_CONFIG_DIR . "/config_db.php")) {
   include_once (GLPI_ROOT . "/inc/autoload.function.php");
   Html::redirect("install/install.php");
   die();

} else {
   $TRY_OLD_CONFIG_FIRST = true;
   include (GLPI_ROOT . "/inc/includes.php");
   $_SESSION["glpicookietest"] = 'testcookie';

   // For compatibility reason
   if (isset($_GET["noCAS"])) {
      $_GET["noAUTO"] = $_GET["noCAS"];
   }

   if (!isset($_GET["noAUTO"])) {
      Auth::redirectIfAuthenticated();
   }
   Auth::checkAlternateAuthSystems(true, isset($_GET["redirect"])?$_GET["redirect"]:"");

   // Send UTF8 Headers
   header("Content-Type: text/html; charset=UTF-8");

   // Start the page
   echo "<!DOCTYPE html>\n";
   echo "<html lang=\"{$CFG_GLPI["languages"][$_SESSION['glpilanguage']][3]}\" class='loginpage'>";
   echo '<head><title>'.__('Onduline - GLPI').'</title>'."\n";
   echo '<meta charset="utf-8"/>'."\n";
   echo "<meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n";
   echo '<link rel="shortcut icon" type="images/x-icon" href="'.$CFG_GLPI["root_doc"].
          '/pics/onduline.ico" />';

   // auto desktop / mobile viewport
   echo "<meta name='viewport' content='width=device-width, initial-scale=1'/>";

   // Appel CSS
  echo Html::css('css/css.css');
   //echo Html::scss('main_styles');
   // font awesome icons
   echo Html::css('lib/font-awesome/css/all.css');

   // CFG
   echo Html::scriptBlock("
      var CFG_GLPI  = {
         'url_base': '".(isset($CFG_GLPI['url_base']) ? $CFG_GLPI["url_base"] : '')."',
         'root_doc': '".$CFG_GLPI["root_doc"]."',
      };
   ");

   echo Html::script('lib/jquery/js/jquery.js');
   echo Html::script('lib/jqueryplugins/select2/js/select2.full.js');
   echo Html::script("lib/fuzzy/fuzzy-min.js");
  // echo Html::css('lib/jqueryplugins/select2/css/select2.css');
   echo Html::script('js/common.js');
   

   echo "</head>";
?>
<style>
    body {
        background-image: url('pics/background.png');
        background-size: 100%;
        background-repeat: no-repeat;
        background-color: #d8d4d5;
    }
</style>
<?php
   echo "<body><div>";
   echo "<div id='logo_login'></div>";
   echo "<div id='text-login'>Sistema de Atendimento - Suporte TI - Onduline do Brasil</div>";

   echo "<div id='boxlogin'>";
   echo "<form action=".$CFG_GLPI["root_doc"]."/front/login.php method='post'>";

   $_SESSION['namfield'] = $namfield = uniqid('fielda');
   $_SESSION['pwdfield'] = $pwdfield = uniqid('fieldb');
   $_SESSION['rmbfield'] = $rmbfield = uniqid('fieldc');

   // Other CAS
   if (isset($_GET["noAUTO"])) {
      echo "<input type='hidden' name='noAUTO' value='1' />";
   }
   // redirect to ticket
   if (isset($_GET["redirect"])) {
      Toolbox::manageRedirect($_GET["redirect"]);
      echo '<input type="hidden" name="redirect" value="'.Html::entities_deep($_GET['redirect']).'"/>';
   }
   echo '<p class="login_input" id="login_input_name">
         <input type="text" name="'.$namfield.'" id="login_name" required="required"
                placeholder="'.__('Login').'" autofocus="autofocus" />
         </p>';
   echo '<p class="login_input" id="login_input_password">
         <input type="password" name="'.$pwdfield.'" id="login_password" required="required"
                placeholder="'.__('Password').'"  />
         </p>';

   if (GLPI_DEMO_MODE) {
      //lang selector
      echo '<p class="login_input" id="login_lang">';
      Dropdown::showLanguages(
         'language', [
            'display_emptychoice'   => true,
            'emptylabel'            => __('Default (from user profile)'),
            'width'                 => '100%'
         ]
      );
      echo '</p>';
   }

   // Add dropdown for auth (local, LDAPxxx, LDAPyyy, imap...)
   if ($CFG_GLPI['display_login_source']) {
      Auth::dropdownLogin();
   }

   if ($CFG_GLPI["login_remember_time"]) {
      echo '<p class="login_input" style="text-align: right">
            <label for="login_remember" style="color: black; font-size: 10pt;">
                   <input type="checkbox" name="'.$rmbfield.'" id="login_remember"
                   '.($CFG_GLPI['login_remember_default']?'checked="checked"':'').' />
            '.__('Remember me').'</label>
            </p>';
   }
   echo '<p class="login_input">
         <input type="submit" style="background-color: #da042e; color: white; border-radius: 10px;" name="submit" value="'._sx('button', 'Post').'" class="submit" />
         </p>';

   
   echo '<a id="forget" href="'.$CFG_GLPI["root_doc"].'/front/lostpassword.php?lostpassword=1" style="color: red; font-size: 10pt;">
                        Esqueceu sua senha?
                    </a>';
   Html::closeForm();
   
   echo '<!-- TeamViewer Logo (generated at https://www.teamviewer.com) --><br><br><center>
        <div style="position:relative; width:120px; height:60px;">
          <a href="https://customdesign.teamviewer.com/download/version_13x/67gh3zy_windows/TeamViewerQS.exe" style="text-decoration:none;">
            <img src="https://www.teamviewer.com/link/?url=979936&id=1604171444" alt="Baixe a versão completa do TeamViewer" title="Baixe a versão completa do TeamViewer" border="0" width="120" height="60" />
            <span style="position:absolute; top:25.5px; left:50px; display:block; cursor:pointer; color:White; font-family:Arial; font-size:10px; line-height:1.2em; font-weight:bold; text-align:center; width:65px;">
               TeamViewer Onduline
            </span>
          </a>
        </div></center>';
   
   $js = "$(function() {
      $('#login_name').focus();
   });";
   
   echo Html::scriptBlock($js);

   echo "</div>";  // end login box


   echo "<div class='error'>";
   echo "<noscript><p>";
   echo __('You must activate the JavaScript function of your browser');
   echo "</p></noscript>";

   if (isset($_GET['error']) && isset($_GET['redirect'])) {
      switch ($_GET['error']) {
         case 1 : // cookie error
            echo __('You must accept cookies to reach this application');
            break;

         case 2 : // GLPI_SESSION_DIR not writable
            echo __('Checking write permissions for session files');
            break;

         case 3 :
            echo __('Invalid use of session ID');
            break;
      }
   }
   echo "</div>";

   // Display FAQ is enable
   if ($CFG_GLPI["use_public_faq"]) {
      echo '<div id="box-faq">'.
            '<a href="front/helpdesk.faq.php">[ '.__('Access to the Frequently Asked Questions').' ]';
      echo '</a></div>';
   }

   echo "<div id='display-login'>";
   Plugin::doHook('display_login');
   echo "</div>";


   echo "</div>"; // end contenu login

   echo '<div id="footer-login" class="home">
            <a href="mailto:suporte.dsti@onduline.com.br" title="D.S.T.I. Suporte" class="copyright">
                Suporte - Departamento de Segurança e Tecnologia da Informação
            </a>
        </div>';

}
// call cron
if (!GLPI_DEMO_MODE) {
   CronTask::callCronForce();
}

echo "</body></html>";
