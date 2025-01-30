<?php
// Základní inicializace, připojení k systému
include(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');

// Definice jazyka, zdrojového a cílového
$id_lang_source = 1; // Zdrojový jazyk
$id_lang_target = 2; // Cílový jazyk
$id_shop = 1;       // ID obchodu

// SQL dotaz na doplnění názvu
$sql = "
    UPDATE `"._DB_PREFIX_."product_lang` target
    INNER JOIN `"._DB_PREFIX_."product_lang` source
        ON target.id_product = source.id_product
    SET target.name = source.name
    WHERE target.id_lang = " . (int)$id_lang_target . "
      AND source.id_lang = " . (int)$id_lang_source . "
      AND target.id_shop = " . (int)$id_shop . "
      AND source.id_shop = " . (int)$id_shop . "
      AND (target.name IS NULL OR target.name = '')
";

// Spuštění dotazu
try {
    Db::getInstance()->execute($sql);
    echo "Názvy byly úspěšně zkopírovány ze zdrojového jazyka do cílového jazyka.";
} catch (Exception $e) {
    echo "Chyba při provádění dotazu: " . $e->getMessage();
}
?>
