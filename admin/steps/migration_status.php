<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["step_code"] == "migration_status" && check_bitrix_sessid('send_sessid')) {
    /** @noinspection PhpIncludeInspection */
    require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_admin_js.php");
    \Sprint\Migration\Module::setDbOption('admin_versions_view', 'status');


    $search = !empty($_POST['search']) ? $_POST['search'] : '';

    $versions = $versionManager->getVersions(array(
        'for' => 'all',
        'search' => $search,
    ));

    $status = array(
        'is_new' => 0,
        'is_installed' => 0,
        'is_unknown' => 0,
    );

    foreach ($versions as $aItem) {
        $key = $aItem['status'];
        $status[$key]++;
    }


    ?>
    <table style="border-collapse: collapse;width: 100%">
    <?foreach ($status as $code => $cnt): $ucode = strtoupper($code);?>
        <tr>
            <td style="width:50%;text-align: left;padding: 5px;">
                <span class="c-migration-item-<?= $code ?>">
                    <?= GetMessage('SPRINT_MIGRATION_' . $ucode) ?>
                </span>
                <?= GetMessage('SPRINT_MIGRATION_DESC_' . $ucode) ?>
            </td>
            <td style="width:50%;text-align: left;padding: 5px;">
                <?= $cnt ?>
            </td>
        </tr>
    <?endforeach ?>
    </table>
    <?
    /** @noinspection PhpIncludeInspection */
    require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin_js.php");
    die();
}