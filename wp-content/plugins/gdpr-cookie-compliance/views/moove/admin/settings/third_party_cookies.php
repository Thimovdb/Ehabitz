<?php
    $gdpr_default_content = new Moove_GDPR_Content();
    $option_name    = $gdpr_default_content->moove_gdpr_get_option_name();
    $gdpr_options   = get_option( $option_name );
    $wpml_lang      = $gdpr_default_content->moove_gdpr_get_wpml_lang();
    $gdpr_options   = is_array( $gdpr_options ) ? $gdpr_options : array();
    $empty_scripts  = false;
    if ( isset( $_POST ) && isset( $_POST['moove_gdpr_nonce'] ) ) :
        $nonce = sanitize_key( $_POST['moove_gdpr_nonce'] );
        if ( ! wp_verify_nonce( $nonce, 'moove_gdpr_nonce_field' ) ) :
            die( 'Security check' );
        else :
            if ( is_array( $_POST ) ) :
                if ( isset( $_POST['moove_gdpr_third_party_cookies_enable'] ) && intval( $_POST['moove_gdpr_third_party_cookies_enable'] ) === 1 ) :
                    $value  = 1;
                else :
                    $value  = 0;
                endif;
                if ( $value === 1 ) :
                    if ( ( isset( $_POST[ 'moove_gdpr_third_party_header_scripts' ] ) && strlen( $_POST[ 'moove_gdpr_third_party_header_scripts' ] ) == 0 ) && ( isset( $_POST[ 'moove_gdpr_third_party_body_scripts' ] ) && strlen( $_POST[ 'moove_gdpr_third_party_body_scripts' ] ) == 0 ) && ( isset( $_POST[ 'moove_gdpr_third_party_footer_scripts' ] ) && strlen( $_POST[ 'moove_gdpr_third_party_footer_scripts' ] ) == 0 ) ) :
                        $empty_scripts = true;
                    endif;
                endif;
                if ( ! $empty_scripts ) :
                    $gdpr_options['moove_gdpr_third_party_cookies_enable'] = $value;
                    update_option( $option_name, $gdpr_options );
                    $gdpr_options = get_option( $option_name );
                    foreach ( $_POST as $form_key => $form_value ) :
                        if ( $form_key === 'moove_gdpr_performance_cookies_tab_content' ) :
                            $value  = wp_unslash( $form_value );
                            $gdpr_options[$form_key.$wpml_lang]    = $value;
                            update_option( $option_name, $gdpr_options );
                            $gdpr_options               = get_option( $option_name );                        
                        elseif ( $form_key === 'moove_gdpr_third_party_header_scripts' || $form_key === 'moove_gdpr_third_party_body_scripts' || $form_key === 'moove_gdpr_third_party_footer_scripts' ) :
                            $value                      = wp_unslash( $form_value );
                            $gdpr_options[$form_key]    = maybe_serialize( $value );
                            update_option( $option_name, $gdpr_options );
                            $gdpr_options               = get_option( $option_name );
                        elseif ( $form_key !== 'moove_gdpr_third_party_cookies_enable' ) :
                            $value                      = sanitize_text_field( wp_unslash( $form_value ) );
                            $gdpr_options[$form_key]    = $value;
                            update_option( $option_name, $gdpr_options );
                            $gdpr_options               = get_option( $option_name );
                        endif;
                    endforeach;
                endif;
            endif;
            ?>
            <?php if ( $empty_scripts ) : ?>
                <script>
                    jQuery('#moove-gdpr-setting-error-settings_updated').hide();
                    jQuery('#moove-gdpr-setting-error-settings_scripts_empty').show();
                </script>

            <?php else : ?>
                <script>
                    jQuery('#moove-gdpr-setting-error-settings_scripts_empty').hide();
                    jQuery('#moove-gdpr-setting-error-settings_updated').show();
                </script>
            <?php endif;
        endif;
    endif;
?>
<br />
<?php
    $nav_label  = isset( $gdpr_options['moove_gdpr_performance_cookies_tab_title'.$wpml_lang] ) && $gdpr_options['moove_gdpr_performance_cookies_tab_title'.$wpml_lang] ? $gdpr_options['moove_gdpr_performance_cookies_tab_title'.$wpml_lang] : __('3rd Party Cookies','moove-gdpr');
