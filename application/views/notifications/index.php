<div id="page-content" class="p20 clearfix">
    <div class="panel panel-default">
         <a class="btn btn-primary" href="javascript:window.history.go(-1);">❮ Go Back</a>
       <div class="page-title clearfix">
            <h4> <?php echo lang('notifications'); ?></h4>
        </div>
        <div>
            <?php
            $view_data["notifications"] = $notifications;

            $this->load->view("notifications/list_data", $view_data);
            ?>
        </div>
    </div>
</div>
