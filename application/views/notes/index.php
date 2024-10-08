<div id="page-content" class="p20 clearfix">
    <div class="panel panel-default">
        <a class="btn btn-primary" href="javascript:window.history.go(-1);">❮ Go Back</a>
        <div class="page-title clearfix">
            <h1> <?php echo lang('notes') . " (" . lang('private') . ")"; ?></h1>
            <div class="title-button-group">
                <?php echo modal_anchor(get_uri("notes/modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_note'), array("class" => "btn btn-default", "title" => lang('add_note'))); ?>
            </div>
        </div>
        <div class="table-responsive">
            <table id="note-table" class="display" cellspacing="0" width="100%">            
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#note-table").appTable({
            source: '<?php echo_uri("notes/list_data") ?>',
            order: [[0, 'desc']],
            columns: [
                {targets: [1], visible: false},
                {title: '<?php echo lang("created_date"); ?>', "class": "w200"},
                {title: '<?php echo lang("title"); ?>'},
                {title: '<?php echo lang("files") ?>', "class": "w250"},
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w100"}
            ]
        });
    });
</script>