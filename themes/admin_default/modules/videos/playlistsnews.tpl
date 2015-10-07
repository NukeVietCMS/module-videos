<!-- BEGIN: main -->
<div id="module_show_list">
	<!-- BEGIN: data -->
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th class="w20">&nbsp;</th>
					<th class="w100">{LANG.weight}</th>
					<th>{LANG.name}</th>
					<th class="w100">&nbsp;</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="3"><em class="fa fa-check-square-o fa-lg">&nbsp;</em> <a id="checkall" href="javascript:void(0);">{LANG.checkall}</a>&nbsp;&nbsp; <em class="fa fa-square-o ">&nbsp;</em> <a id="uncheckall" href="javascript:void(0);">{LANG.uncheckall}</a>&nbsp;&nbsp; </span><span style="width:100px;display:inline-block">&nbsp;</span> <em class="fa fa-trash-o fa-lg">&nbsp;</em> <a id="delete-playlist" href="{URL_DELETE}">{LANG.playlist_del}</a></td>
				</tr>
			</tfoot>
			<tbody>
				<!-- BEGIN: loop -->
				<tr>
					<td><input type="checkbox" name="newsid" value="{ROW.id}"/></td>
					<td class="text-center">
					<select class="form-control" id="id_playlist_sort_{ROW.id}" onchange="nv_change_playlist_sort('{ROW.playlist_id}','{ROW.id}','playlist_sort');">
						<!-- BEGIN: playlist_sort -->
						<option value="{PLAYLIST_SORT.key}"{PLAYLIST_SORT.selected}>{PLAYLIST_SORT.title}</option>
						<!-- END: playlist_sort -->
					</select>
					</td>
					<td class="text-left"><a target="_blank" href="{ROW.link}">{ROW.title}</a></td>
					<td class="text-center">{ROW.delete}</td>
				</tr>
				<!-- END: loop -->
			</tbody>
		</table>
	</div>
	<!-- END: data -->
	<!-- BEGIN: empty -->
	<div class="alert alert-warning">{LANG.playlist_nonews}</div>
	<!-- END: empty -->
</div>
<script type="text/javascript">
var LANG = [];
var CFG = [];
LANG.playlist_nocheck = '{LANG.playlist_nocheck}';
LANG.playlist_delete_confirm = '{LANG.playlist_delete_confirm}';
CFG.playlist_id = '{playlist_id}';
</script>
<!-- END: main -->