<!-- BEGIN: main -->
<link href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/star-rating/jquery.rating.css" type="text/css" rel="stylesheet"/>
<div class="row">
	<div class="detail_container col-xs-24 col-md-24 col-lg-24">
		<div class="page-header pd10_0 mg0_10_10">
			<h3 class="title">{DETAIL.title}</h3>
			<div class="row margin-top-lg">
				<span class="h5">{DETAIL.publtime}</span>
			</div>
		</div>
		<div class="detail_video">
			<div class="videoplayer">
				<!-- BEGIN: vid_jw_content -->
				<div id="videoCont">
					<img src="{NV_BASE_SITEURL}themes/default/images/{MODULE_NAME}/loading.gif" class="center-block mar_rgt_auto" alt="Loading player" />
				</div>
				<!-- END: vid_jw_content -->
			</div>
			<div class="clearfix"></div>
			<!-- BEGIN: socialbutton -->
			<div class="socialicon col-xs-12 col-md-12 col-lg-12 clearfix margin-bottom-lg margin-top-lg">
				<div class="fb-like" data-href="{SELFURL}" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">&nbsp;</div>
				<div class="g-plusone" data-size="medium"></div>
				<a href="http://twitter.com/share" class="twitter-share-button">Tweet</a>
			</div>
			<!-- END: socialbutton -->
			
			<div class="col-xs-12 col-md-12 col-lg-12 margin-top-lg">
				<div class="user_function pull-right">
					<label class="btn btn-default" data-toggle="tooltip" data-placement="top" title="{LANG.video_favorite}"><i class="fa fa-star"></i></label>&nbsp;&nbsp;<label class="btn btn-primary" data-toggle="collapse" data-target="#add_to_userlist"><i data-toggle="tooltip" data-placement="top" title="{LANG.playlist_add_video}" class="fa fa-plus-square"></i></label>
				</div>
				<div class="clearfix"></div>
				<div class="show_playlist collapse" id="add_to_userlist">
					<!-- BEGIN: user_playlist -->
					<label>{LANG.playlist_select}</label>
					<form id="add_to_playlist" action="">
						<select class="form-control form_60 pull-left" id="add_user_playlist">
							<option class="text-center" value="">---------</option>
							<!-- BEGIN: loop -->
							<option value="{USER_PLAYLIST.playlist_id}" {USER_PLAYLIST.disabled}>{USER_PLAYLIST.title}</option>
							<!-- END: loop -->
						</select>&nbsp;<label class="btn btn-primary col-md-5 margin-left-lg" onclick="nv_add_user_playlist('{DETAIL.id}','add_user_playlist');">{LANG.save}</label>
					</form>
					<!-- END: user_playlist -->
					
					<!-- BEGIN: user_create_newlist -->
					<div class="alert alert-info margin-bottom-lg margin-top-lg">{LANG.user_create_newlist}<a href="{NV_BASE_SITEURL}{MODULE_NAME}/{USERLIST_OPS}/" target="_blank">&nbsp;<label>&nbsp;<i class="fa fa-external-link-square">&nbsp;</i></label></a></div>
					<!-- END: user_create_newlist -->
					
					<!-- BEGIN: user_required -->
					<div class="alert alert-info margin-bottom-lg margin-top-lg">{LANG.user_required}<a href="#" onclick="return loginForm();">&nbsp;<label>&nbsp;<i class="fa fa-check-square">&nbsp;</i></label></a></div>
					<!-- END: user_required -->
				</div>	
			</div>
		</div>
		
		<!-- BEGIN: no_public -->
		<div class="alert alert-warning">
			{LANG.no_public}
		</div>
		<!-- END: no_public -->
		
		<!-- BEGIN: showhometext -->
		<div class="clearfix margin-bottom-lg">
            <div class="hometext">{DETAIL.hometext}</div>
		</div>
		<!-- END: showhometext -->
		<div class="panel panel-default bodytext_shorten">
			<div id="news-bodyhtml" class="bodytext panel-body margin-bottom-lg">
				{DETAIL.bodytext}
			</div>
		</div>
		<!-- BEGIN: author -->
        <div class="margin-bottom-lg">
    		<!-- BEGIN: name -->
    		<p class="h5 text-right">
    			<strong>{LANG.author}: </strong>{DETAIL.author}
    		</p>
    		<!-- END: name -->
    		<!-- BEGIN: source -->
    		<p class="h5 text-right">
    			<strong>{LANG.source}: </strong>{DETAIL.source}
    		</p>
    		<!-- END: source -->
        </div>
		<!-- END: author -->
		<!-- BEGIN: copyright -->
		<div class="alert alert-info margin-bottom-lg">
			{COPYRIGHT}
		</div>
		<!-- END: copyright -->
    </div>
