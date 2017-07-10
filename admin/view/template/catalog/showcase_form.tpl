<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-option" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-option" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <div class="input-group">
                <input type="text" name="title" value="<?php echo isset($title) ? $title : ''; ?>" placeholder="<?php echo $entry_name; ?>" class="form-control" />
              </div>
            </div>
          </div>
            <div class="form-group required">
            <label class="col-sm-2 control-label"><?php echo $entry_category; ?></label>
            <div class="col-sm-10">
              <div class="input-group">
                <select name="category" class="form-control" >
                    <?php foreach($categories as $category) { ?>
                        <option <?php if($category_id == $category['category_id']) { echo "selected='selected'"; } ?> value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                    <?php } ?>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10">
              <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
            </div>
          </div>
          <table id="showcase-command" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-left required"><?php echo $entry_showcase_command; ?></td>
				<td class="text-right"><?php echo $entry_showcase_result; ?></td>
				<td class="text-right"><?php echo $entry_showcase_is_edit; ?></td>
                <td class="text-right"><?php echo $entry_sort_order; ?></td>
                <td></td>
              </tr>
            </thead>
            <tbody>
              <?php $showcase_command_row = 0; ?>
              <?php foreach ($showcase_commands as $showcase_command) { ?>
              <tr id="showcase-command-row<?php echo $showcase_command_row; ?>">
                <td class="text-left">
					<input type="hidden" name="showcase_command[<?php echo $showcase_command_row; ?>][showcase_command_id]" value="<?php echo $showcase_command['showcase_command_id']; ?>" />
					<input type="text" name="showcase_command[<?php echo $showcase_command_row; ?>][command]" value="<?php echo $showcase_command['command']; ?>" placeholder="<?php echo $entry_showcase_command; ?>" class="form-control" /></td>
				<td class="text-right"><textarea name="showcase_command[<?php echo $showcase_command_row; ?>][result]" class="form-control"><?php echo $showcase_command['result']; ?></textarea></td>
				<td class="text-right"><input type="checkbox" name="showcase_command[<?php echo $showcase_command_row; ?>][is_edit]" value="1" <?php echo $showcase_command['is_edit'] ? "checked='checked'" : ""; ?> class="form-control" /></td>
                <td class="text-right"><input type="text" name="showcase_command[<?php echo $showcase_command_row; ?>][sort_order]" value="<?php echo $showcase_command['sort_order']; ?>" class="form-control" /></td>
                <td class="text-left"><button type="button" onclick="$('#showcase-command-row<?php echo $showcase_command_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
              </tr>
              <?php $showcase_command_row++; ?>
              <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="4"></td>
                <td class="text-left"><button type="button" onclick="addShowcaseCommand();" data-toggle="tooltip" title="<?php echo $button_showcase_command_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
              </tr>
            </tfoot>
          </table>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
var showcase_value_row = <?php echo $showcase_command_row; ?>;

function addShowcaseCommand() {
	html  = '<tr id="showcase-command-row' + showcase_value_row + '">';	
    html += '  <td class="text-left"><input type="hidden" name="showcase_command[' + showcase_value_row + '][showcase_command_id]" value="" />';
	html += '      <input type="text" name="showcase_command[' + showcase_value_row + '][command]" value="" placeholder="<?php echo $entry_showcase_command; ?>" class="form-control" />';
	html += '  </td>';
	html += '  <td class="text-right"><textarea name="showcase_command[' + showcase_value_row + '][result]" class="form-control"></textarea></td>';
	html += '  <td class="text-right"><input type="checkbox" value="1" name="showcase_command[' + showcase_value_row + '][is_edit]" class="form-control" /></td>';
	html += '  <td class="text-right"><input type="text" name="showcase_command[' + showcase_value_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#showcase-command-row' + showcase_value_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';	
	
	$('#showcase-command tbody').append(html);
	
	showcase_value_row++;
}
//--></script></div>
<?php echo $footer; ?>