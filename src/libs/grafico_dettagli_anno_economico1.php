<?php
    require_once '../libs/database.php';
    require_once '../libs/bootstrap.php';
    require_once '../libs/functions.php';

    sec_session_start();

    if ($dbh -> login_check()) {
        $anni = $dbh -> get_anno_economico($_GET['id']);
        foreach ($anni as $anno) {
            $anno_riferimento = $anno;
        }
        $uscite_data = array(
            array("label" => "Progettisti", "y" => (($anno_riferimento["CostoProgettisti"] / $anno_riferimento["Uscite"]) * 100)),
            array("label" => "Venditori", "y" => (($anno_riferimento["CostoVenditori"] / $anno_riferimento["Uscite"]) * 100)),
            array("label" => "Operai", "y" => (($anno_riferimento["CostoOperai"] / $anno_riferimento["Uscite"]) * 100)),
            array("label" => "Addetti Risorse Umane", "y" => (($anno_riferimento["CostoARU"] / $anno_riferimento["Uscite"]) * 100)),
            array("label" => "Stampanti", "y" => (($anno_riferimento["CostoStampanti"] / $anno_riferimento["Uscite"]) * 100)),
            array("label" => "Materiale", "y" => (($anno_riferimento["CostoMateriale"] / $anno_riferimento["Uscite"]) * 100))
        );
        $entrate_data = array(
            array("label" => "Progettazione", "y" => (($anno_riferimento["EntrateProgettazione"] / $anno_riferimento["Entrate"]) * 100)),
            array("label" => "Produzione", "y" => (($anno_riferimento["EntrateProduzione"] / $anno_riferimento["Entrate"]) * 100)),
            array("label" => "Servizi", "y" => (($anno_riferimento["EntrateServizi"] / $anno_riferimento["Entrate"]) * 100))
        );
    } 
?>