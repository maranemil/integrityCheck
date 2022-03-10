<?php /** @noinspection SpellCheckingInspection */
/** @noinspection PhpUndefinedVariableInspection */

/**
 * Created by PhpStorm.
 * User: emil
 * Date: 21.01.15
 * Time: 17:01
 */

///////////////////////////////////////////////////////////////////////////////////////////
//
// INTEGRITY CHECKER VERSION 0.1
// Author: Emil Maran
//
///////////////////////////////////////////////////////////////////////////////////////////

if (!defined('sugarEntry')) {
    define('sugarEntry', true);
}

// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', true);
// ini_set('display_startup_errors', true);

// chdir(dirname(__FILE__));
// define('ENTRY_POINT_TYPE', 'api');
// require_once('include/entryPoint.php');

// # TEST CASE FORCE TO GET SPECIFIC PACKAGE MODULE
// $_REQUEST['install_file'] = $unzip_dir = 'upload/upgrades/module/integrityCheck2.zip';
// $manifestFile = "upload/upgrades/module/integrityCheck2-manifest.php";

// # GET PACKAGE MODULE THAT BELONGS TO THIS INSTALLER WITH MANIFEST FILE
$unzip_dir = $_REQUEST["install_file"];
$manifestFile = str_replace(".zip", "-manifest.php", $_REQUEST["install_file"]);

// # CHECK IF ZIPARCHIVE CLASS IS ACTIV IN PHP
if (!class_exists('ZipArchive')) {
    //$myclass = new MyClass();
    die("Installation cannot continue! <br/> Please check if server has ZipArchive installed! ");
}

// # READ ZIP FILES AND DO A LIST
$za = new ZipArchive();
$za->open($unzip_dir);
for ($i = 0; $i < $za->numFiles; $i++) {
    $stat = $za->statIndex($i);
    //print "<pre>";
    //print_r( basename( $stat['name'] ) . PHP_EOL );
    if (!preg_match('/svn|post_execute|post_uninstall|pre_execute|pre_uninstall|manifest.php/', $stat['name'])) {
        $arZipData[] = $stat['name'];
    }
    //print "</pre>";
}

// # INCLUDE MANIFEST FILE
include($manifestFile);

// # TEST CASE DUMMY ARRAY
/*
$installdefs["copy"][] = array(
	'from' => '<basepath>/include/generic/SugarWidgets/SugarWidgetFieldPhone.php',
	'to' => 'include/generic/SugarWidgets/SugarWidgetFieldPhone.php',
);

$installdefs["copy"][] = array(
	'from' => '<basepath>/custom/include/javascript',
	'to' => 'custom/include/javascript',
);
*/

// # IF WE HAVE SOME FILES TO BE COPIED THEN DO A CHECK COMPARISON BETWEEN PACKAGE AND SUGARCRM INSTANCE
if (is_array($installdefs["copy"])) {
    foreach ($installdefs["copy"] as $entry) {
        $path_partsFrom = pathinfo($entry["from"]);
        $path_partsTo = pathinfo($entry["to"]);

        $arCopyFrom[] = str_replace('<basepath>/', "", $path_partsFrom["dirname"]);
        $arCopyTo[] = $path_partsTo["dirname"];
    }

    // check if manifest files are type php or js
    function getFilesToInstall($arCopyFrom, $arZipData)
    {
        $arToBeChecked = array();
        foreach ($arZipData as $zipFile) {
            if (isZipFileInList($zipFile, $arCopyFrom) && preg_match('/.php|.js/', $zipFile)) {
                $arToBeChecked[] = $zipFile;
            }
        }
        return $arToBeChecked;
    }

    // check if zip files are the same as manifest file
    function isZipFileInList($zipFile, $arCopyFrom)
    {
        foreach ($arCopyFrom as $pathCopy) {
            if (stripos($zipFile, $pathCopy) !== false) {
                return true;
                // break;
            }
        }
        return false;
    }

    // create list of files from manifest that must be installed
    $arToCheck = getFilesToInstall($arCopyTo, $arZipData);

    // check if files from module are already in the Sugar Instance
    $arSugarFileExists = array();
    foreach ($arToCheck as $sugarfile) {
        if (file_exists($sugarfile)) {
            $arSugarFileExists[] = $sugarfile . " file already exists! <br>";
        }
    }

    // if match found in comparison then bring a nice installation warning
    if (count($arSugarFileExists)) {
        echo "<strong>Installation cannot continue! </strong><br />";
        echo "Integrity Check has found the same files in package/module and SugarCRM instance! <br /><br />";

        echo '
        <script>
            document.getElementById("displayLog").style.display="block";
            $("#displayLog").css("background","none repeat scroll 0 0 orange");
            $("#displayLog").css("padding","20px");
        </script> ';

        die("<span color=red>" . implode($arSugarFileExists) . "</span>");
    }
}

/**
 * =========================== SERVER ARRAY ===========================
 * [HTTP_HOST] => localhost
 * [HTTP_USER_AGENT] => Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:35.0) Gecko/20100101 Firefox/35.0
 * [SERVER_NAME] => localhost
 * [SERVER_ADDR] => 127.0.0.1
 * [SERVER_PORT] => 80
 * [REMOTE_ADDR] => 127.0.0.1
 * [DOCUMENT_ROOT] => /opt/lampp/htdocs
 * [REQUEST_SCHEME] => http
 * [CONTEXT_PREFIX] =>
 * [CONTEXT_DOCUMENT_ROOT] => /opt/lampp/htdocs
 * [SERVER_ADMIN] => you@example.com
 * [SCRIPT_FILENAME] => /opt/lampp/htdocs/Projects/Sugar..../index.php
 * [REQUEST_METHOD] => POST
 * [QUERY_STRING] => module=Administration&view=module&action=UpgradeWizard_commit
 * [REQUEST_URI] => /Projects/Sugar...../index.php?module=Administration&view=module&action=UpgradeWizard_commit
 * [SCRIPT_NAME] => /Projects/Sugar...../index.php
 * [PHP_SELF] => /Projects/Sugar......./index.php
 * [REQUEST_TIME_FLOAT] => 1421855526.578
 * [REQUEST_TIME] => 1421855526
 * ======================= REQUEST ARRAY ===========================
 * [module] => Administration
 * [view] => module
 * [action] => UpgradeWizard_commit
 * [mode] => Install
 * [author] => Emil Maran
 * [name] => Integrity Check Helper
 * [description] => Integrity Check Module
 * [is_uninstallable] => 1
 * [id_name] => IntegrityCheckModule_1421854167
 * [previous_version] =>
 * [previous_id] =>
 * [version] => 0.0.1
 * [copy_count] => 0
 * [run] => commit
 * [install_file] => upload/upgrades/module/integrityCheck2.zip
 * [unzip_dir] => dES1EH
 * [zip_from_dir] => .
 * [zip_to_dir] => .
 */
