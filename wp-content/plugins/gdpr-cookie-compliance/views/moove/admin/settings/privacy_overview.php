<?php
    $gdpr_default_content = new Moove_GDPR_Content();
    $option_name    = $gdpr_default_content->moove_gdpr_get_option_name();
    $gdpr_options   = get_option( $option_name );
    $wpml_lang      = $gdpr_default_content->moove_gdpr_get_wpml_lang();
    $gdpr_options   = is_array( $gdpr_options ) ? $gdpr_options : array();
    if ( isset( $_POST ) && isset( $_POST['moove_gdpr_nonce'] ) ) :
        $nonce = sanitize_key( $_POST['moove_gdpr_nonce'] );
        if ( ! wp_verify_nonce( $nonce, 'moove_gdpr_nonce_field' ) ) :
            die( 'Security check' );
        else :
            if ( is_array( $_POST ) ) :
                foreach ( $_POST as $form_key => $form_value ) :
                    if ( $form_key === 'moove_gdpr_privacy_overview_tab_content' ) :
                        $value  = wp_unslash( $form_value );
                        $gdpr_options[$form_key.$wpml_lang] = $value;
                        update_option( $option_name, $gdpr_options );
                        $gdpr_options = get_option( $option_name );
                    else :
                        $value  = sanitize_text_field( wp_unslash( $form_value ) );
                        $gdpr_options[$form_key] = $value;
                        update_option( $option_name, $gdpr_options );
                        $gdpr_options = get_option( $option_name );
                    endif;
                endforeach;
            endif;
            ?>
                <script>
                    jQuery('#moove-gdpr-setting-error-settings_updated').show();
                </script>
            <?php
        endif;
    endif;
?>
<br />

<?php
    $nav_label  = isset( $gdpr_options['moove_gdpr_privacy_overview_tab_title'.$wpml_lang] ) && $gdpr_options['moove_gdpr_privacy_overview_tab_title'.$wpml_lang] ? $gdpr_options['moove_gdpr_privacy_overview_tab_title'.$wpml_lang] : __('Privacy Overview','moove-gdpr');
?>

<h2><?php echo $nav_label; ?></h2>
<hr />
<form action="?page=moove-gdpr&amp;tab=privacy_overview" method="post" id="moove_gdpr_tab_privacy_overview">
    <?php wp_nonce_field( 'moove_gdpr_nonce_field', 'moove_gdpr_nonce' ); ?>
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="moove_gdpr_privacy_overview_tab_title"><?php _e('Tab Title','moove-gdpr'); ?></label>
                </th>
                <td>
                    <input name="moove_gdpr_privacy_overview_tab_title<?php echo $wpml_lang; ?>" type="text" id="moove_gdpr_privacy_overview_tab_title" value="<?php echo $nav_label; ?>" class="regular-text">
                </td>
            </tr>

            <tr>
                <th scope="row" colspan="2" style="padding-bottom: 0;">
                    <label for="moove_gdpr_privacy_overview_tab_content"><?php _e('Tab Content','moove-gdpr'); ?></label>
                </th>
            </tr>
            <tr class="moove_gdpr_table_form_holder">
                <th colspan="2" scope="row">
                    <?php
                        $content =  isset( $gdpr_options['moove_gdpr_privacy_overview_tab_content'.$wpml_lang] ) && $gdpr_options['moove_gdpr_privacy_overview_tab_content'.$wpml_lang] ? wp_unslash( $gdpr_options['moove_gdpr_privacy_overview_tab_content'.$wpml_lang] ) : false;
                        if ( ! $content ) :
                            $content    = $gdpr_default_content->moove_gdpr_get_privacy_overview_content();
                        endif;
                        ?>
                    <?php
                        $settings = array (
                            'media_buttons'     =>  false,
                            'editor_height'     =>  150,
                        );
                        wp_editor( $content, 'moove_gdpr_privacy_overview_tab_content', $settings );
                    ?>
                </th>
            </tr>
        </tbody>
    </table>

    <hr />
    <br />
    <button type="submit" class="button button-primary"><?php _e('Save changes','moove-gdpr'); ?></button>
</form>