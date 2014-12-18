EasyBoard
=========

EasyBoard 1.02 - доска объявлений для ModX Evo

Установка
---------

* Скопировать папку **assets** в корень вашего сайта.
* Создать модуль **Easy Board** с кодом из файла module.easy_board.php
* Создать сниппет **easy_board** с кодом из файла snippet.easy_board.php
* Если необходимо сменить название таблицы БД или папки, куда будут грузиться фотографии, то это можно сделать отредактировав файл **assets/module/easy_board/easy_board.config.php**
* Запустить модуль **Easy Board**.

После этого следует прикинуть структуру документов (рубрик) в дереве MODx и начать размещать вызовы сниппета easy_board. Этот снииппет отвечает за вывод доски объявлений на сайте, добавление новых и редактирования старых объявлений. Для всего этого у сниппета есть много разных параметров.

Параметры сниппета
------------------

http://www.xn--80ajr5b.com/2014/12/easy-board-doska-obyavlenijj-dlya-modx-evo/

История изменения версий
------------------------
1.02 (для обновления с предыдущей версии достаточно заменить файлы на сервере на новые и код сниппета)
* Изменена работа с выбором городов (городами теперь могут быть только дочерние документы одного уровня)
* Доработана работа сниппета с параметром &parent. Теперь в нем можно перечислять несколько идентификаторов документов
* Добавлен параметр &recursion. Если его установить &recursion=`1`, то поиск объявлений будет осуществляться и во всех дочерних рубриках от указанных в &parent
* Добавлен параметр &action=`count`. На месте вызова сниппета выведется количество объявлений. Учитываются остальные параметры для фильтрации объявлений
* Добавлена возможность вызова сниппета несколько раз на страницу
* Доработан языковой пакет

1.01
* Исправлена ошибка в политике доступа к созданию нового объявления
* Исправлена ошибка в модуле (при редактировании объявления удалялась фотография)
* Добавлена возможность вложенных рубрик
* Введен языковой пакет для мультиязычности
* Добавлена заглушка вместо изображения для объявлений без фотографии