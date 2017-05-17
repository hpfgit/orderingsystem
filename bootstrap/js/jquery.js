(function($){
  $.fn.secondmenu = function(){
    return this.each(function(index){
      var me = $(this),
            index = me.index(),
            outerlayer  = $(".outerlayer").eq(index),
            innerlayert = outerlayer.find(".innerlayert");

    });
  };
})(jQuery);
$(".function-li").click(function () {
    var funcbox = $(".function-box"),
          list = funcbox.find(".user-list"),
          user = funcbox.find(".user-function");
    funcbox.toggle();
    user.toggle();
    if (user.css('display') == 'none') {
        list.hide();
    }
    user.click(function () {
        list.toggle();
    });
    list.click(function () {
        $("#order").show();
    });
});