</div>

<div class="news_column row">
<!-- BEGIN: keywords -->
	<div class="col-md-12">
        <div class="h5">
            <em class="fa fa-tags">&nbsp;</em><strong>{LANG.keywords}: </strong><!-- BEGIN: loop --><a title="{KEYWORD}" href="{LINK_KEYWORDS}"><em>{KEYWORD}</em></a>{SLASH}<!-- END: loop -->
        </div>
    </div>
<!-- END: keywords -->

<!-- BEGIN: allowed_rating -->
	<div class="col-md-12">
        <form id="form3B" action="">
            <div class="h5 clearfix">
                <p>{STRINGRATING}</p>
                <!-- BEGIN: data_rating -->
                <span itemscope itemtype="http://data-vocabulary.org/Review-aggregate">{LANG.rating_average}:
                    <span itemprop="rating">{DETAIL.numberrating}</span> -
                    <span itemprop="votes">{DETAIL.click_rating}</span> {LANG.rating_count}
                </span>
                <!-- END: data_rating -->
                <div style="padding: 5px;">
                    <input class="hover-star" type="radio" value="1" title="{LANGSTAR.verypoor}" /><input class="hover-star" type="radio" value="2" title="{LANGSTAR.poor}" /><input class="hover-star" type="radio" value="3" title="{LANGSTAR.ok}" /><input class="hover-star" type="radio" value="4" title="{LANGSTAR.good}" /><input class="hover-star" type="radio" value="5" title="{LANGSTAR.verygood}" /><span id="hover-test" style="margin: 0 0 0 20px;">{LANGSTAR.note}</span>
                </div>
            </div>
        </form>
	<script>
	$(function() {
		var sr = 0;
		$(".hover-star").rating({
			focus: function(b, c) {
				var a = $("#hover-test");
				2 != sr && (a[0].data = a[0].data || a.html(), a.html(c.title || "value: " + b), sr = 1)
			},
			blur: function(b, c) {
				var a = $("#hover-test");
				2 != sr && ($("#hover-test").html(a[0].data || ""), sr = 1)
			},
			callback: function(b, c) {
				1 == sr && (sr = 2, $(".hover-star").rating("disable"), sendrating("{NEWSID}", b, "{NEWSCHECKSS}"))
			}
		});
		$(".hover-star").rating("select", "{NUMBERRATING}");
		<!-- BEGIN: disablerating -->
		$(".hover-star").rating('disable');
		sr = 2;
		<!-- END: disablerating -->
	})
	</script>
	</div>
</div>
<!-- END: allowed_rating -->

<!-- BEGIN: adminlink -->
<p class="text-center margin-bottom-lg">
    {ADMINLINK}
</p>
<!-- END: adminlink -->

<!-- BEGIN: comment -->
<div class="row">
	<div class="comment_box">
	{CONTENT_COMMENT}
    </div>
</div>
<!-- END: comment -->

