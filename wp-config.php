<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать файл в "wp-config.php"
 * и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки базы данных
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры базы данных: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', '1278-22_12684' );

/** Имя пользователя базы данных */
define( 'DB_USER', '1278-22_12684' );

/** Пароль к базе данных */
define( 'DB_PASSWORD', '6fdaccb78e9150084f9e' );

/** Имя сервера базы данных */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу. Можно сгенерировать их с помощью
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}.
 *
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными.
 * Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'V+NW;~zSNE(e1E^bbTS2p@v.xt=TAy3s>|}cvGhL[{@IQ{,=AcSdz_zz@xK8R}fw' );
define( 'SECURE_AUTH_KEY',  'pK=tGL_|{ckFGV^g}%:3YWE4rRB&m1y{+K[3cu(C?#SeY~I8/;*>TxI8<#x|Sz =' );
define( 'LOGGED_IN_KEY',    'qC8[]qzrX:ub#x^n|5sLf=XRi]&>V7X( ^R/O/N@G=h(2wTB%6<eU%LFa?!0z6Gd' );
define( 'NONCE_KEY',        '*3?={TM8,u[Z[ARk(LxlzEfhPIBw_%r8_Y],mL.s(<!CWM}2HsUF&}d969VNua&0' );
define( 'AUTH_SALT',        '>WpwV&MfGw8VkG@RB}L$++hxN$1wqM3F!U;]H@2iNR@?ubX]71*rcR$OuuBx!8/M' );
define( 'SECURE_AUTH_SALT', 'MRhQq5R`j+km61=rW9{+:d@Cu8zoe8Tx]o]fsTGf7+|& 0$P5^ H829igWT?>QJo' );
define( 'LOGGED_IN_SALT',   '0P:x=+nN-,RNJN`vE/~Xi*~]H$E;&,}K=UEwkn{%sdq^)EqtvnaXVJ#}l[g9V|9r' );
define( 'NONCE_SALT',       '<?:?O<8:1_f<j{kEyVprERc576;,ZIwhJyDJvlG`YixrhXe!y LUIZTR`PndK:SP' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'pdDcU_';


/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Произвольные значения добавляйте между этой строкой и надписью "дальше не редактируем". */



/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';