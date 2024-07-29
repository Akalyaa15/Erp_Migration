
<?php if($client_info->partner_id){ ?>
<style>
#sidebar-menu > li.active > a {
    border-left: 2px solid #141C27;
    background-color: #1d2632;
    color: #7988a2;
}
#sidebar-menu li a.sss{
     border-left: 2px solid #00b393;
    background-color: #141C27;
    color: #fff;
}
</style><?php } ?>
<?php if($client_info->partner_id){ ?>
<style>
#group_id {
    display: none;
}

</style>
<?php } ?>
<?php $this->load->view("includes/cropbox"); ?>
<div id="page-content" class="clearfix">
    <div class="row bg-dark-success p20">
        <div class="col-md-6">
            <?php $this->load->view("users/profile_image_section"); ?>
        </div>
        <div class="col-md-6">
            <p> 
                <?php
                $client_link = anchor(get_uri("clients_register/view/" . $client_info->id), $client_info->company_name, array("class" => "white-link"));

                if ($this->login_user->user_type === "client") {
                    $client_link = anchor(get_uri("clients_register/contact_profile/" . $this->login_user->id . "/company"), $client_info->company_name, array("class" => "white-link"));
                }

                echo lang("company_name") . ": <b>" . $client_link . "</b>";
                ?>

            </p>
            <?php if ($client_info->address) { ?>
                <p><?php echo nl2br($client_info->address); ?>
                    <?php if ($client_info->city) { ?>
                        <br /><?php echo $client_info->city; ?>
                    <?php } ?>
                    <?php if ($client_info->state) { ?>
                        <br /><!-- <?php echo $client_info->state; ?> --><?php   if($client_info->state){
$state_no = is_numeric($client_info->state);
 if(!$state_no){
   $client_info->state = 0;
 }
}
$options = array(
            "id" => $client_info->state,
                   );
        $state_id_name = $this->States_model->get_details($options)->row();
        $state_dummy_name =$state_id_name->title;
        echo $state_dummy_name;
        ?>
                    <?php } ?>
                    <?php if ($client_info->zip) { ?>
                        <br /><?php echo $client_info->zip; ?>
                    <?php } ?>
                    <?php if ($client_info->country) { ?>
                        <br /><!-- <?php echo $client_info->country; ?> --><?php  
if($client_info->country){
$country_no = is_numeric($client_info->country);
 if(!$country_no){
   $client_info->country = 0;
 }
}
$options = array(
            "id" => $client_info->country,
                   );
        $country_id_name = $this->Countries_model->get_details($options)->row();
        $country_dummy_name =$country_id_name->countryName;
        echo $country_dummy_name;
        ?>
                    <?php } ?>
                </p>
                <p>
                    <?php
                    if ($client_info->website) {
                        $website = to_url($client_info->website);
                        echo lang("website") . ": " . "<a target='_blank' href='" . $website . "' class='white-link'>$website</a>";
                        ?>
                    <?php } ?>
                    <?php if ($client_info->gst_number) { ?>
                        <br /><?php echo lang("gst_number") . ": " . $client_info->gst_number; ?>
                    <?php } ?>  
                </p>
            <?php } ?>
        </div>
    </div>


    <ul data-toggle="ajax-tab" class="nav nav-tabs" role="tablist">
        <li><a  role="presentation" href="<?php echo_uri("clients_register/contact_general_info_tab/" . $user_info->id); ?>" data-target="#tab-general-info"> <?php echo lang('general_info'); ?></a></li>
        <li><a  role="presentation" href="<?php echo_uri("clients_register/company_info_tab/" . $user_info->client_id); ?>" data-target="#tab-company-info"> <?php echo lang('company'); ?></a></li>
        <li><a  role="presentation" href="<?php echo_uri("clients_register/contact_social_links_tab/" . $user_info->id); ?>" data-target="#tab-social-links"> <?php echo lang('social_links'); ?></a></li>
        <li><a role="presentation" href="<?php echo_uri("clients_register/account_settings/" . $user_info->id); ?>" data-target="#tab-account-settings"> <?php echo lang('account_settings'); ?></a></li>
        <?php if ($user_info->id == $this->login_user->id) { ?>
            <li><a role="presentation" href="<?php echo_uri("clients_register/my_preferences/" . $user_info->id); ?>" data-target="#tab-my-preferences"> <?php echo lang('my_preferences'); ?></a></li>
        <?php } ?>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade" id="tab-general-info"></div>
        <div role="tabpanel" class="tab-pane fade" id="tab-company-info"></div>
        <div role="tabpanel" class="tab-pane fade" id="tab-social-links"></div>
        <div role="tabpanel" class="tab-pane fade" id="tab-account-settings"></div>
        <div role="tabpanel" class="tab-pane fade" id="tab-my-preferences"></div>

    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".upload").change(function () {
            if (typeof FileReader == 'function') {
                showCropBox(this);
            } else {
                $("#profile-image-form").submit();
            }
        });
        $("#profile_image").change(function () {
            $("#profile-image-form").submit();
        });


        $("#profile-image-form").appForm({
            isModal: false,
            beforeAjaxSubmit: function (data) {
                $.each(data, function (index, obj) {
                    if (obj.name === "profile_image") {
                        var profile_image = replaceAll(":", "~", data[index]["value"]);
                        data[index]["value"] = profile_image;
                    }
                });
            },
            onSuccess: function (result) {
                if (typeof FileReader == 'function') {
                    appAlert.success(result.message, {duration: 10000});
                } else {
                    location.reload();
                }
            }
        });

        var tab = "<?php echo $tab; ?>";
        if (tab === "general") {
            $("[data-target=#tab-general-info]").trigger("click");
        } else if (tab === "company") {
            $("[data-target=#tab-company-info]").trigger("click");
        } else if (tab === "account") {
            $("[data-target=#tab-account-settings]").trigger("click");
        } else if (tab === "social") {
            $("[data-target=#tab-social-links]").trigger("click");
        } else if (tab === "my_preferences") {
            $("[data-target=#tab-my-preferences]").trigger("click");
        }

    });
</script>