$(document).ready(function() {
  $('input').iCheck({
    checkboxClass: 'icheckbox_square',
    radioClass: 'iradio_square',
    increaseArea: '20%'
  });

  $("#advanced-search-box").hide();

  $("#box-news").mouseover(function() {
    $("#box-news-title").css("color","#f1f1f1");
  });
  $("#box-news").mouseout(function() {
    $("#box-news-title").css("color","#212121");
  });

  $("#box-musics").mouseover(function() {
    $("#box-musics-title").css("color","#f1f1f1");
  });
  $("#box-musics").mouseout(function() {
    $("#box-musics-title").css("color","#212121");
  });

  $("#box-figures").mouseover(function() {
    $("#box-figures-title").css("color","#f1f1f1");
  });
  $("#box-figures").mouseout(function() {
    $("#box-figures-title").css("color","#212121");
  });

  $("#advanced-search-btn").click(function(e){
    e.preventDefault();
    $("#advanced-search-box").toggle("slow");
  });

  $(function() {
    var sishusearchresult = [
      "Get", "From", "aJax"
    ];

    $("#sishu-search-box").autocomplete({
      source: sishusearchresult
    });

    var musicsearchresult = [
      "Ya Tuhanku", "Terpujilah Namamu", "Damai Di Dunia"
    ];

    $("#music-search-box").autocomplete({
      source: musicsearchresult
    });
  });

  var musicbox = document.getElementById('musicbox');
  if (musicbox) {
    CKEDITOR.replace("musicbox", {
      language: 'id',
      enterMode: CKEDITOR.ENTER_BR
    });
  }

  var sishubox = document.getElementById('sishubox');
  if (sishubox) {
    CKEDITOR.replace("sishubox", {
      language: 'id',
      enterMode: CKEDITOR.ENTER_BR
    });
  }

});
