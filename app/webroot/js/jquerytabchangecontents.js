$(function(){

//アニメーション速度設定
	var Speed = "200";

//対象要素設定
	var Tab = "#tabchange li a";
	var TabContents = "#tabchangeContents div.tabchangeBox";
	var ActiveClass = "activeBox";

//初期表示設定
	$(Tab+":eq(0)").addClass(ActiveClass);
	$(TabContents).hide();
	$(TabContents+":eq(0)").show();

//クリックイベント
	$(Tab).click(
		function(){
			var Index = $(Tab).index(this);
			$(Tab).not(this).removeClass(ActiveClass);
			$(this).addClass(ActiveClass);
			$(TabContents).not(TabContents+":eq("+Index+")").slideUp(Speed,function(){
				$(TabContents+":eq("+Index+"):not(:animated)").slideDown(Speed);
			});
			return false;
		}
	);

});