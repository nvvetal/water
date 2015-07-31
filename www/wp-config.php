<?php
/**
 * Основные параметры WordPress.
 *
 * Этот файл содержит следующие параметры: настройки MySQL, префикс таблиц,
 * секретные ключи, язык WordPress и ABSPATH. Дополнительную информацию можно найти
 * на странице {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Кодекса. Настройки MySQL можно узнать у хостинг-провайдера.
 *
 * Этот файл используется сценарием создания wp-config.php в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать этот файл
 * с именем "wp-config.php" и заполнить значения.
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'water');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется снова авторизоваться.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '3[R,}]+4a<fnZAv|I|yn@@{Ve>k|%A+mjMEzJc>J-+Q:rvo(u}%tgf~GsQpq&`O2');
define('SECURE_AUTH_KEY',  'IrKyiP5Vwj]D4 R|KcP;ZHQK*?d8AuF&MvR `T1-b}j#.=wT?LQr{d|aTu2xrE,o');
define('LOGGED_IN_KEY',    'K+@}54++HYjQo`|&|_3SY(K?M1GjfKh+k?GR7GKa$6|8arPVB9I+A`/zC|8VU**f');
define('NONCE_KEY',        '+4F?Ortn f|T!]xYYcI)Pw-t3#?K>X6< Yw3|rrZk!|!z7:wJg%A+Y7Niy$MsEPl');
define('AUTH_SALT',        ') 6%TPyY|[S%Plj8L,XQ}%uhT3J?b%Y%&-=-k]T)u#->Y23%^LI|J&TwEmXS$p>R');
define('SECURE_AUTH_SALT', '~wcI`;;Jq*Zy[Pt-yHxVtk<|;`eQ%^.jY!z]w~=G@eed|&SsA.}0HR+gQSCM5_53');
define('LOGGED_IN_SALT',   'K)zv/Ihwm)C<OdN@wad.k5_?{G 3}mb)}DvZC.S2FGWL`t0>Shet+hhY,h`7HV+;');
define('NONCE_SALT',       'cy/mXsZ@^|v9f3-$.0GaGK* Muy56x`u!8$wmvQJmQ-!FLTEN@mVQ!YvwYAr+)=_');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько блогов в одну базу данных, если вы будете использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';
//-WP Tuner Plugin by MrPete------------
//--------------------------------------
$wpTunerStart = microtime();					// get start time as early as we can
if ( function_exists( 'getrusage' ) ) { $wpTunerStartCPU = getrusage(); }
@include_once(dirname(__FILE__).'/wp-content/plugins/wptuner/wptunertop.php'); // fire up WPTuner
//--------------------------------------
//-END WP Tuner Plugin------------------

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Настоятельно рекомендуется, чтобы разработчики плагинов и тем использовали WP_DEBUG
 * в своём рабочем окружении.
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
