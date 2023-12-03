<?
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

class FeedBackHandler {
    private const EVENT_NAME = 'FEEDBACK_FORM';

    public static function changeData(&$event, &$lid, &$arFields) {
        global $USER;
        if ($event === self::EVENT_NAME) {
            if ($USER->IsAuthorized()) {
                $arFields['AUTHOR'] = Loc::GetMessage(
                    'FEEDBACK_AUTHOR_AUTH',
                    [
                        '#ID#'        => $USER->GetID(),
                        '#LOGIN#'     => $USER->GetLogin(),
                        '#NAME#'      => $USER->GetFirstName(),
                        '#NAME_FORM#' => $arFields['AUTHOR']
                    ]
                );
            }
            else {
                $arFields['AUTHOR'] = Loc::GetMessage(
                    'FEEDBACK_AUTHOR_NO_AUTH',
                    [
                        '#NAME_FORM#' => $arFields['AUTHOR']
                    ]
                );
            }

            self::addLog($arFields['AUTHOR']);
        }
    }

    private static function addLog($author) {
        CEventLog::Add([
            'SEVERITY' => 'INFO',
            'AUDIT_TYPE_ID' => 'CHANGE_DATA_FORM_FEEDBACK',
            'MODULE_ID' => 'main',
            'DESCRIPTION' => Loc::GetMessage('FEEDBACK_LOG_MESSAGE', [
                '#AUTHOR#' => $author
            ])
        ]);
    }
}
AddEventHandler("main", "OnBeforeEventAdd", ["FeedBackHandler", "changeData"]);
?>