<!-- BEGIN: others -->
<div class="row">
	<div class="other-news">
        
    	<!-- BEGIN: related_new -->
    	<p class="h3"><strong>{LANG.related_new}</strong></p>
    	<div class="clearfix">
            <ul class="related">
        		<!-- BEGIN: loop -->
        		<li>
        			<em class="fa fa-angle-right">&nbsp;</em>
        			<a href="{RELATED_NEW.link}">{RELATED_NEW.title}</a>
        			<em>({RELATED_NEW.time})</em>
        			<!-- BEGIN: newday -->
        			<span class="icon_new">&nbsp;</span>
        			<!-- END: newday -->
        		</li>
        		<!-- END: loop -->
        	</ul>
        </div>
    	<!-- END: related_new -->
        
    	<!-- BEGIN: related -->
    	<p class="h3"><strong>{LANG.related}</strong></p>
    	<div class="clearfix">
            <ul class="related">
        		<!-- BEGIN: loop -->
        		<li>
        			<em class="fa fa-angle-right">&nbsp;</em>
        			<a class="list-inline" href="{RELATED.link}"<!-- BEGIN: tooltip --> data-placement="{TOOLTIP_POSITION}" data-content="{RELATED.hometext}" data-img="{RELATED.imghome}" data-rel="tooltip"<!-- END: tooltip -->>{RELATED.title}</a>
        			<em>({RELATED.time})</em>
        			<!-- BEGIN: newday -->
        			<span class="icon_new">&nbsp;</span>
        			<!-- END: newday -->
        		</li>
        		<!-- END: loop -->
        	</ul>
        </div>
    	<!-- END: related -->
    </div>
</div>
<!-- END: others -->

<!-- BEGIN: jwplayer -->
<script type="text/javascript" src="{NV_BASE_SITEURL}themes/default/modules/{MODULE_NAME}/jwplayer/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="{VIDEO_CONFIG.jwplayer_license}";</script>
<script type="text/javascript">
var playerInstance = jwplayer("videoCont");
playerInstance.setup({
	image: "{DETAIL.image.src}",
	autostart: {VIDEO_CONFIG.jwplayer_autoplay},
	aspectratio: "16:9",
	controls: {VIDEO_CONFIG.jwplayer_controlbar},
	displaydescription: true,
	playlist: "{NV_BASE_SITEURL}{MODULE_NAME}/player/{RAND_SS}{DETAIL.fake_pl_id}-{DETAIL.newscheckss}-{RAND_SS}{DETAIL.id}/",
	displaytitle: true,
	flashplayer: "{NV_BASE_SITEURL}themes/default/modules/{MODULE_NAME}/jwplayer/jwplayer.flash.swf",
	primary: "html5",
	repeat: {VIDEO_CONFIG.jwplayer_loop},
	mute: {VIDEO_CONFIG.jwplayer_mute},
	<!-- BEGIN: player_logo -->
	logo: {
		file: '{VIDEO_CONFIG.jwplayer_logo_file}',
		link: '{NV_MY_DOMAIN}'
	},
	<!-- END: player_logo -->
	skin: {"name": "stormtrooper"},
	stagevideo: false,
	stretching: "uniform",
	visualplaylist: true,
	width: "100%"
  });
</script>
<!-- END: jwplayer -->
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/star-rating/jquery.rating.pack.js"></script>
<script src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/star-rating/jquery.MetaData.js" type="text/javascript"></script>
<script src="{NV_BASE_SITEURL}themes/default/js/videos_shorten.js" type="text/javascript"></script>
<script language="javascript">
$(document).ready(function() {
	$(".bodytext_shorten").shorten({showChars: 200});
    $('[data-toggle="tooltip"]').tooltip();   
});
var load_more_text = "{LANG.video_more_text}";
var load_less_text = "{LANG.video_less_text}";
</script>
</script>
<!-- END: main -->

<!-- BEGIN: no_permission -->
<div class="alert alert-info">
	{NO_PERMISSION}
</div>
<!-- END: no_permission -->