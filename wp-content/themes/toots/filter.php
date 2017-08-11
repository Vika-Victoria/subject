<?php
function text($text) {
    //обрабатываем переданный текст - удалим html теги
    $text = strip_tags($text);
    //теперь , возвращаем текст через фильтр
    //если к фильтру не прикреплена ни одна функция, то текст просто
    //вернется как есть, т.е.  строкка ниже будет эквивалентна "return $text"
    return apply_filters('my_filter_name', $text);
    }

    //создадим ф-ю для фильтра
function my_filter_function($text) {
    //обрежем текст до 30 символов и вернем его
    return mb_strlen($text, 0, 30). '...';
}
//прикрепим ф-ю к фильтру
add_filter('my_filter_name', 'my_filter_function');

echo text('Lorem <b>Ipsum</b> is simply dummy text of the printing and typesetting industry. ');
//выводит краткое описание фильтра
function new_excerpt_length($length) {
    return 20;
}
add_filter('excerpt_length', 'new_excerpt_length');