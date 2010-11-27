<?php echo View::factory('element/menu',array('select'=>array('controller'=>'home','action'=>'manual')))?>
<div id="content">
<a name="oglava"></a>
<h2>Оглавление:</h2>
<div class="oglava">
<a class="first" href="#chapter1">В каких ситуациях может понадобится</a><br/>

<a href="#chapter2"  class="first">Использование</a><br/>
	<a href="#chapter21" class="second">Перенаправим все запросы к изображениям на php скрипт</a><br/>
	<a href="#chapter22" class="second">Определяем логику обработки изображения</a><br/>
	<a href="#chapter23" class="second">Параметры передаваемые в конструктор new PhpResizer()</a><br/>
<a href="#chapter3" class="first">Очиста кеша</a><br/>
<a href="#chapter4" class="first">Вопрос - ответ</a>
</div>


<br/><br/>
<a name="chapter1"></a>
<h1>В каких ситуациях может понадобится:</h1>
<p>
	&#8658; Нам нужны уменьшенные копии какого-то изображения, например для двух размеров аватарак, предпросмотра картинки.</li>
</p>
<p>	
	&#8658; Наш дизайн имеет резиновую вёрстку и для пользователей с разными разрешениями мониторов мы хотим показывать изображение с разным разрешением</li>
</p>
<p>
	&#8658; Мы хотим контролировать доступ к изображениям, разрешать одним и запрещать другим</li>
</p>
<p>
	&#8658; Мы хотим гибко управлять нашими уменьшенными копиями: изменять размеры, соотношение сторон, увеличивать центральную часть (при использовании движка ImageMagick или GraphicsMagick можно будет управлять фильтрами, резкостью, размытостью, цветами, яркостью и т.д.) </li>
</p>
	

<a href="#oglava" class="oglava">К оглавлению.</a> <br/><br/>




<a name="chapter2"></a>
<h1>Использование</h1>
<a name="chapter21"></a>
<h4>Перенаправим все запросы к изображениям на php скрипт</h4>
Для этого при использовании сервера Apache внесём изменения в .htaccess файл.

<div class="code">
<span class="file">.htaccess</span>
<code>
	&lt;IfModule mod_rewrite.c> <br/>
	    RewriteEngine On <br/>
	<br/>
		#все запросы заканчивающиеся на .jpg .bmp .gif .png<br/> 
		#перенаправляем на файл images.php<br/> 
	    RewriteCond %{REQUEST_URI} (.*\.)(jpg|bmp|gif|png)$ [NC]<br/>
	    RewriteRule ^(.*\.)(jpg|bmp|gif|png)$ images.php?file=$1$2 [QSA,NC,S,L]<br/>
	<br/>
		#все другие запросы обрабатываем как и раньше попадают в index.php<br/> 
	    RewriteCond %{REQUEST_FILENAME} !-d<br/>
	    RewriteCond %{REQUEST_FILENAME} !-f<br/>
	    RewriteCond %{REQUEST_URI} !images.php(.*) [NC]<br/>
	    RewriteRule ^(.*)$ index.php?url=$1 [QSA]<br/>
	&lt;/IfModule><br/>
</code>
</div>
<p>В место:<br/>
<u>http://example.com/testimage.jpg</u> <br/> 
получаем:<br/>
<u>http://example.com/images.php?file=testimage.jpg</u>
<br/><br/>

А в место:<br/>
<u>http://example.com/testimage.jpg?type=avatar</u><br/> 
получаем:<br/> 
<u>http://example.com/images.php?file=testimage.jpg&type=avatar</u>
</p>
<p>
<i>Примечание: для обработки изображний можно использовать какой-нибудь метод контроллера вашего фремворка, но делать это не рекомендую из-за не нужной дополнительной нагрузки на сервер</i>
</p> 
 

<a name="chapter22"></a>
<h4>Определяем логику обработки изображения</h4>
<div class="code">
<span class="file">images.php</span>

