function loadJS(src){
  var script = document.createElement('script');
  script.src = src;
  document.body.appendChild(script);
}
function searchText(target, cat){
  let kw = $(target).val();
  if(kw == ''){
    return;
  }
  if(cat != ''){
    //loadJS(unisuggest+'?kw='+kw+'fq_category='+cat+'&wt=jsonp&cbk=searchTextCb');
    var apiUrl = unisuggest+'?kw='+kw+'&fq_category='+cat+'&wt=jsonp&cbk=callback';
  }else{
    //loadJS(unisuggest+'?kw='+kw+'&wt=jsonp&cbk=searchTextCb');
    var apiUrl = unisuggest+'?kw='+kw+'&wt=jsonp&cbk=callback';
  }
  $.ajax({
    url: apiUrl,
    type: 'GET',
    dataType: 'jsonp',
    jsonpCallback: 'callback'
  })
  .done(function(data){
    let item_word = [];
    if(data.response.numFound != 0){
      data.response.keyword.docs.item.forEach(element => {
        item_word.push(element.word);
      });
    }
    $(target).autocomplete({
      source: item_word,
      minLength: 0
    });
    $(target).autocomplete("search","");
  });
}
$(document).ready(function() {
  $('#product_search_text').keyup(function(e){
    searchText(e.target, $("#product_search_category").val());
  });
  $('#header_search_text').keyup(function(e){
    searchText(e.target, $("#header_search_category").val());
  });
  $('#header_search_text_sp').keyup(function(e){
    searchText(e.target, $("#header_search_category").val());
  });
  $('#search_rows').change(function(e){
    $("#product_search_form_rows").val($(e.target).val());
    $("#product_search_form").submit();
  });
});