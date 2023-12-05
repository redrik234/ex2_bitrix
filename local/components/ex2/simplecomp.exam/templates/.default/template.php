<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p><b><?=GetMessage("SIMPLECOMP_EXAM2_CAT_TITLE")?></b></p>
<?if ($arResult['DATA']):?>
    <ul>
        <?foreach($arResult['DATA'] as $news):?>
            <li>
                <p>
                    <b><?=$news['NAME']?></b> - <?=$news['ACTIVE_FROM']?>
                    (
                    <?=implode(', ', array_map(fn($section) => $section['NAME'], $news['SECTIONS']));?>
                    )
                </p>
                <ul>
                    <?foreach($news['PRODUCTS'] as $product):?>
                        <li>
                            <p><?=$product['NAME']?> - <?=$product['PROPERTY_PRICE_VALUE']?> - <?=$product['PROPERTY_MATERIAL_VALUE']?> - <?=$product['PROPERTY_ARTNUMBER_VALUE']?></p>
                        </li>
                    <?endforeach;?>
                </ul>
            </li>
        <?endforeach;?>
    </ul>
<?endif;?>