?>
<h2><?php echo $nav_label; ?></h2>
<hr />
<form action="?page=moove-gdpr&amp;tab=third_party_cookies" method="post" id="moove_gdpr_tab_third_party_cookies">
    <?php wp_nonce_field( 'moove_gdpr_nonce_field', 'moove_gdpr_nonce' ); ?>
    <table class="form-table <?php echo $empty_scripts ? 'moove-gdpr-form-error' : ''; ?>">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="moove_gdpr_third_party_cookies_enable"><?php _e('Turn','moove-gdpr'); ?></label>
                </th>
                <td>
                    <input name="moove_gdpr_third_party_cookies_enable" type="radio" value="1" id="moove_gdpr_third_party_cookies_enable_on" <?php echo isset( $gdpr_options['moove_gdpr_third_party_cookies_enable'] ) ? ( intval( $gdpr_options['moove_gdpr_third_party_cookies_enable'] ) === 1  ? 'checked' : '' ) : 'checked'; ?> class="regular-text on-off"> <label for="moove_gdpr_third_party_cookies_enable_on"><?php _e('On','moove-gdpr'); ?></label> <span class="separator"></span>
                    <input name="moove_gdpr_third_party_cookies_enable" type="radio" value="0" id="moove_gdpr_third_party_cookies_enable_off" <?php echo isset( $gdpr_options['moove_gdpr_third_party_cookies_enable'] ) ? ( intval( $gdpr_options['moove_gdpr_third_party_cookies_enable'] ) === 0  ? 'checked' : '' ) : 'checked'; ?> class="regular-text on-off"> <label for="moove_gdpr_third_party_cookies_enable_off"><?php _e('Off','moove-gdpr'); ?></label>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="moove_gdpr_third_party_cookies_enable_first_visit"><?php _e('Enable by default','moove-gdpr'); ?></label>
                </th>
                <td>
                    <input name="moove_gdpr_third_party_cookies_enable_first_visit" type="radio" value="0" id="moove_gdpr_third_party_cookies_enable_first_visit_off" <?php echo isset( $gdpr_options['moove_gdpr_third_party_cookies_enable_first_visit'] ) ? ( intval( $gdpr_options['moove_gdpr_third_party_cookies_enable_first_visit'] ) === 0  ? 'checked' : '' ) : 'checked'; ?> class="regular-text on-off"> <label for="moove_gdpr_third_party_cookies_enable_first_visit_off"><?php _e('Disable','moove-gdpr'); ?></label> <span class="separator"></span>
                    
                    <input name="moove_gdpr_third_party_cookies_enable_first_visit" type="radio" value="1" id="moove_gdpr_third_party_cookies_enable_first_visit_on" <?php echo isset( $gdpr_options['moove_gdpr_third_party_cookies_enable_first_visit'] ) ? ( intval( $gdpr_options['moove_gdpr_third_party_cookies_enable_first_visit'] ) === 1  ? 'checked' : '' ) : ''; ?> class="regular-text on-off"> <label for="moove_gdpr_third_party_cookies_enable_first_visit_on"><?php _e('Enable','moove-gdpr'); ?></label>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="moove_gdpr_performance_cookies_tab_title"><?php _e('Tab Title','moove-gdpr'); ?></label>
                </th>
                <td>
                    <input name="moove_gdpr_performance_cookies_tab_title<?php echo $wpml_lang; ?>" type="text" id="moove_gdpr_performance_cookies_tab_title" value="<?php echo $nav_label; ?>" class="regular-text">
                </td>
            </tr>

            <tr>
                <th scope="row" colspan="2" style="padding-bottom: 0;">
                    <label for="moove_gdpr_performance_cookies_tab_content"><?php _e('Tab Content','moove-gdpr'); ?></label>
                </th>
            </tr>
            <tr class="moove_gdpr_table_form_holder">
                <th colspan="2" scope="row">
                    <?php
                        $content =  isset( $gdpr_options['moove_gdpr_performance_cookies_tab_content'.$wpml_lang] ) && $gdpr_options['moove_gdpr_performance_cookies_tab_content'.$wpml_lang] ? wp_unslash( $gdpr_options['moove_gdpr_performance_cookies_tab_content'.$wpml_lang] ) : false;
                        if ( ! $content ) :
                            $content    = $gdpr_default_content->moove_gdpr_get_third_party_content();
                        endif;
                        ?>
                    <?php
                        $settings = array (
                            'media_buttons'     =>  false,
                            'editor_height'     =>  150,
                        );
                        wp_editor( $content, 'moove_gdpr_performance_cookies_tab_content', $settings );
                    ?>
                </th>
            </tr>

            <tr>
                <th scope="row" colspan="2" style="padding-bottom: 0;">
                    <div class="alert script-error" style="display: none;"><?php _e('Please fill out at least one of these fields:','moove-gdpr'); ?></div>
                </th>
            </tr>

            <tr>
                <th scope="row" colspan="2" style="padding-bottom: 0;">
                    <label for="moove_gdpr_third_party_header_scripts"><?php _e('The below script will be added to the page HEAD section if user enables this cookie.','moove-gdpr'); ?></label>
                </th>
            </tr>
            <tr class="moove_gdpr_third_party_header_scripts">
                <th scope="row" colspan="2">
                    <?php $content =  isset( $gdpr_options['moove_gdpr_third_party_header_scripts'] ) && $gdpr_options['moove_gdpr_third_party_header_scripts'] ? maybe_unserialize( $gdpr_options['moove_gdpr_third_party_header_scripts'] ) : '';
                    ?>
                    <textarea name="moove_gdpr_third_party_header_scripts" id="moove_gdpr_third_party_header_scripts" class="large-text code" rows="13"><?php echo $content; ?></textarea>
                    <p class="description" id="moove_gdpr_third_party_header_scripts-description"><?php _e('For example, you can use it for Google Tag Manager script or any other 3rd party code snippets.','moove-gdpr'); ?></p>
                </th>
            </tr>


            <tr>
                <th scope="row" colspan="2" style="padding-bottom: 0;">
                    <label for="moove_gdpr_third_party_body_scripts"><?php _e('The below script will be added right after the BODY section if user enables this cookie.','moove-gdpr'); ?></label>
                </th>
            </tr>
            <tr class="moove_gdpr_third_party_body_scripts">
                <th scope="row" colspan="2">
                    <?php $content =  isset( $gdpr_options['moove_gdpr_third_party_body_scripts'] ) && $gdpr_options['moove_gdpr_third_party_body_scripts'] ? maybe_unserialize( $gdpr_options['moove_gdpr_third_party_body_scripts'] ) : '';
                    ?>
                    <textarea name="moove_gdpr_third_party_body_scripts" id="moove_gdpr_third_party_body_scripts" class="large-text code" rows="13"><?php echo $content; ?></textarea>
                    <p class="description" id="moove_gdpr_third_party_body_scripts-description"><?php _e('For example, you can use it for Google Tag Manager script or any other 3rd party code snippets.','moove-gdpr'); ?></p>
                </th>
            </tr>


            <tr>
                <th scope="row" colspan="2" style="padding-bottom: 0;">
                    <label for="moove_gdpr_third_party_footer_scripts"><?php _e('The below script will be added to the page FOOTER section if user enables this cookie.','moove-gdpr'); ?></label>
                </th>
            </tr>
            <tr class="moove_gdpr_third_party_footer_scripts">
                <th scope="row" colspan="2">
                    <?php $content =  isset( $gdpr_options['moove_gdpr_third_party_footer_scripts'] ) && $gdpr_options['moove_gdpr_third_party_footer_scripts'] ? maybe_unserialize( $gdpr_options['moove_gdpr_third_party_footer_scripts'] ) : '';
                    ?>
                    <textarea name="moove_gdpr_third_party_footer_scripts" id="moove_gdpr_third_party_footer_scripts" class="large-text code" rows="13"><?php echo $content; ?></textarea>
                    <p class="description" id="moove_gdpr_third_party_footer_scripts-description"><?php _e('For example, you can use it for Google Analytics script or any other 3rd party code snippets.','moove-gdpr'); ?></p>
                </th>
            </tr>
        </tbody>
    </table>

    <hr />
    <br />
    <button type="submit" class="button button-primary"><?php _e('Save changes','moove-gdpr'); ?></button>
</form>