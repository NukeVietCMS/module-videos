<?php

/**
 * @Project VIDEOS 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Website tradacongnghe.com
 * @License GNU/GPL version 2 or any later version
 * @Createdate Oct 08, 2015 10:47:41 AM
 */

if( ! defined( 'NV_IS_MOD_VIDEOS' ) ) die( 'Stop!!!' );

function viewcat_grid_new( $array_catpage, $catid, $generate_page )
{
	global $module_name, $module_file, $module_upload, $lang_module, $module_config, $module_info, $global_array_cat, $global_array_cat, $catid, $page;

	$xtpl = new XTemplate( 'viewcat_grid.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'IMGWIDTH1', $module_config[$module_name]['homewidth'] );
	$xtpl->assign( 'VID_HEIGHT', $module_config[$module_name]['homeheight'] );
	$xtpl->assign( 'TOOLTIP_POSITION', $module_config[$module_name]['showtooltip'] ? $module_config[$module_name]['tooltip_position'] : '' );

	if( ( $global_array_cat[$catid]['viewdescription'] and $page == 1 ) or $global_array_cat[$catid]['viewdescription'] == 2 )
	{
		$xtpl->assign( 'CONTENT', $global_array_cat[$catid] );
		if( $global_array_cat[$catid]['image'] )
		{
			$xtpl->assign( 'HOMEIMG1', NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/img/' . $global_array_cat[$catid]['image'] );
			$xtpl->parse( 'main.viewdescription.image' );
		}
		$xtpl->parse( 'main.viewdescription' );
	}

	if( ! empty( $catid ) )
	{
		$xtpl->assign( 'CAT', $global_array_cat[$catid] );
		$xtpl->parse( 'main.cattitle' );
	}

	foreach( $array_catpage as $array_row_i )
	{
		$newday = $array_row_i['publtime'] + ( 86400 * $array_row_i['newday'] );
		$array_row_i['publtime'] = nv_date( 'd/m/Y h:i:s A', $array_row_i['publtime'] );

		$xtpl->clear_autoreset();
		$array_row_i['hometext_clean'] = nv_clean60( $array_row_i['hometext'], $module_config[$module_name]['tooltip_length'], true );
		$xtpl->assign( 'CONTENT', $array_row_i );

		if( defined( 'NV_IS_MODADMIN' ) )
		{
			$xtpl->assign( 'ADMINLINK', nv_link_edit_page( $array_row_i['id'] ) . " " . nv_link_delete_page( $array_row_i['id'] ) );
			$xtpl->parse( 'main.viewcatloop.adminlink' );
		}

		if( $array_row_i['imghome'] != '' )
		{
			$xtpl->assign( 'HOMEIMG1', $array_row_i['imghome'] );
			$xtpl->assign( 'HOMEIMGALT1', ! empty( $array_row_i['homeimgalt'] ) ? $array_row_i['homeimgalt'] : $array_row_i['title'] );
			$xtpl->parse( 'main.viewcatloop.image' );
		}

		if( $newday >= NV_CURRENTTIME )
		{
			$xtpl->parse( 'main.viewcatloop.newday' );
		}

		$xtpl->set_autoreset();
		$xtpl->parse( 'main.viewcatloop' );
		
	}

	if( ! empty( $generate_page ) )
	{
		$xtpl->assign( 'GENERATE_PAGE', $generate_page );
		$xtpl->parse( 'main.generate_page' );
	}

	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function viewcat_page_new( $array_catpage, $array_cat_other, $generate_page )
{
	global $global_array_cat, $module_name, $module_file, $module_upload, $lang_module, $module_config, $module_info, $global_array_cat, $catid, $page;

	$xtpl = new XTemplate( 'viewcat_page.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'IMGWIDTH1', $module_config[$module_name]['homewidth'] );

	if( ( $global_array_cat[$catid]['viewdescription'] and $page == 1 ) or $global_array_cat[$catid]['viewdescription'] == 2 )
	{
		$xtpl->assign( 'CONTENT', $global_array_cat[$catid] );
		if( $global_array_cat[$catid]['image'] )
		{
			$xtpl->assign( 'HOMEIMG1', NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/img/' . $global_array_cat[$catid]['image'] );
			$xtpl->parse( 'main.viewdescription.image' );
		}
		$xtpl->parse( 'main.viewdescription' );
	}

	foreach( $array_catpage as $array_row_i )
	{
		$newday = $array_row_i['publtime'] + ( 86400 * $array_row_i['newday'] );
		$array_row_i['publtime'] = nv_date( 'd/m/Y h:i:s A', $array_row_i['publtime'] );
		$array_row_i['listcatid'] = explode( ',', $array_row_i['listcatid'] );
		$num_cat = sizeof( $array_row_i['listcatid'] );

		$n = 1;
		foreach( $array_row_i['listcatid'] as $listcatid )
		{
			$listcat = array( 'title' => $global_array_cat[$listcatid]['title'], "link" => $global_array_cat[$listcatid]['link'] );
			$xtpl->assign( 'CAT', $listcat );
			( ( $n < $num_cat ) ? $xtpl->parse( 'main.viewcatloop.cat.comma' ) : '' );
			$xtpl->parse( 'main.viewcatloop.cat' );
			++$n;
		}
		$xtpl->clear_autoreset();
		$xtpl->assign( 'CONTENT', $array_row_i );

		if( defined( 'NV_IS_MODADMIN' ) )
		{
			$xtpl->assign( 'ADMINLINK', nv_link_edit_page( $array_row_i['id'] ) . " " . nv_link_delete_page( $array_row_i['id'] ) );
			$xtpl->parse( 'main.viewcatloop.news.adminlink' );
		}

		if( $array_row_i['imghome'] != '' )
		{
			$xtpl->assign( 'HOMEIMG1', $array_row_i['imghome'] );
			$xtpl->assign( 'HOMEIMGALT1', ! empty( $array_row_i['homeimgalt'] ) ? $array_row_i['homeimgalt'] : $array_row_i['title'] );
			$xtpl->parse( 'main.viewcatloop.news.image' );
		}

		if( $newday >= NV_CURRENTTIME )
		{
			$xtpl->parse( 'main.viewcatloop.news.newday' );
		}

		$xtpl->set_autoreset();
		$xtpl->parse( 'main.viewcatloop.news' );
	}
	$xtpl->parse( 'main.viewcatloop' );

	if( ! empty( $array_cat_other ) )
	{
		$xtpl->assign( 'ORTHERNEWS', $lang_module['other'] );

		foreach( $array_cat_other as $array_row_i )
		{
			$newday = $array_row_i['publtime'] + ( 86400 * $array_row_i['newday'] );
			$array_row_i['publtime'] = nv_date( "d/m/Y", $array_row_i['publtime'] );
			$xtpl->assign( 'RELATED', $array_row_i );
			if( $newday >= NV_CURRENTTIME )
			{
				$xtpl->parse( 'main.related.loop.newday' );
			}
			$xtpl->parse( 'main.related.loop' );
		}

		$xtpl->parse( 'main.related' );
	}

	if( ! empty( $generate_page ) )
	{
		$xtpl->assign( 'GENERATE_PAGE', $generate_page );
		$xtpl->parse( 'main.generate_page' );
	}

	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function viewsubcat_main( $viewcat, $array_cat )
{
	global $module_name, $module_file, $global_array_cat, $lang_module, $module_config, $module_info;

	$xtpl = new XTemplate( $viewcat . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'TOOLTIP_POSITION', $module_config[$module_name]['showtooltip'] ? $module_config[$module_name]['tooltip_position'] : '' );

	// Hien thi cac chu de con
	foreach( $array_cat as $key => $array_row_i )
	{
		if( isset( $array_cat[$key]['content'] ) )
		{
			$array_row_i['rss'] = NV_BASE_SITEURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=" . $module_info['alias']['rss'] . "/" . $array_row_i['alias'];
			$xtpl->assign( 'CAT', $array_row_i );
			$catid = intval( $array_row_i['catid'] );

			if( $array_row_i['subcatid'] != '' )
			{
				$_arr_subcat = explode( ',', $array_row_i['subcatid'] );
				foreach( $_arr_subcat as $catid_i )
				{
					if( $global_array_cat[$catid_i]['inhome'] == 1 )
					{
						$xtpl->assign( 'SUBCAT', $global_array_cat[$catid_i] );
						$xtpl->parse( 'main.listcat.subcatloop' );
					}
				}
			}

			$xtpl->assign( 'IMGWIDTH', $module_config[$module_name]['homewidth'] );

			foreach( $array_cat[$key]['content'] as $array_row_i )
			{
				$newday = $array_row_i['publtime'] + ( 86400 * $array_row_i['newday'] );
				$array_row_i['publtime'] = nv_date( 'd/m/Y H:i', $array_row_i['publtime'] );

				if( $newday >= NV_CURRENTTIME )
				{
					$xtpl->parse( 'main.listcat.loop.newday' );
				}
				$xtpl->assign( 'CONTENT', $array_row_i );

				if( $array_row_i['imghome'] != "" )
				{
					$xtpl->assign( 'HOMEIMG', $array_row_i['imghome'] );
					$xtpl->assign( 'HOMEIMGALT', ! empty( $array_row_i['homeimgalt'] ) ? $array_row_i['homeimgalt'] : $array_row_i['title'] );
					$xtpl->parse( 'main.listcat.loop.image' );
				}

				if( defined( 'NV_IS_MODADMIN' ) )
				{
					$xtpl->assign( 'ADMINLINK', nv_link_edit_page( $array_row_i['id'] ) . " " . nv_link_delete_page( $array_row_i['id'] ) );
					$xtpl->parse( 'main.listcat.loop.adminlink' );
				}

				$xtpl->set_autoreset();
				$xtpl->parse( 'main.listcat.loop' );
			}
			$xtpl->parse( 'main.listcat' );
		}
	}

	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function detail_theme( $news_contents, $href_vid, $array_keyword, $related_new_array, $related_array, $playlist_array, $content_comment, $array_user_playlist )
{
	global $global_config, $module_info, $lang_module, $module_name, $module_file, $module_config, $lang_global, $user_info, $admin_info, $client_info;

	$xtpl = new XTemplate( 'detail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG_GLOBAL', $lang_global );
	$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
	$xtpl->assign( 'TEMPLATE', $global_config['module_theme'] );
	$xtpl->assign( 'MODULE_NAME', $module_name );
	$xtpl->assign( 'LANG', $lang_module );

	$news_contents['addtime'] = nv_date( 'd/m/Y h:i:s', $news_contents['addtime'] );
	$xtpl->assign( 'RAND_SS', rand(1000,9999) );
	$xtpl->assign( 'NEWSID', $news_contents['id'] );
	$xtpl->assign( 'NEWSCHECKSS', $news_contents['newscheckss'] );
	$xtpl->assign( 'DETAIL', $news_contents );
	$xtpl->assign( 'SELFURL', $client_info['selfurl'] );
	$xtpl->assign( 'USERLIST_OPS',  $module_info['alias']['user-playlist'] );
	if( !empty($module_config[$module_name]['jwplayer_logo_file']) and file_exists( NV_ROOTDIR .'/'. $module_config[$module_name]['jwplayer_logo_file'] ) )
	{
		$lu = strlen( NV_BASE_SITEURL );
		$module_config[$module_name]['jwplayer_logo_file'] = NV_BASE_SITEURL . $module_config[$module_name]['jwplayer_logo_file'];
	}

	$xtpl->assign( 'VIDEO_CONFIG', $module_config[$module_name] );

	if( $news_contents['allowed_send'] == 1 )
	{
		$xtpl->assign( 'URL_SENDMAIL', $news_contents['url_sendmail'] );
		$xtpl->parse( 'main.allowed_send' );
	}
	if( !empty($href_vid) )
	{
		if(  $module_config[$module_name]['jwplayer_logo'] > 0 and !empty($module_config[$module_name]['jwplayer_logo_file']))
		{				
			$xtpl->parse( 'main.jwplayer.player_logo' );
		}

		$xtpl->parse( 'main.jwplayer' );
		$xtpl->parse( 'main.vid_jw_content' );
	}
	
	if( $news_contents['allowed_print'] == 1 )
	{
		$xtpl->assign( 'URL_PRINT', $news_contents['url_print'] );
		$xtpl->parse( 'main.allowed_print' );
	}

	if( $news_contents['allowed_save'] == 1 )
	{
		$xtpl->assign( 'URL_SAVEFILE', $news_contents['url_savefile'] );
		$xtpl->parse( 'main.allowed_save' );
	}

	if( $news_contents['allowed_rating'] == 1 )
	{
		$xtpl->assign( 'LANGSTAR', $news_contents['langstar'] );
		$xtpl->assign( 'STRINGRATING', $news_contents['stringrating'] );
		$xtpl->assign( 'NUMBERRATING', $news_contents['numberrating'] );

		if( $news_contents['disablerating'] == 1 )
		{
			$xtpl->parse( 'main.allowed_rating.disablerating' );
		}

		if( $news_contents['numberrating'] >= $module_config[$module_name]['allowed_rating_point'] )
		{
			$xtpl->parse( 'main.allowed_rating.data_rating' );
		}

		$xtpl->parse( 'main.allowed_rating' );
	}

	if( $news_contents['showhometext'] )
	{
		if( ! empty( $news_contents['image']['src'] ) )
		{
			if( $news_contents['image']['position'] == 1 )
			{
				if( ! empty( $news_contents['image']['note'] ) )
				{
					$xtpl->parse( 'main.showhometext.imgthumb.note' );
				}
				else
				{
					$xtpl->parse( 'main.showhometext.imgthumb.empty' );
				}
				$xtpl->parse( 'main.showhometext.imgthumb' );
			}
			elseif( $news_contents['image']['position'] == 2 )
			{
				if( ! empty( $news_contents['image']['note'] ) )
				{
					$xtpl->parse( 'main.showhometext.imgfull.note' );
				}
				$xtpl->parse( 'main.showhometext.imgfull' );
			}
		}

		$xtpl->parse( 'main.showhometext' );
	}
	if( ! empty( $news_contents['post_name'] ) )
	{
		$xtpl->parse( 'main.post_name' );
	}

	if( ! empty( $news_contents['author'] ) or ! empty( $news_contents['source'] ) )
	{
		if( ! empty( $news_contents['author'] ) )
		{
			$xtpl->parse( 'main.author.name' );
		}

		if( ! empty( $news_contents['source'] ) )
		{
			$xtpl->parse( 'main.author.source' );
		}

		$xtpl->parse( 'main.author' );
	}
	if( $news_contents['copyright'] == 1 )
	{
		if( ! empty( $module_config[$module_name]['copyright'] ) )
		{
			$xtpl->assign( 'COPYRIGHT', $module_config[$module_name]['copyright'] );
			$xtpl->parse( 'main.copyright' );
		}
	}

	if( ! empty( $array_keyword ) )
	{
		$t = sizeof( $array_keyword ) - 1;
		foreach( $array_keyword as $i => $value )
		{
			$xtpl->assign( 'KEYWORD', $value['keyword'] );
			$xtpl->assign( 'LINK_KEYWORDS', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=tag/' . urlencode( $value['alias'] ) );
			$xtpl->assign( 'SLASH', ( $t == $i ) ? '' : ', ' );
			$xtpl->parse( 'main.keywords.loop' );
		}
		$xtpl->parse( 'main.keywords' );
	}

	if( defined( 'NV_IS_MODADMIN' ) )
	{
		$xtpl->assign( 'ADMINLINK', nv_link_edit_page( $news_contents['id'] ) . ' ' . nv_link_delete_page( $news_contents['id'], 1 ) );
		$xtpl->parse( 'main.adminlink' );
	}

	if( $module_config[$module_name]['socialbutton'] )
	{
		global $meta_property;

		if( ! empty( $module_config[$module_name]['facebookappid'] ) )
		{
			$meta_property['fb:app_id'] = $module_config[$module_name]['facebookappid'];
			$meta_property['og:locale'] = ( NV_LANG_DATA == 'vi' ) ? 'vi_VN' : 'en_US';
		}
		$xtpl->parse( 'main.socialbutton' );
	}

	if( ! empty( $related_new_array ) or ! empty( $related_array ) or ! empty( $playlist_array ) )
	{
		if( ! empty( $related_new_array ) )
		{
			foreach( $related_new_array as $key => $related_new_array_i )
			{
				$related_new_array_i['hometext'] = nv_clean60( $related_new_array_i['hometext'], $module_config[$module_name]['tooltip_length'], true );
				$newday = $related_new_array_i['time'] + ( 86400 * $related_new_array_i['newday'] );
				if( $newday >= NV_CURRENTTIME )
				{
					$xtpl->parse( 'main.others.related_new.loop.newday' );
				}
				$related_new_array_i['time'] = nv_date( 'd/m/Y', $related_new_array_i['time'] );
				$xtpl->assign( 'RELATED_NEW', $related_new_array_i );
				if( ! empty( $module_config[$module_name]['showtooltip'] ) ) $xtpl->parse( 'main.others.related_new.loop.tooltip' );
				$xtpl->parse( 'main.others.related_new.loop' );
			}
			unset( $key );
			$xtpl->parse( 'main.others.related_new' );
		}

		if( ! empty( $related_array ) )
		{
			foreach( $related_array as $related_array_i )
			{
				$related_array_i['hometext'] = nv_clean60( $related_array_i['hometext'], $module_config[$module_name]['tooltip_length'], true );
				$newday = $related_array_i['time'] + ( 86400 * $related_array_i['newday'] );
				if( $newday >= NV_CURRENTTIME )
				{
					$xtpl->parse( 'main.others.related.loop.newday' );
				}
				$related_array_i['time'] = nv_date( 'd/m/Y', $related_array_i['time'] );
				$xtpl->assign( 'RELATED', $related_array_i );
				if( ! empty( $module_config[$module_name]['showtooltip'] ) ) $xtpl->parse( 'main.others.related.loop.tooltip' );
				$xtpl->parse( 'main.others.related.loop' );
			}
			$xtpl->parse( 'main.others.related' );
		}

		if( ! empty( $playlist_array ) )
		{
			foreach( $playlist_array as $key => $playlist_array_i )
			{
				$playlist_array_i['hometext'] = nv_clean60( $playlist_array_i['hometext'], $module_config[$module_name]['tooltip_length'], true );
				$newday = $playlist_array_i['time'] + ( 86400 * $playlist_array_i['newday'] );
				if( $newday >= NV_CURRENTTIME )
				{
					$xtpl->parse( 'main.others.playlist.loop.newday' );
				}
				$playlist_array_i['time'] = nv_date( 'd/m/Y', $playlist_array_i['time'] );
				$xtpl->assign( 'PLAYLIST', $playlist_array_i );
				if( ! empty( $module_config[$module_name]['showtooltip'] ) ) $xtpl->parse( 'main.others.playlist.loop.tooltip' );
				$xtpl->parse( 'main.others.playlist.loop' );
			}
			$xtpl->parse( 'main.others.playlist' );
		}
        
        $xtpl->parse( 'main.others' );
	}

	if( ! empty( $array_user_playlist ) )
	{
		foreach($array_user_playlist as $array_user_playlist_i)
		{
			$xtpl->assign( 'USER_PLAYLIST', $array_user_playlist_i );
			$xtpl->parse( 'main.user_playlist.loop' );
		}
		$xtpl->parse( 'main.user_playlist' );
	}
	elseif( $user_info['userid'] > 0 )
	{
		$xtpl->parse( 'main.user_create_newlist' );
	}
	else
	{
		$xtpl->parse( 'main.user_required' );
	}
	
	if( ! empty( $content_comment ) )
	{
		$xtpl->assign( 'CONTENT_COMMENT', $content_comment );
		$xtpl->parse( 'main.comment' );
	}

	if( $news_contents['status'] != 1 )
	{
		$xtpl->parse( 'main.no_public' );
	}

	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function no_permission()
{
	global $module_info, $module_file, $lang_module;

	$xtpl = new XTemplate( 'detail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );

	$xtpl->assign( 'NO_PERMISSION', $lang_module['no_permission'] );
	$xtpl->parse( 'no_permission' );
	return $xtpl->text( 'no_permission' );
}

function playlist_theme( $playlist_array, $playlist_other_array, $generate_page, $playlist_info, $playlist_id, $pl_ss )
{
	global $lang_module, $module_info, $module_name, $module_file, $playlistalias, $module_config;

	$xtpl = new XTemplate( 'playlist.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'PLAYLIST_TITLE', $page_title );
	$xtpl->assign( 'RAND_SS', rand(1000,9999) );
	$xtpl->assign( 'MODULE_NAME', $module_name );
	$xtpl->assign( 'PLAYLIST_ID', $playlist_id );
	$xtpl->assign( 'FAKE_ID', 0 );
	$xtpl->assign( 'PLIST_CHECKSS', $pl_ss);
	$xtpl->assign( 'IMGWIDTH1', $module_config[$module_name]['homewidth'] );
	
	if( !empty($module_config[$module_name]['jwplayer_logo_file']) and file_exists( NV_ROOTDIR .'/'. $module_config[$module_name]['jwplayer_logo_file'] ) )
	{
		$lu = strlen( NV_BASE_SITEURL );
		$module_config[$module_name]['jwplayer_logo_file'] = NV_BASE_SITEURL . $module_config[$module_name]['jwplayer_logo_file'];
	}

	$xtpl->assign( 'VIDEO_CONFIG', $module_config[$module_name] );

	if( ! empty( $playlist_info ) )
	{
		$playlist_info['add_time'] = nv_date( 'H:i d/m/Y', $playlist_info['add_time'] );
		$xtpl->assign( 'PLAYLIST_INFO', $playlist_info );
		if( !empty($playlist_info['description']) )
		{
			$xtpl->parse( 'main.playlist_info.description' );
		}
		
		if( $playlist_info['add_time'] > 0 )
		{
			$xtpl->parse( 'main.playlist_info.time' );
		}
		
		if( $playlist_info['hitstotal'] > 0 )
		{
			$xtpl->parse( 'main.playlist_info.viewed' );
		}
		
		$xtpl->parse( 'main.playlist_info' );
	}

	if( ! empty( $playlist_array ) )
	{
		if( $playlist_id > 0 )
		{
			if(  $module_config[$module_name]['jwplayer_logo'] > 0 and !empty($module_config[$module_name]['jwplayer_logo_file']))
			{				
				$xtpl->parse( 'main.player.player_logo' );
			}
			$xtpl->parse( 'main.player' );
		}
		else
		{
			foreach( $playlist_array as $playlist_array_i )
			{
				$xtpl->assign( 'PLAYLIST_LOOP', $playlist_array_i );
				$xtpl->assign( 'TIME', date( 'H:i', $playlist_array_i['publtime'] ) );
				$xtpl->assign( 'DATE', date( 'd/m/Y', $playlist_array_i['publtime'] ) );

				if( ! empty( $playlist_array_i['src'] ) )
				{
					$xtpl->parse( 'main.playlist_loop.homethumb' );
				}

				if( defined( 'NV_IS_MODADMIN' ) )
				{
					$xtpl->assign( 'ADMINLINK', nv_link_edit_page( $playlist_array_i['id'] ) . ' ' . nv_link_delete_page( $playlist_array_i['id'] ) );
					$xtpl->parse( 'main.playlist_loop.adminlink' );
				}
				$xtpl->parse( 'main.playlist_loop' );
			}
		}
	}
	else
	{
		$xtpl->parse( 'main.no_video_inlist' );
	}

	if( ! empty( $playlist_other_array ) )
	{
		foreach( $playlist_other_array as $playlist_other_array_i )
		{
			$playlist_other_array_i['publtime'] = nv_date( 'H:i d/m/Y', $playlist_other_array_i['publtime'] );

			$xtpl->assign( 'PLAYLIST_OTHER', $playlist_other_array_i );
			$xtpl->parse( 'main.other.loop' );
		}
		$xtpl->parse( 'main.other' );
	}

	if( ! empty( $generate_page ) )
	{
		$xtpl->assign( 'GENERATE_PAGE', $generate_page );
		$xtpl->parse( 'main.generate_page' );
	}

	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function sendmail_themme( $sendmail )
{
	global $module_info, $module_file, $global_config, $lang_module, $lang_global;

	$xtpl = new XTemplate( 'sendmail.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
	$xtpl->assign( 'SENDMAIL', $sendmail );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
	$xtpl->assign( 'GFX_NUM', NV_GFX_NUM );

	if( $global_config['gfx_chk'] > 0 )
	{
		$xtpl->assign( 'CAPTCHA_REFRESH', $lang_global['captcharefresh'] );
		$xtpl->assign( 'CAPTCHA_REFR_SRC', NV_BASE_SITEURL . NV_FILES_DIR . '/images/refresh.png' );
		$xtpl->assign( 'N_CAPTCHA', $lang_global['securitycode'] );
		$xtpl->assign( 'GFX_WIDTH', NV_GFX_WIDTH );
		$xtpl->assign( 'GFX_HEIGHT', NV_GFX_HEIGHT );
		$xtpl->parse( 'main.content.captcha' );
	}

	$xtpl->parse( 'main.content' );

	if( ! empty( $sendmail['result'] ) )
	{
		$xtpl->assign( 'RESULT', $sendmail['result'] );
		$xtpl->parse( 'main.result' );

		if( $sendmail['result']['check'] == true )
		{
			$xtpl->parse( 'main.close' );
		}
	}

	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function news_print( $result )
{
	global $module_info, $module_file, $lang_module;

	$xtpl = new XTemplate( 'print.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
	$xtpl->assign( 'CONTENT', $result );
	$xtpl->assign( 'LANG', $lang_module );

	if( ! empty( $result['image']['width'] ) )
	{
		if( $result['image']['position'] == 1 )
		{
			if( ! empty( $result['image']['note'] ) )
			{
				$xtpl->parse( 'main.image.note' );
			}

			$xtpl->parse( 'main.image' );
		}
		elseif( $result['image']['position'] == 2 )
		{
			if( $result['image']['note'] > 0 )
			{
				$xtpl->parse( 'main.imagefull.note' );
			}

			$xtpl->parse( 'main.imagefull' );
		}
	}

	if( $result['copyright'] == 1 )
	{
		$xtpl->parse( 'main.copyright' );
	}

	if( ! empty( $result['author'] ) or ! empty( $result['source'] ) )
	{
		if( ! empty( $result['author'] ) )
		{
			$xtpl->parse( 'main.author.name' );
		}

		if( ! empty( $result['source'] ) )
		{
			$xtpl->parse( 'main.author.source' );
		}

		$xtpl->parse( 'main.author' );
	}

	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

// Search
function search_theme( $key, $check_num, $date_array, $array_cat_search )
{
	global $module_name, $module_info, $module_file, $lang_module, $module_name;

	$xtpl = new XTemplate( 'search.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
	$xtpl->assign( 'NV_LANG_DATA', NV_LANG_DATA );
	$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
	$xtpl->assign( 'MODULE_NAME', $module_name );
	$xtpl->assign( 'BASE_URL_SITE', NV_BASE_SITEURL . 'index.php' );
	$xtpl->assign( 'TO_DATE', $date_array['to_date'] );
	$xtpl->assign( 'FROM_DATE', $date_array['from_date'] );
	$xtpl->assign( 'KEY', $key );
	$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
	$xtpl->assign( 'OP_NAME', 'search' );

	foreach( $array_cat_search as $search_cat )
	{
		$xtpl->assign( 'SEARCH_CAT', $search_cat );
		$xtpl->parse( 'main.search_cat' );
	}

	for( $i = 0; $i <= 3; ++$i )
	{
		if( $check_num == $i )
		{
			$xtpl->assign( 'CHECK' . $i, 'selected=\'selected\'' );
		}
		else
		{
			$xtpl->assign( 'CHECK' . $i, '' );
		}
	}

	$xtpl->parse( 'main' );
	return $xtpl->text( 'main' );
}

function search_result_theme( $key, $numRecord, $per_pages, $page, $array_content, $catid )
{
	global $module_file, $module_info, $lang_module, $module_name, $global_array_cat, $module_config, $global_config;

	$xtpl = new XTemplate( 'search.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'KEY', $key );
	$xtpl->assign( 'IMG_WIDTH', $module_config[$module_name]['homewidth'] );
	$xtpl->assign( 'TITLE_MOD', $lang_module['search_modul_title'] );

	if( ! empty( $array_content ) )
	{
		foreach( $array_content as $value )
		{
			$catid_i = $value['catid'];

			$xtpl->assign( 'LINK', $global_array_cat[$catid_i]['link'] . '/' . $value['alias'] . "-" . $value['id'] . $global_config['rewrite_exturl'] );
			$xtpl->assign( 'TITLEROW', strip_tags( BoldKeywordInStr( $value['title'], $key ) ) );
			$xtpl->assign( 'CONTENT', BoldKeywordInStr( $value['hometext'], $key ) . "..." );
			$xtpl->assign( 'TIME', date( 'd/m/Y h:i:s A', $value['publtime'] ) );
			$xtpl->assign( 'AUTHOR', BoldKeywordInStr( $value['author'], $key ) );
			$xtpl->assign( 'SOURCE', BoldKeywordInStr( GetSourceNews( $value['sourceid'] ), $key ) );

			if( ! empty( $value['homeimgfile'] ) )
			{
				$xtpl->assign( 'IMG_SRC', $value['homeimgfile'] );
				$xtpl->parse( 'results.result.result_img' );
			}

			$xtpl->parse( 'results.result' );
		}
	}

	if( $numRecord == 0 )
	{
		$xtpl->assign( 'KEY', $key );
		$xtpl->assign( 'INMOD', $lang_module['search_modul_title'] );
		$xtpl->parse( 'results.noneresult' );
	}

	if( $numRecord > $per_pages ) // show pages
	{
		$url_link = $_SERVER['REQUEST_URI'];
		if( strpos( $url_link, '&page=' ) > 0 )
		{
			$url_link = substr( $url_link, 0, strpos( $url_link, '&page=' ) );
		}
		elseif( strpos( $url_link, '?page=' ) > 0 )
		{
			$url_link = substr( $url_link, 0, strpos( $url_link, '?page=' ) );
		}
		$_array_url = array( 'link' => $url_link, 'amp' => '&page=' );
		$generate_page = nv_generate_page( $_array_url, $numRecord, $per_pages, $page );

		$xtpl->assign( 'VIEW_PAGES', $generate_page );
		$xtpl->parse( 'results.pages_result' );
	}

	$xtpl->assign( 'NUMRECORD', $numRecord );
	$xtpl->assign( 'MY_DOMAIN', NV_MY_DOMAIN );

	$xtpl->parse( 'results' );
	return $xtpl->text( 'results' );
}