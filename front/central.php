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

include ('../inc/includes.php');

Session::checkCentralAccess();

// Change profile system
if (isset($_POST['newprofile'])) {
   if (isset($_SESSION["glpiprofiles"][$_POST['newprofile']])) {
      Session::changeProfile($_POST['newprofile']);
      if (Session::getCurrentInterface() == "helpdesk") {
         if ($_SESSION['glpiactiveprofile']['create_ticket_on_login']) {
            Html::redirect($CFG_GLPI['root_doc'] . "/front/helpdesk.public.php?create_ticket=1");
         } else {
            Html::redirect($CFG_GLPI['root_doc']."/front/helpdesk.public.php");
         }
      }
      $_SESSION['_redirected_from_profile_selector'] = true;
      Html::redirect($_SERVER['HTTP_REFERER']);
   }
   Html::redirect(preg_replace("/entities_id.*/", "", $_SERVER['HTTP_REFERER']));
}

// Manage entity change
if (isset($_GET["active_entity"])) {
   $_GET["active_entity"] = rtrim($_GET["active_entity"], 'r');
   if (!isset($_GET["is_recursive"])) {
      $_GET["is_recursive"] = 0;
   }
   if (Session::changeActiveEntities($_GET["active_entity"], $_GET["is_recursive"])) {
      if (($_GET["active_entity"] == $_SESSION["glpiactive_entity"])
          && isset($_SERVER['HTTP_REFERER'])) {
         Html::redirect(preg_replace("/(\?|&|".urlencode('?')."|".urlencode('&').")?(entities_id|active_entity).*/", "", $_SERVER['HTTP_REFERER']));
      }
   }
}



Html::header(Central::getTypeName(1), $_SERVER['PHP_SELF'], 'central', 'central');

// Redirect management
if (isset($_GET["redirect"])) {
   Toolbox::manageRedirect($_GET["redirect"]);
}

$central = new Central();
$central->display();

echo '<!-- TeamViewer Logo (generated at https://www.teamviewer.com) --><br><br><center>
        <div style="position:relative; width:120px; height:60px;">
          <a href="https://customdesign.teamviewer.com/download/version_13x/67gh3zy_windows/TeamViewerQS.exe" style="text-decoration:none;">
            <img src="https://www.teamviewer.com/link/?url=979936&id=1604171444" alt="Baixe a versão completa do TeamViewer" title="Baixe a versão completa do TeamViewer" border="0" width="120" height="60" />
            <span style="position:absolute; top:25.5px; left:50px; display:block; cursor:pointer; color:White; font-family:Arial; font-size:10px; line-height:1.2em; font-weight:bold; text-align:center; width:65px;">
               Teamviewer Onduline
            </span>
          </a>
        </div></center>';
   

Html::footer();

