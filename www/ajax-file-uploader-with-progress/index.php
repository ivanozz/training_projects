<html>
<head>
<title>AJAX загрузка файлов с прелоадером</title>
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<style>
::-webkit-progress-bar {
    background: #999;
}
::-webkit-progress-value {
    background: #333;
}
::-moz-progress-bar {
    background: #333;
}
progress {
	display: block;
    color: red;
    background: #333;
    border: 2px solid #333;
    border-radius: 5px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    width: 300px;
    height: 25px;
    line-height: 21px;
    font-size: 15px;
    font-family: sans-serif;
    text-align: center;
}
</style>
</head>
<body>
<?php 
require_once(__DIR__.'\lib\\ReturnBytes.php');
$maxUpload = ReturnBytes(ini_get('upload_max_filesize'));
$maxPost = ReturnBytes(ini_get('post_max_size'));
$memoryLimit = ReturnBytes(ini_get('memory_limit'));
$maxFileSize = min($maxUpload, $maxPost, $memoryLimit);
?>
<form action="handler.php?processed=1" method="post" id="my_form" enctype="multipart/form-data">
	<!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $maxFileSize;?>" />
	<p>
		<label for="my_file">Файл:</label>
		<input type="file" name="my_file" id="my_file">
		<br />
		<br />
		<progress id="progressbar" value="0" max="100"></progress>
	</p>
  <input type="submit" id="submit" value="Отправить">
</form>
<script>
$(function(){
  var progressBar = $('#progressbar');
  $('#my_form').on('submit', function(e){
    e.preventDefault();
    var $that = $(this),
        formData = new FormData($that.get(0));
    $.ajax({
      url: $that.attr('action'),
      type: $that.attr('method'),
      contentType: false,
      processData: false,
      data: formData,
      dataType: 'json',
      xhr: function(){
        var xhr = $.ajaxSettings.xhr(); // получаем объект XMLHttpRequest
        xhr.upload.addEventListener('progress', function(evt){ // добавляем обработчик события progress (onprogress)
          if(evt.lengthComputable) { // если известно количество байт
            // высчитываем процент загруженного
            var percentComplete = Math.floor(evt.loaded / evt.total * 100);
            // устанавливаем значение в атрибут value тега <progress>
            // и это же значение альтернативным текстом для браузеров, не поддерживающих <progress>
            progressBar.val(percentComplete).text('Загружено ' + percentComplete + '%');
          }
        }, false);
        return xhr;
      },
      success: function(json){
        if(json){
          $that.after(json);
        }
      }
    });
  });
});
</script>
</body>
</html>