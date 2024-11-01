<div class="vcw-licensing">
    <?php
    $extensions = apply_filters('vcw_active_extensions', []);
    if (!empty($extensions)):
        ?>
        <div class="vcw-licensing-items">
            <?php foreach ($extensions as $extension) { ?>
                <div class="vcw-licensing-item">
                    <?php do_action('vcw_license_form_' . $extension); ?>
                </div>
            <?php } ?>
        </div>
    <?php else: ?>
        <div class="vcw-licensing-products">
            <h3><?php
            printf('Elevate your online meetings with Webex Extensions, check them out <a href="%s" target="_blank" rel="noopener">Codemanas</a>',
                esc_url('https://www.codemanas.com/downloads/webex-for-woocommerce/'));
            ?></h3>
        </div>
    <?php endif; ?>
</div>