<pre>
<code>
<?php
echo htmlspecialchars('<?php

$file = (isset($_GET["file"])) ? $_GET["file"] : ""; 

$options = array (
    "avatar"=>array(
        "width"=>100, // желаемая ширина аватарки
        "height"=>100, // желаемая высота аватарки
        /* пропорции не сохраняем, 
           если исходное изображение будет прямоугольником то 
           подрежим выступающие края до квадрата */
        "aspect"=>false,
        //возьмём от всего изображения 95% и увеличим этот фрагмент до наших 100х100 px 
        "crop"=>95, 
    ),
        // настройки для генерации предпросмотра изображения
    "preview"=>array(
        "width"=>400,
        "height"=>500,
        "aspect"=>true,
        "crop"=>100,
    )
);

if (isset($_GET["type"]) AND isset($options[$_GET["type"]])) {
    $opt =  $options[$_GET["type"]];
}else{
    $opt = array();
}

/*
На этом этапе, при необходимости, проверяем разрешено ли пользователю 
просматривать изображение. В данном примере это пропущено.   
*/


require "/PhpResizer/Autoloader.php";
new PhpResizer_Autoloader(); 

try {
	$resizer = new PhpResizer_PhpResizer(array (
		"engine"=>PhpResizer_PhpResizer::ENGINE_IMAGEMAGICK,
		"cache"=>true,
		"cacheDir"=>dirname(__FILE__)."/cache/",
		"cacheBrowser"=>true,
		)
	);
    // Выполняем ужатие изображение.
    // Третий параметр отвечает за то чтоб отдавать нам только абсолютный путь к ужатому файлу (true)
    // или вернуть изображение в браузер
    // а абсолютный путь к ужатому изображению
    // здесь следовало бы поставить true 
	$resizer->resize(dirname(__FILE__)."/".$file, $opt, false);
}catch(Exception $e) {
	echo $e->getMessage();
}'); 
?> 
</code>
</pre>
</div>

<a name="chapter23"></a>
<h4>Параметры передаваемые в конструктор new PhpResizer_PhpResizer()</h4>
<ul>
<li>
<b>engine</b> - движок используемый для ужатия. Доступные значения: 
	<ul>
		<li>PhpResizer_PhpResizer::ENGINE_GD2 (выбрано по умолчанию)- <a href="http://www.php.net/manual/en/book.image.php">GD (Graphics Draw) library</a></li>
		<li>PhpResizer_PhpResizer::ENGINE_IMAGEMAGICK - <a href="http://www.imagemagick.org">ImageMagick</a></li>
		<li>PhpResizer_PhpResizer::ENGINE_GRAPHIKSMAGICK - <a href="http://www.graphicsmagick.org/">GraphicsMagick</a></li>
	</ul>   
</li>

<li><b>cache</b> - управление кешированием ужатых изображений на сервере. Допустимые значения: <b>true</b>|<b>false</b>
по умочанию <b>true</b>
</li>

<li><b>cacheDir</b> - абсолютный путь к папке где будут храниться закешированные ужатые файлы. По умочанию /tmp/resizerCache/
</li>

<li><b>cacheBrowser</b> - управление кеширования ужатых изображений в клиентском браузере. Допустимые значения: <b>true</b>|<b>false</b>
</li>
</ul>
<a href="#oglava" class="oglava">К оглавлению.</a><br/><br/><br/>




<a name="chapter3"></a>
<h1>Очиста кеша</h1>
<p>В данном примере мы удаляем из папки  "/var/www/resizer/cache/" все файлы к которым никто не обращался уже целую неделю.
(<u>Внимание!!!</u>, не ошибись с путём к папке) 
</p>

<div class="code">
	<code>
	<?php echo nl2br(htmlspecialchars('<?php
    $resizer = new PhpResizer_PhpResizer(array (
        "cacheDir"=>"/var/www/resizer/cache/"
    )
    );
    $resizer->clearCache(60*24*7);'))?>
	</code>
</div>
<a href="#oglava" class="oglava">К оглавлению.</a><br/><br/><br/>


<a name="chapter4"></a>
<h1>Вопрос - ответ</h1>
<h4>Хочу что изображения сервер отдавал непосредственно, а не через через php-скрипт?</h4>

<p>
Нам понадобится небольшой класс - ImageHelper, на входе метод получает путь к файлу - оригиналу, 
и параметр определяющий настройки пережатия. 
В Хелпере используя библиотеку PhpResizer выполняем пережатие изображения, в метод  resize не забываем передать третий параметр <b>true</b>
С таким параметром библиотека вернёт абсолютный путь к файлу в кеше например /var/www/site/design/images/PhpResizerCache/4k/33sdfsdf4wesd34rsf43.jpg 
Используя функции обработки строк превращаем /var/www/site/design/images/PhpResizerCache/4k/33sdfsdf4wesd34rsf43.jpg в нечто похожее на http://example.com/design/images/PhpResizerCache/4k/33sdfsdf4wesd34rsf43.jpg
У этого способа есть недостаток: мы не можем контролировать доступ к ужатым изображения пользователей.
</p>

<p>Вот так выглядело бы использование хелпера при генерации содержимого страницы:</p> 
<div class="code">
	<code>
	<?php echo str_replace(array(' ',"\t","<","\n"), array('&nbsp;','    ','&lt;','<br/>'),'
	<img src="<?php echo ImageHelper::resize("user134.jpg","avatar"); ?>" alt="фотография"/>
	')?>
	</code>
</div>


<p>Вот что увидет пользователь:</p>
<div class="code">
	<code>
	<?php echo str_replace(array(' ',"\t","<","\n"), array('&nbsp;','    ','&lt;','<br/>'),'
	<img src="http://example.com/design/images/as/sd5fs3df4d34ssf4gf435o.jpg" alt="моя фотография"/>
	')?>
	</code>
</div>

<h4>Я не хочу заставлять пользователя ждать пока PhpResizer выполнит пережатия изображения.</h4>
<p>
Здесь на помощь придёт <a href="http://ru.wikipedia.org/wiki/Crontab">crontab</a> 
Сразу как только появляется изображение для которого неминуемо придётся сгенерировать несколько вариантов, 
мы добавляем задачу в какой-нибудь стек, очередь. 
Раз в минуту crontab будет проверять не появилось ли что в очереди, 
и если появилось запустится скрипт в котором мы и создадим все необходимые файлы в кеше. 
Когда пользователь обратится за ужатым файлом, он уже будет подготовлен и лежать в кеше.      
</p>
<a href="#oglava" class="oglava">К оглавлению.</a><br/><br/><br/>

</div>

