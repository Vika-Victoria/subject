<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'wp_subject');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'Hi.O.|XQ66[P)jYk;pYqTUcY]ZoX|Xe*a57^t-$+52rRV,qb>;@eFyo@i1M?A!ML');
define('SECURE_AUTH_KEY',  'VO ^qGqo4}!F&?rmtx<*8{Hnt?VG~C{c.MIsbm`d6~Zc>LdY%YW$oxdJ %P+7|1{');
define('LOGGED_IN_KEY',    'ZH!uoH/Zg#8([(/w9fG?c/<H$o@pex7}3>R*}?C%(vRo:/dXz5A=y_s_D0W6/I z');
define('NONCE_KEY',        '_wd.|p<i;V?o_{4Gh.W;3s.lQ>4^E{vm[;t4kWv0ueM qp1%ZAC7r8xa=x=IS/>O');
define('AUTH_SALT',        'gsfE[x:L|q}s!4{g.aIa&lskh/.5uK;Ntp.Ij5a>{X.xdNH_[MDd%JyRro=]_Q> ');
define('SECURE_AUTH_SALT', 'R?.62jfcghyL}C$^bDf4=nuiS7*n^uEz4sJ7l@{r[rfc8z1vb<xICFP91/ES}iao');
define('LOGGED_IN_SALT',   'Vgoc_!L-O%:vuZe!9lcb>ST6p2/?^v>Sc.P&a5`5r+QMDe-WkPp~^B)/wyaVA2?Q');
define('NONCE_SALT',       '[#fz}qqdK9*{}G)d x7]%]9uj0B60n7>[on}G0FmorbIkq{a)[z3~XS0WoUB4&9T');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 * 
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
